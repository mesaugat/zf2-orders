<?php

namespace Foundation\Crud;

use Foundation\AbstractRepository;
use InvalidArgumentException;
use Foundation\AbstractService as Service;
use Foundation\Exception\NotFoundException;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;
use Foundation\Crud\AbstractCrudRepository as CrudRepository;

abstract class AbstractCrudService extends Service
{
    protected $form;
    protected $repository;

    /**
     * @param ServiceLocatorInterface $serviceManager
     * @param AbstractCrudRepository $repository
     * @param Form $form
     */
    public function __construct(ServiceLocatorInterface $serviceManager, CrudRepository $repository, Form $form)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
        $this->form = $form;
    }

    /**
     * @param $data
     * @return bool
     */
    public function save($data)
    {
        $this->form->setData($data);

        if ($this->form->isValid()) {
            $entity = $this->repository->save($this->form->getData());

            return $this->isEntityInstance($entity);
        }

        return false;
    }

    /**
     * Bind an object to the form
     *
     * @param object $object
     */
    public function bindToForm($object)
    {
        $this->form->bind($object);
    }


    /**
     * Fetches list of Doctrine entites from the repository with Pagination
     *
     * @param string $baseUri Base uri of listing page for Pagination
     * @param Parameters $query
     * @return array
     * @throws NotFoundException
     */
    public function fetchList($baseUri, Parameters $query)
    {
        $max = (int)$query->get('max', AbstractRepository::PAGINATION_MAX_ROWS);
        $page = (int)$query->get('page', 1);

        if ($page < 1) {
            throw new InvalidArgumentException($this->translate('exception.invalid_page'));
        }

        $offset = ($page - 1) * $max;

        $list = $this->repository->fetchList($offset, $max);
        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();
        $noOfPages = (int)(ceil($total / $max)) ?: 1;

        if ($total > 0) {
            if ($page > $noOfPages || $page < 1) {
                throw new NotFoundException($this->translate('exception.page_not_found'));
            }
        }

        $pageLink = function ($page) use ($baseUri, $query) {
            return $baseUri . '?' . http_build_query($query->set('page', $page)->toArray());
        };

        $links = [];
        if ($page > 1) {
            $links['prev'] = $pageLink($page - 1);
        }

        if ($page < $noOfPages) {
            $links['next'] = $pageLink($page + 1);
        }

        return compact('items', 'links', 'total', 'noOfPages', 'pageLink', 'page');
    }

    /**
     * @param $item
     * @return bool
     */
    public function remove($item)
    {
        $this->repository->remove($item);

        return true;
    }

    /**
     * @param $id
     * @return object
     * @throws NotFoundException
     */
    public function fetch($id)
    {
        $item = $this->repository->find($id);
        if ($item === null) {
            throw new NotFoundException($this->translate('exception.item_not_found'));
        }

        return $item;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $actionUri
     * @return Form
     */
    public function prepareForm($actionUri)
    {
        return $this->form
            ->setAttribute('action', $actionUri)
            ->prepare();
    }

    /**
     * @param $item
     * @return bool
     */
    protected function isEntityInstance($item)
    {
        return is_a($item, $this->repository->getClassName());
    }
}
