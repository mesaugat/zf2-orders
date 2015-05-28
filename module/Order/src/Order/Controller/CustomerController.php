<?php

namespace Order\Controller;

use Foundation\Crud\AbstractCrudController as CrudController;

class CustomerController extends CrudController
{

    /**
     * @return string
     */
    protected function getResourceTitle()
    {
        return 'Customer';
    }
}
