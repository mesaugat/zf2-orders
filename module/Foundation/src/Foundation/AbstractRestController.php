<?php

namespace Foundation;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Foundation\Misc\JsonResponse;
use Foundation\Exception\HttpException;

class AbstractRestController extends AbstractRestfulController
{
    public function onDispatch(MvcEvent $e)
    {
        try {
            $result = parent::onDispatch($e);

            if (!($result instanceof ViewModel) && !($result instanceof Response)) {
                $result = new JsonResponse($result);
            }

            $e->setResult($result);

            return $result;
        } catch (HttpException $e) {
            return $e->getResponse();
        }
    }
}
