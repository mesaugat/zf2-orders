<?php


namespace Order\Controller;

use InvalidArgumentException;
use Order\Form\ItemForm;
use Order\Foundation\Exception\NotFoundException;
use Zend\View\Model\ViewModel;
use Order\Entity\ItemRepository;
use Order\Foundation\AbstractController as Controller;

class ItemController extends Controller
{
    protected $form;
    protected $items;

    public function __construct(ItemForm $form, ItemRepository $repository)
    {
        $this->form = $form;
        $this->items = $repository;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();

        $max = (int)$query->get('max', 10);
        $page = (int)$query->get('page', 1);

        if ($page < 1) {
            throw new InvalidArgumentException($this->translate('exception.invalid_page'));
        }

        $offset = ($page - 1) * $max;

        $list = $this->items->fetchList($offset, $max);
        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();
        $noOfPages = ceil($total / $max);

        if ($total > 0) {
            if ($page > $noOfPages || $page < 1) {
                throw new NotFoundException($this->translate('exception.page_not_found'));
            }
        }

        $baseUri = $request->getUri()->getPath();
        $links = [];
        if ($page > 1) {
            $links['prev'] = $baseUri . '?' . http_build_query($query->set('page', $page - 1)->toArray());
        }

        if ($page < $noOfPages) {
            $links['next'] = $baseUri . '?' . http_build_query($query->set('page', $page + 1)->toArray());
        }

        $title = 'Items';

        return new ViewModel(compact('title', 'items', 'links', 'total'));
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