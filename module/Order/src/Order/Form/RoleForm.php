<?php

namespace Order\Form;

use Foundation\AbstractForm as Form;

class RoleForm extends Form
{
    protected function initialize()
    {
        $this->add([
            'name' => 'id',
            'type' => 'Hidden',
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'Text',
            'options' => [
                'label' => 'Name',
                'column-size' => 'sm-8'
            ],
        ]);

        $this->add([
            'name' => 'roleId',
            'type' => 'Text',
            'options' => [
                'label' => 'Role Unique Id',
                'column-size' => 'sm-8'
            ],
        ]);


        $this->add([
            'name' => 'parentId',
            'type' => 'Select',
            'options' => [
                'label' => 'Parent',
                'value_options' => [
                    '0' => 'None',
                    '1' => 'Foo'
                ],
                'column-size' => 'sm-8'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'label' => 'Submit',
                'column-size' => 'sm-8 col-sm-offset-2'
            ],
            'attributes' => [
                'id' => 'submitbutton',
                'class' => 'btn-primary'
            ],
        ]);
    }
}
