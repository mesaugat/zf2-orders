<?php

namespace Foundation\Crud;

use Doctrine\Common\Inflector\Inflector;
use Foundation\AbstractController as Controller;
use Foundation\AbstractService as Service;
use Zend\View\Model\ViewModel;

abstract class AbstractCrudController extends Controller
{
    protected $service;

    /**
     * Returns the title of the associated resource
     * @return string
     */
    protected abstract function getResourceTitle();

    /**
     * @return string
     */
    protected function getBaseUri()
    {
        return call_user_func(get_class($this->service) . '::getBaseUri');
    }

    /**
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $data = $this->service->fetchList($this->getRequest()->getQuery());
        $data['title'] = Inflector::pluralize($this->getResourceTitle());

        return new ViewModel($data);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost() && $this->service->createNew($request->getPost())) {
            return $this->redirectToIndex();
        }

        return [
            'title' => sprintf('Create New %s', $this->getResourceTitle()),
            'form' => $this->service->getForm(),
        ];
    }

    public function editAction()
    {
        $item = $this->service->fetch($this->params('id'));
        $request = $this->getRequest();

        $this->service->bindToForm($item);

        if ($request->isPost() && $this->service->update($request->getPost())) {
            return $this->redirectToIndex();
        }

        return [
            'title' => sprintf('Edit %s', $this->getResourceTitle()),
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

            return $this->redirectToIndex();
        }

        return compact('item');
    }

    /**
     * @return \Zend\Http\Response
     */
    public function redirectToIndex()
    {
        return $this->redirect()->toUrl($this->getBaseUri());
    }
}
