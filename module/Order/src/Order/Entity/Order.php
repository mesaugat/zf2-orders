<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Order\Entity\Traits\CreatedDateTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks
 */
class Order {

    use CreatedDateTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="integer")
     **/
    protected $order_no;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="orders")
     **/
    protected $customer;

    /**
     * @ORM\Column(type="decimal")
     **/
    protected $grand_total;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrderNo()
    {
        return $this->order_no;
    }

    /**
     * @param int $order_no
     */
    public function setOrderNo($order_no)
    {
        $this->order_no = $order_no;
    }

    /**
     * @return float
     */
    public function getGrandTotal()
    {
        return $this->grand_total;
    }

    /**
     * @param float $grand_total
     */
    public function setGrandTotal($grand_total)
    {
        $this->grand_total = $grand_total;
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
