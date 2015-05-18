<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foundation\Entity\Traits\CreatedDateTrait;
use Foundation\Entity\Traits\PrimaryKeyTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    use PrimaryKeyTrait, CreatedDateTrait;

    /**
     * @ORM\Column(type="string")
     **/
    protected $fullName;

    /**
     * @ORM\Column(type="string", unique=true)
     **/
    protected $username;

    /**
     * @ORM\Column(type="string")
     **/
    protected $password;

    /**
     * @ORM\Column(type="string", unique=true)
     **/
    protected $email;

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

}
