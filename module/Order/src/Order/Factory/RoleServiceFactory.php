<?php

namespace Order\Factory;

use Order\Filter\RoleFilter;
use Order\Form\RoleForm;
use Order\Service\RoleService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return RoleService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository('Order\Entity\Role');
        $translator = $serviceLocator->get('translator');
        $form = new RoleForm(new RoleFilter($translator), $repository);

        return new RoleService($serviceLocator, $repository, $form);
    }
}
