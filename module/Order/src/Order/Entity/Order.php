<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Order\Entity\Traits\CreatedDateTrait;
use Order\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks
 */
class Order {

    use PrimaryKeyTrait, CreatedDateTrait;

    /**
     * @ORM\Column(type="integer", name="order_no")
     **/
    protected $orderNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="orders")
     **/
    protected $customer;

    /**
     * @ORM\Column(type="decimal", name="grand_total")
     **/
    protected $grandTotal;

    /**
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order")
     *
     * @var OrderItem[]
     **/
    protected $orderItems = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param int $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return float
     */
    public function getGrandTotal()
    {
        return $this->grandTotal;
    }

    /**
     * @param float $grandTotal
     */
    public function setGrandTotal($grandTotal)
    {
        $this->grandTotal = $grandTotal;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param OrderItem $orderItem
     */
    public  function addOrderItem(OrderItem $orderItem) {
        $orderItem->setOrder($this);
        $this->orderItems[] = $orderItem;
    }
}
