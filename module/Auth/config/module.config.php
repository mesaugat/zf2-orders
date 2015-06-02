<?php

namespace Auth;

return [
    'view_manager' => [
        'template_map' => [
            'layout/auth' => __DIR__ . '/../view/layout/auth.phtml',
        ],
        'template_path_stack' => [
            'zfc-user' => __DIR__ . '/../view',
        ]
    ]
];
