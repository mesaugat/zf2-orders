<?php

namespace Order\Form;

use Foundation\AbstractForm as Form;

class ItemForm extends Form
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
            'name' => 'rate',
            'type' => 'Text',
            'options' => [
                'label' => 'Rate',
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