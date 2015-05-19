<?php


namespace Order\Entity;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Foundation\AbstractRepository as Repository;

class ItemRepository extends Repository
{
    const PAGINATION_MAX_ROWS = 5;
    const PAGINATION_OFFSET_START = 0;

    public function fetchList($offset = self::PAGINATION_OFFSET_START, $max = self::PAGINATION_MAX_ROWS)
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

    public function update(Item $item)
    {
        $this->getEntityManager()->flush($item);
    }

    public function remove(Item $item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();
    }
}