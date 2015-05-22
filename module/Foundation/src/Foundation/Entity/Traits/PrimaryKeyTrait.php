<?php

namespace Foundation\Entity\Traits;

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