<?php


namespace Foundation\Crud;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Foundation\AbstractRepository as Repository;
use Foundation\Entity\EntityInterface;

abstract class AbstractCrudRepository extends Repository
{

    public function fetchList()
    {
        $dql = sprintf('SELECT i FROM %s i ORDER BY i.created DESC', $this->getEntityName());

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function save(EntityInterface $entity)
    {
        $em = $this->getEntityManager();

        // If the id isn't set persist it
        if (!$entity->getId()) {
            $em->persist($entity);
        }
        $em->flush($entity);

        return $entity;
    }

    public function remove($item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();
    }
}
