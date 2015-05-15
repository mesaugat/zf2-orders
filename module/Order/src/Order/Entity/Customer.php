<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Order\Entity\Traits\CreatedDateTrait;
use Order\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks
 */
class Customer
{
    use PrimaryKeyTrait, CreatedDateTrait;

    /**
     * @ORM\Column(type="string")
     **/
    protected $name;

    /**
     * @ORM\Column(type="string")
     **/
    protected $address;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     * @var Order[]
     **/
    protected $orders = null;

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
