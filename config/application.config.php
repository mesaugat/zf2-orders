<?php
/**
 * Application Configuration File
 */
$env = getenv('APPLICATION_ENV') ?: 'production';

$modules = [
    'DoctrineModule',
    'DoctrineORMModule',
    'ZfcBase',
    'ZfcUser',
    'ZfcUserDoctrineORM',
    'BjyAuthorize',
    'TwbBundle',
    // Our Modules
    'Foundation',
    'Application',
    'Auth',
    'Order',
];

if ($env === 'development') {
    $modules[] = 'ZendDeveloperTools';
}

return [
    'modules' => $modules,
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ],
];
