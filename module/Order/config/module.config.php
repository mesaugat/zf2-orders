<?php

namespace Order;

use Order\Service\ItemService;

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
        ],
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy'
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Order\Service\ItemService' => 'Order\Factory\ItemServiceFactory'
        ],
        'invokables' => [
            'Doctrine\ORM\Mapping\UnderscoreNamingStrategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy',
        ],
    ],
    'controllers' => [
        'factories' => [
            'Order\Controller\Item' => 'Order\Factory\ItemControllerFactory',
            'Order\Controller\Role' => 'Order\Factory\RoleControllerFactory',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
            ],
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'items' => [
                'type' => 'segment',
                'options' => [
                    'route' => ItemService::LIST_BASE_URI . '[/:action][/:id]',
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
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'order' => __DIR__ . '/../view',
        ],
    ]
];