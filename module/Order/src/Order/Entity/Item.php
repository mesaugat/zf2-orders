<?php

namespace Order\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 */
class Item
{
    const DATE_FORMAT = 'M d, Y h:i:s A';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;
    /**
     * @ORM\Column(type="string")
     **/
    protected $name;
    /**
     * @ORM\Column(type="datetime")
     **/
    protected $created;
    /**
     * @ORM\Column(type="decimal")
     **/
    protected $rate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->getCreated()->format(self::DATE_FORMAT);
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new DateTime();
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
