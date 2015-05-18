<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foundation\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class OrderItem
{
    use PrimaryKeyTrait;
    /**
     * @ORM\Column(type="integer")
     **/
    protected $quantity;

    /**
     * @ORM\Column(type="decimal")
     **/
    protected $rate;

    /**
     * @ORM\Column(type="decimal", name="line_total")
     **/
    protected $lineTotal;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderItems")
     **/
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Item")
     **/
    protected $item;

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    /**
     * @return float
     */
    public function getLineTotal()
    {
        $this->lineTotal = $this->rate * $this->quantity;

        return $this->lineTotal;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

}
