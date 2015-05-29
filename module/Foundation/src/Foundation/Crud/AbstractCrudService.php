<?php

namespace Foundation\Crud;

use Zend\Stdlib\Parameters;
use Zend\Paginator\Paginator;
use Foundation\AbstractRepository;
use Foundation\Entity\EntityInterface;
use Foundation\AbstractFilter as Filter;
use Foundation\AbstractService as Service;
use Foundation\Exception\NotFoundException;
use Foundation\Exception\BadRequestException;
use Foundation\Exception\ValidationException;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Foundation\Crud\AbstractCrudRepository as CrudRepository;

abstract class AbstractCrudService extends Service
{
    protected $repository;
    protected $filter;

    const FETCH_ENTITY = 1;
    const FETCH_RAW = 2;

    /**
     * @param ServiceLocatorInterface $serviceManager
     * @param AbstractCrudRepository $repository
     * @param Filter $filter
     */
    public function __construct(ServiceLocatorInterface $serviceManager, CrudRepository $repository, Filter $filter)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
        $this->filter = $filter;
    }

    /**
     * Hydrates
     * @param array $data
     * @return EntityInterface
     */
    public function hydrate(array $data)
    {
        $entityClass = $this->repository->getClassName();

        return $this->getHydrator()->hydrate($data, new $entityClass());
    }

    public function getHydrator()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $hydrator = new DoctrineObject($em);

        return $hydrator;
    }

    public function extract(EntityInterface $object)
    {
        return $this->getHydrator()->extract($object);
    }

    public function extractList(array $list)
    {
        $data = [];
        foreach ($list as $entity) {
            $data[] = $this->extract($entity);
        }

        return $data;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function save($data)
    {
        $this->filter->setData($data);

        if (!$this->filter->isValid()) {
            throw new ValidationException($this->translate('validation.generic_failed'), $this->filter->getMessages());
        }

        // Hydrates the filtered data into corresponding Entity Object
        $entity = $this->hydrate($this->filter->getValues());

        return $this->repository->save($entity);
    }

    /**
     * Fetches list of Doctrine entites from the repository with Pagination
     *
     * @param Parameters $query
     * @param array $params
     * @return array
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function fetchList(Parameters $query, array $params)
    {
        $max = (int)$query->get('max', AbstractRepository::PAGINATION_MAX_ROWS);
        $page = (int)$query->get('page', 1);

        if ($page < 1) {
            throw new BadRequestException($this->translate('exception.invalid_page'));
        }

        $doctrinePaginator = $this->repository->fetchList();

        $paginator = new Paginator(new DoctrinePaginator($doctrinePaginator));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage($max);

        $items = $paginator->getIterator()->getArrayCopy();
        $total = $paginator->getTotalItemCount();

        $noOfPages = $paginator->count();

        if ($total > 0) {
            if ($page > $noOfPages) {
                throw new NotFoundException($this->translate('exception.page_not_found'));
            }
        }

        $pages = $paginator->getPages('Sliding');

        $links = [];

        $pageLink = function ($page) use ($query, $params) {
            return $params['baseUri'] . '?' . http_build_query($query->set('page', $page)->toArray());;
        };

        foreach ($pages->pagesInRange as $p) {
            $links['pages'][$p] = $pageLink($p);
        }

        if (isset($pages->previous)) {
            $links['prev'] = $pageLink($pages->previous);
        }
        if (isset($pages->next)) {
            $links['next'] = $pageLink($pages->next);
        }

        return compact('items', 'total', 'paginator', 'links', 'max', 'noOfPages', 'page');
    }

    /**
     * @param $id
     * @throws NotFoundException
     */
    public function remove($id)
    {
        $entity = $this->fetch($id);
        $this->repository->remove($entity);
    }

    /**
     * @param $id
     * @param int $mode
     * @return object
     * @throws NotFoundException
     */
    public function fetch($id, $mode = self::FETCH_ENTITY)
    {
        $entity = $this->repository->find($id);
        if ($entity === null) {
            throw new NotFoundException($this->translate('exception.item_not_found'));
        }

        return $entity;
    }

}
