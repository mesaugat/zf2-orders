<?php

return [
    'bjyauthorize' => [

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,
        'role_providers' => [

            BjyAuthorize\Provider\Role\Config::class => [
                'guest' => [],
            ],
            // using an object repository (entity repository) to load all roles into our ACL
            BjyAuthorize\Provider\Role\ObjectRepositoryProvider::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => Order\Entity\Role::class,
            ],
        ],
        'resource_providers' => [
            BjyAuthorize\Provider\Resource\Config::class => [
                'items' => [],
                'roles' => []
            ],
        ],
        'rule_providers' => [

            // View level access control
            BjyAuthorize\Provider\Rule\Config::class => [
                'allow' => [
                    //items
                    [['admin'], 'items', ['create', 'update', 'delete']],
                    [['admin', 'guest', 'operator'], 'items', ['read']],
                    //roles
                    [['admin'], 'roles', ['create', 'update', 'delete']],
                    [['admin', 'operator'], 'roles', ['read']],
                ],
            ],
        ],
        'guards' => [
            // route guards
            BjyAuthorize\Guard\Route::class => [
                // items
                ['route' => 'items', 'roles' => ['admin', 'operator', 'guest']],
                ['route' => 'items/add', 'roles' => ['admin']],
                ['route' => 'items/edit', 'roles' => ['admin']],
                ['route' => 'items/delete', 'roles' => ['admin']],
                // roles
                ['route' => 'roles', 'roles' => ['admin', 'operator']],
                ['route' => 'roles/add', 'roles' => ['admin']],
                ['route' => 'roles/edit', 'roles' => ['admin']],
                ['route' => 'roles/delete', 'roles' => ['admin']],
                //home
                ['route' => 'home', 'roles' => ['admin', 'operator', 'guest']],

            ]
        ]
    ],
];
