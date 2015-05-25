<?php


namespace Foundation\Crud;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Foundation\AbstractRepository as Repository;

abstract class AbstractCrudRepository extends Repository
{
    public abstract  function getObjectInstance(array $data);

    public function fetchList($offset = Repository::PAGINATION_OFFSET_START, $max = Repository::PAGINATION_MAX_ROWS)
    {
        $dql = sprintf('SELECT i FROM %s i ORDER BY i.created DESC', $this->getEntityName());

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);

        $query->setFirstResult($offset);
        $query->setMaxResults($max);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function createNew(array $data)
    {
        $item = $this->getObjectInstance($data);

        $em = $this->getEntityManager();
        $em->persist($item);
        $em->flush();

        return $item;
    }

    public function update($item)
    {
        $this->getEntityManager()->flush($item);
    }

    public function remove($item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();
    }
}
