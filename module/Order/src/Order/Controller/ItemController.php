<?php


namespace Order\Controller;

use Order\Form\ItemForm;
use Order\Service\ItemService;
use Zend\View\Model\ViewModel;
use Foundation\AbstractController as Controller;

class ItemController extends Controller
{
    protected $form;
    protected $service;

    public function __construct(ItemForm $form, ItemService $service)
    {
        $this->form = $form;
        $this->service = $service;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $data = $this->service->fetchList($request->getUri()->getPath(), $request->getQuery());
        $data['title'] = 'Items';

        return new ViewModel($data);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost() && $this->service->createNew($this->form, $request->getPost())) {
            return $this->redirect()->toRoute('items');
        }

        return [
            'title' => 'Create New Item',
            'form' => $this->form,
        ];
    }

    public function editAction()
    {
        $item = $this->service->fetch($this->params('id'));

        $this->form->bind($item);
        $request = $this->getRequest();

        if ($request->isPost() && $this->service->update($this->form, $request->getPost())) {
            return $this->redirect()->toRoute('items');
        }

        return [
            'title' => 'Edit Item',
            'form' => $this->form,
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