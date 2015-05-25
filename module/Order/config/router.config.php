<?php

return [
    'routes' => [
        'items' => [
            'type' => 'segment',
            'options' => [
                'route' => '/items[/:action][/:id]',
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '\d+',
                ],
                'defaults' => [
                    'controller' => 'Order\Controller\Item',
                    'action' => 'index',
                ],
            ],
        ],
        'roles' => [
            'type' => 'segment',
            'options' => [
                'route' => '/roles[/:action][/:id]',
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '\d+',

                ],
                'defaults' => [
                    'controller' => 'Order\Controller\Role',
                    'action' => 'index',
                ],
            ],
        ],
    ],
];
