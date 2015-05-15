<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Order\Entity\Traits\CreatedDateTrait;
use Order\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity(repositoryClass="ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 */
class Item
{
    use PrimaryKeyTrait, CreatedDateTrait;

    /**
     * @ORM\Column(type="string")
     **/
    protected $name;
    /**
     * @ORM\Column(type="decimal")
     **/
    protected $rate;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

}
