<?php


namespace Order\Controller;

use Doctrine\ORM\EntityRepository;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    protected $form;
    protected $items;

    public function __construct(Form $form, EntityRepository $repository)
    {
        $this->form = $form;
        $this->items = $repository;
    }

    public function indexAction()
    {
        return new ViewModel(['title' => 'Items']);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            $this->form->setData($request->getPost());

            if ($this->form->isValid()) {
                try {
                    $data = $this->form->getData();

                    $this->items->createNew($data);

                    return $this->redirect()->toRoute('items');
                } catch (\Exception $e) {
                    // Some DB Error happened, log it and let the user know
                }
            }
        }

        return [
            'title' => 'Create New Item',
            'form'  => $this->form,
        ];
    }
}
