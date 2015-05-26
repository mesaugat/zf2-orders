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
                'column-size' => 'sm-8'
            ]
        ]);

        $this->add([
            'name' => 'rate',
            'type' => 'Text',
            'options' => [
                'label' => 'Rate',
                'column-size' => 'sm-8',
            ]
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
            ]
        ]);
    }
}
