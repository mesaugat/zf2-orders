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

    public function __construct(ServiceLocatorInterface $serviceManager, CrudRepository $repository, Form $form)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
        $this->form = $form;
    }

    public static function getBaseUri()
    {
        return '/';
    }

    /**
     * @param $data
     * @return bool
     */
    public function createNew($data)
    {
        $this->form->setData($data);

        if ($this->form->isValid()) {
            $item = $this->repository->createNew($this->form->getData());

            return $this->isEntityInstance($item);
        }

        return false;
    }

    /**
     * @param $item
     */
    public function bindToForm($item)
    {
        $this->form->bind($item);
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function update($data)
    {
        if (!$this->isEntityInstance($this->form->getObject())) {
            throw new \Exception($this->translate('exception.form_not_bound'));
        }

        $this->form->setData($data);

        if ($this->form->isValid()) {
            $item = $this->form->getData();
            $this->repository->update($item);

            return true;
        }

        return false;
    }


    /**
     * @param Parameters $query
     * @return array
     * @throws NotFoundException
     */
    public function fetchList(Parameters $query)
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

        $pageLink = function ($page) use ($query) {
            return static::getBaseUri() . '?' . http_build_query($query->set('page', $page)->toArray());
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
     * @param $item
     * @return bool
     */
    protected function isEntityInstance($item)
    {
        return is_a($item, $this->repository->getClassName());
    }
}
