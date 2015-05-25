<?php

namespace Order\Filter;

use Foundation\AbstractFilter as Filter;
use Zend\Validator\Regex;

class RoleFilter extends Filter
{
    const NAME_PATTERN = '/^[a-z]+[a-z0-9\s]+$/i';

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
            'name' => 'role_id',
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
                        'pattern' => self::NAME_PATTERN,
                        'messages'  => [
                            Regex::NOT_MATCH => $this->translate('validation.invalid_role_id')
                        ]
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'parent_id',
            'filters' => [
                ['name' => 'Int'],
            ]
        ]);
    }

}