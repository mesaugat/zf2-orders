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
        ],
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy'
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Order\Service\ItemService' => 'Order\Factory\ItemServiceFactory',
            'Order\Service\RoleService' => 'Order\Factory\RoleServiceFactory',
            'Order\Service\CustomerService' => 'Order\Factory\CustomerServiceFactory'
        ],
        'invokables' => [
            'Doctrine\ORM\Mapping\UnderscoreNamingStrategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy',
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
    'router' => require __DIR__ . '/router.config.php',
    'navigation' => require __DIR__ . '/navigation.config.php',
    'controllers' => require __DIR__ . '/controller.config.php',
    'view_manager' => [
        'template_path_stack' => [
            'order' => __DIR__ . '/../view',
        ]
    ]
];
