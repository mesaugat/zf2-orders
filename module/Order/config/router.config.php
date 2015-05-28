<?php

return [
    'routes' => [
        'items' => [
            'type' => 'literal',
            'options' => [
                'route' => '/items',
                'defaults' => [
                    'controller' => 'item-controller',
                    'action' => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'add' => [
                    'type' => 'literal',
                    'options' => [
                        'route' => '/add',
                        'defaults' => [
                            'action' => 'add'
                        ]
                    ]
                ],
                'edit' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/edit/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'edit'
                        ]
                    ]
                ],
                'delete' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/delete/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'delete'
                        ]
                    ]
                ]
            ]
        ],
        'roles' => [
            'type' => 'literal',
            'options' => [
                'route' => '/roles',
                'defaults' => [
                    'controller' => 'role-controller',
                    'action' => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'add' => [
                    'type' => 'literal',
                    'options' => [
                        'route' => '/add',
                        'defaults' => [
                            'action' => 'add'
                        ]
                    ]
                ],
                'edit' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/edit/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'edit'
                        ]
                    ]
                ],
                'delete' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/delete/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'delete'
                        ]
                    ]
                ]
            ]
        ],
        'customers' => [
            'type' => 'literal',
            'options' => [
                'route' => '/customers',
                'defaults' => [
                    'controller' => 'customer-controller',
                    'action' => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'add' => [
                    'type' => 'literal',
                    'options' => [
                        'route' => '/add',
                        'defaults' => [
                            'action' => 'add'
                        ]
                    ]
                ],
                'edit' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/edit/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'edit'
                        ]
                    ]
                ],
                'delete' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/delete/:id',
                        'constraints' => [
                            'id' => '\d+',
                        ],
                        'defaults' => [
                            'action' => 'delete'
                        ]
                    ]
                ]
            ]
        ],
    ],
];
