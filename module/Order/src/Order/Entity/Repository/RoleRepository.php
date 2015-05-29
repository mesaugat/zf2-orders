<?php

namespace Order\Entity\Repository;

use Foundation\Crud\AbstractCrudRepository as CrudRepository;

class RoleRepository extends CrudRepository
{

    /**
     * Returns array of role names
     * in the form [ id => role_id ] for using in select dropdown
     *
     * @param $exceptionRole
     * @return array
     */
    public function getRoleSelectList($exceptionRole = null)
    {
        $dql = sprintf('SELECT r.id, r.roleId FROM %s r', $this->getEntityName());
        $query = $this->getEntityManager()->createQuery($dql);
        if (!is_null($exceptionRole)) {
            $query->setDQL($dql = $dql . ' WHERE r.roleId != :exception');
            $query->setParameter('exception', $exceptionRole);
        }
        $query->setDQL($dql . ' ORDER BY r.roleId');

        $list = [
            '0' => 'None'
        ];
        foreach ($query->getResult() as $role) {
            $list[$role['id']] = $role['roleId'];
        }

        return $list;
    }

}
