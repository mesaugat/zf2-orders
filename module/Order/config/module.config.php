<?php

namespace Order;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],

    'controllers' => [
        'invokables' => [
            'Order\Controller\Item' => 'Order\Controller\ItemController',
        ],
    ],

    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'items' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/items[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[1-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Order\Controller\Item',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'order' => __DIR__.'/../view',
        ],
    ],

    'view_helpers' => [

        'factories' => [
            'common'    => function($pluginManager) {
                return new \Order\Helper\Common($pluginManager->getServiceLocator());
            }
        ]
    ]
];