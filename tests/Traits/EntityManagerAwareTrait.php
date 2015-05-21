<?php

namespace Tests\Traits;

trait EntityManagerAwareTrait
{
    use ServiceManagerAwareTrait;

    protected $em;

    public function getEntityManager()
    {
        if (!$this->em) {
            $this->em = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }
}