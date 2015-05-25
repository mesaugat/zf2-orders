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
            ],
        ]);

        $this->add([
            'name' => 'roleId',
            'type' => 'Text',
            'options' => [
                'label' => 'Role Unique Id',
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
