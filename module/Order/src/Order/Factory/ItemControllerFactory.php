<?php

namespace Order\Factory;


use Order\Controller\ItemController;
use Order\Form\ItemForm;
use Order\Service\ItemService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ItemController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get('Doctrine\ORM\EntityManager');
        $form = new ItemForm('item-form');
        $repository = $em->getRepository('Order\Entity\Item');
        $service = $sm->get('Order\Service\ItemService');

        return new ItemController($form, $repository, $service);
    }
}