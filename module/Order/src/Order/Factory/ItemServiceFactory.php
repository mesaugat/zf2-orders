<?php

namespace Order\Factory;

use Order\Entity\Item;
use Order\Filter\ItemFilter;
use Order\Form\ItemForm;
use Order\Service\ItemService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ItemService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository('Order\Entity\Item');
        $translator = $serviceLocator->get('translator');
        $form = new ItemForm(new ItemFilter($translator), new Item());

        return new ItemService($serviceLocator, $repository, $form);
    }
}
