<?php

namespace Foundation\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

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