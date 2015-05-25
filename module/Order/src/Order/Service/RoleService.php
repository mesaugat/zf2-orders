<?php

namespace Order\Service;

use Foundation\Crud\AbstractCrudService as CrudService;

class RoleService extends CrudService
{
    public static function getBaseUri()
    {
        return '/roles';
    }
}
