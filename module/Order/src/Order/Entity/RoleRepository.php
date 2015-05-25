<?php


namespace Order\Entity;

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
        $object->setRoleId($data['role_id']);
//        $object->setParent($data['parent_id']);

        return $object;
    }
}
