<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foundation\Traits\ArraySerializableTrait;
use Foundation\Entity\Traits\CreatedDateTrait;
use Foundation\Entity\Traits\PrimaryKeyTrait;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * @ORM\Entity(repositoryClass="Order\Entity\Repository\ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 */
class Item implements ArraySerializableInterface
{
    use PrimaryKeyTrait, CreatedDateTrait;

    use ArraySerializableTrait;
    /**
     * @ORM\Column(type="string")
     **/
    protected $name;
    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
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
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }
}
