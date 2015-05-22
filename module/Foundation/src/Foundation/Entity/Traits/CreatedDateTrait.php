<?php

namespace Foundation\Entity\Traits;

use DateTime;

trait CreatedDateTrait
{
    /**
     * @ORM\Column(type="datetime")
     **/
    protected $created;

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new DateTime();
    }
}