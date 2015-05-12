<?php

namespace Order\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */

class Order {
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
     * @ORM\Column(type="datetime")
     **/
    protected $created;

    /**
     * @ORM\OneToOne(targetEntity="Customer")
     **/
    protected $customer;

    /**
     * @ORM\Column(type="float")
     **/
    protected $grand_total;

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
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }
}