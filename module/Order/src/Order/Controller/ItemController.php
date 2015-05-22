<?php

namespace Order\Controller;

use Order\Service\ItemService;
use Zend\View\Model\ViewModel;
use Foundation\AbstractController as Controller;

class ItemController extends Controller
{
    protected $service;

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $data = $this->service->fetchList($this->getRequest()->getQuery());
        $data['title'] = 'Items';

        return new ViewModel($data);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost() && $this->service->createNew($request->getPost())) {
            return $this->redirect()->toRoute('items');
        }

        return [
            'title' => 'Create New Item',
            'form' => $this->service->getForm(),
        ];
    }

    public function editAction()
    {
        $item = $this->service->fetch($this->params('id'));
        $request = $this->getRequest();

        $this->service->bindToForm($item);

        if ($request->isPost() && $this->service->update($request->getPost())) {
            return $this->redirect()->toRoute('items');
        }

        return [
            'title' => 'Edit Item',
            'form' => $this->service->getForm(),
            'item' => $item
        ];
    }


    public function deleteAction()
    {
        $item = $this->service->fetch($this->params('id'));
        $request = $this->getRequest();

        if ($request->isPost()) {
            if ('yes' === $request->getPost('delete_confirmation', 'no')) {
                $this->service->remove($item);
            }

            return $this->redirect()->toRoute('items');
        }

        return compact('item');
    }
}