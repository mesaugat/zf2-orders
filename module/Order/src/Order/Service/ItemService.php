<?php


namespace Order\Service;

use InvalidArgumentException;
use Order\Entity\Item;
use Order\Entity\ItemRepository;
use Foundation\AbstractService;
use Foundation\Exception\NotFoundException;
use Order\Form\ItemForm;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;

class ItemService extends AbstractService
{
    const PAGINATION_MAX_ROWS = 5;

    protected $form;
    protected $repository;

    public function __construct(ServiceLocatorInterface $serviceManager, ItemRepository $repository, ItemForm $form)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
        $this->form = $form;
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

            return ($item instanceof Item);
        }

        return false;
    }

    /**
     * @param Item $item
     */
    public function bindToForm(Item $item)
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
        if (!($this->form->getObject() instanceof Item)) {
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
     * @param $baseUri
     * @param Parameters $query
     * @return array
     * @throws NotFoundException
     */
    public function fetchList($baseUri, Parameters $query)
    {
        $max = (int)$query->get('max', self::PAGINATION_MAX_ROWS);
        $page = (int)$query->get('page', 1);

        if ($page < 1) {
            throw new InvalidArgumentException($this->translate('exception.invalid_page'));
        }

        $offset = ($page - 1) * $max;

        $list = $this->repository->fetchList($offset, $max);
        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();
        $noOfPages = ceil($total / $max);

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

        return compact('title', 'items', 'links', 'total', 'noOfPages', 'pageLink', 'page');
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function remove(Item $item)
    {
        $this->repository->remove($item);

        return true;
    }

    /**
     * @param $id
     * @return Item
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

    public function getForm()
    {
        return $this->form;
    }
}