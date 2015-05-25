<?php

namespace Order\Entity\Repository;

use Order\Entity\Role;
use Foundation\Crud\AbstractCrudRepository as CrudRepository;

class RoleRepository extends CrudRepository
{
    /**
     * @param array $data
     * @return Role
     */
    public function getObjectInstance(array $data)
    {
        $object = new Role();
        $object->setRoleId($data['roleId']);
        $object->setName($data['name']);

//        $object->setParent($data['parent_id']);

        return $object;
    }
}
