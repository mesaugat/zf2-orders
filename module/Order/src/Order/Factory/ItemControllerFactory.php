<?php

namespace Order\Factory;


use Order\Controller\ItemController;
use Order\Form\ItemForm;
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
        $itemRepository = $em->getRepository('Order\Entity\Item');

        return new ItemController($form, $itemRepository);
    }
}