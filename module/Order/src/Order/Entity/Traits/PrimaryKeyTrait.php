<?php

namespace Order\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PrimaryKeyTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}