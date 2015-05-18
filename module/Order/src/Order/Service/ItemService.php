<?php


namespace Order\Service;

use InvalidArgumentException;
use Order\Entity\Item;
use Order\Entity\ItemRepository;
use Order\Foundation\AbstractService;
use Order\Foundation\Exception\NotFoundException;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemService extends AbstractService
{
    protected $repository;

    public function __construct(ServiceLocatorInterface $serviceManager, ItemRepository $repository)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
    }


    /**
     * @param Form $form
     * @param $data
     * @return bool
     */
    public function createNew(Form $form, $data)
    {
        $form->setData($data);

        if ($form->isValid()) {
            $this->repository->createNew($form->getData());

            return true;
        }

        return false;
    }

    public function update(Form $form, $data)
    {
        $form->setData($data);
        if ($form->isValid()) {
            $item = $form->getData();
            $this->repository->update($item);

            return true;
        }

        return false;
    }


    /**
     * @param $baseUri
     * @param $query
     * @return array
     * @throws NotFoundException
     */
    public function fetchList($baseUri, $query)
    {
        $max = (int)$query->get('max', ItemRepository::PAGINATION_MAX_ROWS);
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

        $pageLink = function($page) use($baseUri, $query) {
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
}