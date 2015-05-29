<?php

use Order\Entity\Item;
use Order\Entity\Role;
use Order\Entity\Customer;
use Order\Form\ItemForm;
use Order\Form\RoleForm;
use Order\Form\CustomerForm;

return [
    'factories' => [
        'item-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\ItemService');

            return new \Order\Controller\ItemController($service, new ItemForm(new Item()));
        },
        'role-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\RoleService');
            $repository = $sm->get('Doctrine\ORM\EntityManager')->getRepository(Role::class);

            return new \Order\Controller\RoleController($service, new RoleForm($repository));
        },
        'customer-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\CustomerService');

            return new \Order\Controller\CustomerController($service, new CustomerForm(new Customer()));
        },
        'api-v1-item-controller' => function ($controllerManager) {
            $sm = $controllerManager->getServiceLocator();
            $service = $sm->get('Order\Service\ItemService');

            return new \Order\Api\V1\Controller\ItemController($service);
        }
    ],
];
