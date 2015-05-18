<?php

namespace Foundation;

use Foundation\Traits\TranslatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractService implements ServiceLocatorAwareInterface
{
    use TranslatorAwareTrait;
    use ServiceLocatorAwareTrait;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->setTranslator($serviceLocator->get('translator'));
    }

}