<?php

namespace Order\Filter;

use Zend\InputFilter\InputFilter;

class ItemFilter extends InputFilter
{
    public function __construct()
    {
        $this->initialize();
    }

    protected function initialize()
    {
        $this->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ]
            ],
        ]);

        $this->add([
            'name' => 'rate',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }

}