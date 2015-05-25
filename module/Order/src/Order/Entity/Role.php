<?php

namespace Order\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Foundation\Entity\Traits\CreatedDateTrait;
use Foundation\Entity\Traits\PrimaryKeyTrait;
use Foundation\Traits\ArraySerializableTrait;
use Zend\Stdlib\ArraySerializableInterface;

/**
 *
 * @ORM\Entity(repositoryClass="Order\Entity\Repository\RoleRepository")
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks
 */
class Role implements HierarchicalRoleInterface, ArraySerializableInterface
{
    use PrimaryKeyTrait, CreatedDateTrait;

    use ArraySerializableTrait;

    /**
     * @var string
     * @ORM\Column(type="string", name="role_id", length=255, unique=true, nullable=true)
     */
    protected $roleId;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    protected $parent;

    /**
     * Get the role id.
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set the role id.
     *
     * @param string $roleId
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string)$roleId;
    }

    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent role.
     *
     * @param Role $parent
     *
     * @return void
     */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
    }
}
