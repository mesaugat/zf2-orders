<?php

namespace Order\Entity\Repository;

use Order\Entity\Item;
use Foundation\Crud\AbstractCrudRepository as CrudRepository;

class ItemRepository extends CrudRepository
{
    /**
     * @param array $data
     * @return Item
     */
    public function getObjectInstance(array $data)
    {
        $item = new Item();
        $item->setName($data['name']);
        $item->setRate($data['rate']);

        return $item;
    }
}
