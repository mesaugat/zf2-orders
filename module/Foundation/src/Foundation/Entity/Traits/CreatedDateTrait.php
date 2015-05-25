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
     * Created date will be set automatically when entity before persist triggers
     *
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new DateTime();
    }
}