<?php


namespace Order\Service;

use InvalidArgumentException;
use Order\Entity\ItemRepository;
use Order\Foundation\AbstractService;
use Order\Foundation\Exception\NotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemService extends AbstractService
{
    protected $repository;

    public function __construct(ServiceLocatorInterface $serviceManager, ItemRepository $repository)
    {
        parent::__construct($serviceManager);

        $this->repository = $repository;
    }


    public  function createNew() {

    }

    public function fetchList($baseUri, $query)
    {
        $max = (int)$query->get('max', 10);
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

        $links = [];
        if ($page > 1) {
            $links['prev'] = $baseUri . '?' . http_build_query($query->set('page', $page - 1)->toArray());
        }

        if ($page < $noOfPages) {
            $links['next'] = $baseUri . '?' . http_build_query($query->set('page', $page + 1)->toArray());
        }

        return compact('title', 'items', 'links', 'total');
    }
}