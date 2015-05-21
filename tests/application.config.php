<?php
/**
 * Test Configuration file
 */

$modules = [
    'DoctrineModule',
    'DoctrineORMModule',
    'ZfcBase',
    'ZfcUser',
    'ZfcUserDoctrineORM',
    'Foundation',
    'Application',
    'Order',
];

return [
    'modules' => $modules,
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,testing}.php',
        ],
    ],
];
