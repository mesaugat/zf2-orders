<?php


namespace Order\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ItemRepository extends EntityRepository
{
    public function fetchList($offset = 0, $max = 10)
    {
        $dql = 'SELECT i FROM Order\Entity\Item i ORDER BY i.created DESC';

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);

        $query->setFirstResult($offset);
        $query->setMaxResults($max);

        $paginator = new Paginator($query);

        return $paginator;
    }
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

    public function remove(Item $item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();
    }
}