<?php

namespace Order\Factory;

use Order\Filter\ItemFilter;
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

        return new ItemService($serviceLocator, $repository, new ItemFilter($translator));
    }
}
