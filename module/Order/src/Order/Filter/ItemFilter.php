<?php

namespace Order\Filter;

use Foundation\AbstractFilter as Filter;
use Zend\Validator\Regex;

class ItemFilter extends Filter
{
    const FLOATING_POINT_PATTERN = '/^\d*(\.\d)?\d*$/';
    const ITEM_NAME_PATTERN = '/^[a-z]+[a-z0-9\s]+$/i';

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
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => self::ITEM_NAME_PATTERN,
                        'messages' => [
                            Regex::NOT_MATCH => $this->translate('validation.invalid_item_name')
                        ]
                    ]
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
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => self::FLOATING_POINT_PATTERN,
                        'messages' => [
                            Regex::NOT_MATCH => $this->translate('validation.invalid_item_rate')
                        ]
                    ]
                ]
            ]
        ]);
    }

}
