<?php


namespace Order\Entity;


use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function createNew(array $data)
    {
        $item = new Item();
        $item->setName($data['name']);
        $item->setRate($data['rate']);

        $em = $this->getEntityManager();
        $em->persist($item);
        $em->flush();

        return $item;
    }
}