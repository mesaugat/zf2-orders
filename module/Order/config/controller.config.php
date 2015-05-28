<?php

return [
    'factories' => [
        'item-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\ItemService');

            return new Order\Controller\ItemController($service);
        },
        'role-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\RoleService');

            return new Order\Controller\RoleController($service);
        },
        'customer-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\CustomerService');

            return new Order\Controller\CustomerController($service);
        },
    ],
];
