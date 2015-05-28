<?php

namespace Order\Service;

use Foundation\Crud\AbstractCrudService as CrudService;
use Foundation\Entity\EntityInterface;

class RoleService extends CrudService
{
    /**
     * @param array $data
     * @return \Foundation\Entity\EntityInterface
     * @throws \Foundation\Exception\NotFoundException
     */
    public function hydrate(array $data)
    {
        $object = parent::hydrate($data);

        if ($parentId = $data['parentId']) {
            $object->setParent($this->fetch($parentId));
        }

        return $object;
    }

    public function extract(EntityInterface $object)
    {
        $data = parent::extract($object);
        unset($data['parent']);
        $data['parentId'] = $object->getParent()->getId();

        return $data;
    }


}
