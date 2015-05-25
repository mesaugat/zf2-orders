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
            'name' => 'role_id',
            'type' => 'Text',
            'options' => [
                'label' => 'Role Name',
            ],
        ]);

        $this->add([
            'name' => 'parent_id',
            'type' => 'Select',
            'options' => [
                'label' => 'Parent',
                'value_options' => [
                    '0' => 'None',
                    '1' => 'Foo'
                ]
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Create',
                'id' => 'submitbutton',
            ],
        ]);
    }
}