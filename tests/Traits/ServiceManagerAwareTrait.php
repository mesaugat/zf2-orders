<?php

namespace Tests\Traits;

use Zend\Mvc\Application;

trait ServiceManagerAwareTrait
{
    protected $sm;
    protected $application;

    public function getZf2Application()
    {
        if (!$this->application) {
            $this->application = Application::init(include __DIR__ . '/../application.config.php');
        }

        return $this->application;
    }

    public function getServiceManager()
    {
        if (!$this->sm) {
            $this->sm = $this->getZf2Application()->getServiceManager();
        }

        return $this->sm;
    }
}