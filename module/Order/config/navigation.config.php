<?php

return [
    'default' => [
        [
            'label' => 'Items',
            'route' => 'items',
            'resource' => 'items',
            'privilege' => 'read',
            'pages' => [
                [
                    'label' => 'Add',
                    'route' => 'items/add',
                    'action' => 'add',
                    'resource' => 'items',
                    'privilege' => 'create'
                ],
                [
                    'label' => 'Edit',
                    'route' => 'items/edit',
                    'action' => 'edit',
                    'resource' => 'items',
                    'privilege' => 'update'
                ],
            ],
        ],
        [
            'label' => 'Roles',
            'route' => 'roles',
            'resource' => 'roles',
            'privilege' => 'read',
            'pages' => [
                [
                    'label' => 'Add',
                    'route' => 'roles/add',
                    'action' => 'add',
                    'resource' => 'roles',
                    'privilege' => 'create',
                ],
                [
                    'label' => 'Edit',
                    'route' => 'roles/edit',
                    'action' => 'edit',
                    'resource' => 'roles',
                    'privilege' => 'update',
                ],
            ],
        ],
        [
            'label' => 'Customers',
            'route' => 'customers',
            'resource' => 'customers',
            'privilege' => 'read',
            'pages' => [
                [
                    'label' => 'Add',
                    'route' => 'customers/add',
                    'action' => 'add',
                    'resource' => 'customers',
                    'privilege' => 'create',
                ],
                [
                    'label' => 'Edit',
                    'route' => 'customers/edit',
                    'action' => 'edit',
                    'resource' => 'customers',
                    'privilege' => 'update',
                ],
            ],
        ],
    ],
];
