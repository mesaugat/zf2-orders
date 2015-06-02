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
                'roles' => [],
                'customers' => [],
            ],
        ],
        'rule_providers' => [

            // View level access control
            BjyAuthorize\Provider\Rule\Config::class => [
                'allow' => [
                    //items
                    [['admin'], 'items', ['create', 'update', 'delete']],
                    [['admin', 'operator'], 'items', ['read']],
                    //roles
                    [['admin'], 'roles', ['create', 'update', 'delete']],
                    [['admin', 'operator'], 'roles', ['read']],
                    //roles
                    [['admin'], 'customers', ['create', 'update', 'delete']],
                    [['admin', 'operator'], 'customers', ['read']],
                ],
            ],
        ],
        'guards' => [
            // route guards
            BjyAuthorize\Guard\Route::class => [
                // items
                ['route' => 'items', 'roles' => ['operator', 'admin']],
                ['route' => 'items/add', 'roles' => ['admin']],
                ['route' => 'items/edit', 'roles' => ['admin']],
                ['route' => 'items/delete', 'roles' => ['admin']],
                // roles
                ['route' => 'roles', 'roles' => ['admin', 'operator']],
                ['route' => 'roles/add', 'roles' => ['admin']],
                ['route' => 'roles/edit', 'roles' => ['admin']],
                ['route' => 'roles/delete', 'roles' => ['admin']],
                // customers
                ['route' => 'customers', 'roles' => ['user']],
                ['route' => 'customers/add', 'roles' => ['admin', 'operator']],
                ['route' => 'customers/edit', 'roles' => ['admin', 'operator']],
                ['route' => 'customers/delete', 'roles' => ['admin', 'operator']],
                //zfcuser
                ['route' => 'zfcuser', 'roles' => ['user', 'guest']],
                ['route' => 'zfcuser/logout', 'roles' => ['user', 'guest']],
                ['route' => 'zfcuser/changeemail', 'roles' => ['user', 'guest']],
                ['route' => 'zfcuser/changepassword', 'roles' => ['user', 'guest']],
                ['route' => 'zfcuser/login', 'roles' => ['guest']],
                ['route' => 'zfcuser/authenticate', 'roles' => ['guest']],
                ['route' => 'zfcuser/register', 'roles' => ['guest']],
                // home
                ['route' => 'home', 'roles' => ['guest', 'user']],
                //api
                ['route' => 'api-v1/items', 'roles' => ['guest', 'user']],
            ]
        ]
    ],
];
