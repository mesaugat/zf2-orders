<?php


namespace Order\Controller;

use Order\Form\ItemForm;
use Order\Service\ItemService;
use Zend\View\Model\ViewModel;
use Order\Entity\ItemRepository;
use Order\Foundation\AbstractController as Controller;

class ItemController extends Controller
{
    protected $form;
    protected $items;
    protected $service;

    public function __construct(ItemForm $form, ItemRepository $repository, ItemService $service)
    {
        $this->form = $form;
        $this->items = $repository;
        $this->service = $service;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $baseUri = $request->getUri()->getPath();
        $query = $request->getQuery();

        $data = $this->service->fetchList($baseUri, $query);
        $data['title'] = 'Items';

        return new ViewModel($data);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            $this->form->setData($request->getPost());

            if ($this->form->isValid()) {

                $data = $this->form->getData();

                $this->items->createNew($data);

                return $this->redirect()->toRoute('items');
            }
        }

        return [
            'title' => 'Create New Item',
            'form' => $this->form,
        ];
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $item = $this->items->find($id);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $confirm = $request->getPost('delete_confirmation', 'no');

            if ($confirm === 'yes') {
                $this->items->remove($item);
            }

            return $this->redirect()->toRoute('items');
        }

        return compact('item');
    }


    public function editAction()
    {
        $id = $this->params('id');
        $item = $this->items->find($id);

        $this->form->bind($item);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->form->setData($request->getPost());

            if ($this->form->isValid()) {

                $item = $this->form->getData();
                $this->items->update($item);

                return $this->redirect()->toRoute('items');
            }
        }

        $form = $this->form;
        $title = 'Edit Item';

        return compact('form', 'title', 'item');
    }
}