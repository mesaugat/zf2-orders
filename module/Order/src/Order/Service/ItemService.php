<?php

namespace Order\Service;

use Foundation\Crud\AbstractCrudService as CrudService;

class ItemService extends CrudService
{
    public static function getBaseUri()
    {
        return '/items';
    }
}
