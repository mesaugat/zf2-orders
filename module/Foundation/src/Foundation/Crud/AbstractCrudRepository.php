<?php


namespace Foundation\Crud;

use Foundation\Entity\EntityInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Foundation\AbstractRepository as Repository;

abstract class AbstractCrudRepository extends Repository
{

    /**
     * @return Paginator
     */
    public function fetchList()
    {
        $dql = sprintf('SELECT i FROM %s i ORDER BY i.created DESC', $this->getEntityName());

        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);

        $paginator = new Paginator($query);

        return $paginator;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
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

    /**
     * @param EntityInterface $item
     */
    public function remove(EntityInterface $item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();
    }
}
