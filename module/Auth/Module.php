<?php
namespace Auth;

use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        // layout override
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function ($e) {
            $routeName = $e->getRouteMatch()->getMatchedRouteName();

            if ($routeName == 'zfcuser/login' || $routeName == 'zfcuser/register') {
                $controller = $e->getTarget();
                $controller->layout('layout/auth.phtml');
            }
        });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
