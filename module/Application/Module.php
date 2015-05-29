<?php
namespace Application;

use Zend\Console\Console;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sm = $e->getApplication()->getServiceManager();

        // Add ACL information to the Navigation view helper
        if (!Console::isConsole()) {
            $authorize = $sm->get('BjyAuthorize\Service\Authorize');
            $acl = $authorize->getAcl();
            $role = $authorize->getIdentity();
            Navigation::setDefaultAcl($acl);
            Navigation::setDefaultRole($role);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
