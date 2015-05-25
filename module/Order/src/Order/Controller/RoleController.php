<?php

namespace Order\Controller;

use Foundation\Crud\AbstractCrudController as CrudController;

class RoleController extends CrudController
{
    /**
     * @return string
     */
    protected function getResourceTitle()
    {
        return 'Role';
    }
}
