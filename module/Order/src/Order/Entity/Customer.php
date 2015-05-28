<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foundation\Traits\ArraySerializableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Foundation\Entity\EntityInterface;
use Foundation\Entity\Traits\CreatedDateTrait;
use Foundation\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity(repositoryClass="Order\Entity\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks
 */
class Customer implements EntityInterface
{

    use PrimaryKeyTrait, CreatedDateTrait;
    use ArraySerializableTrait;

    /**
     * @ORM\Column(type="string")
     **/
    protected $name;

    /**
     * @ORM\Column(type="string")
     **/
    protected $address;

    /**
     * @var ArrayCollection $orders
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer", cascade={"persist"})
     **/
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

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
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Order $order
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

}
