<?php


namespace Order\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractActionController{

    public function indexAction(){
        return new ViewModel(['hello'   => 'world']);
    }
}
