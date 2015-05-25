<?php

namespace Foundation\Crud;

use Zend\View\Model\ViewModel;
use Foundation\AbstractController as Controller;
use Foundation\Crud\AbstractCrudService as CrudService;

abstract class AbstractCrudController extends Controller
{
    protected $service;

    /**
     * Returns the title of the resource associated with this controller
     *
     * @return string
     */
    protected abstract function getResourceTitle();

    /**
     * @param AbstractCrudService $service
     */
    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    /**
     * Returns the base uri of the resource associated with this controller
     * from the router config
     *
     * @return string|null
     */
    protected function getBaseUri()
    {
        // get router config
        $routerConfig = $this->getServiceLocator()->get('config')['router'];
        $matchedRouteName = $this->getRouteName();

        // get the matched route config
        $route = $routerConfig['routes'][$matchedRouteName];
        $pattern = $route['options']['route'];

        // Extract the base uri from the pattern
        preg_match('/^\/([a-z0-9\-\.]+)/i', $pattern, $matches);

        return !empty($matches) ? $matches[0] : null;
    }


    /**
     * Default action if none provided.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        // fetch list with pagination
        $data = $this->service->fetchList($this->getBaseUri(), $this->getRequest()->getQuery());

        // Title for the resource list
        $data['title'] = sprintf('%s List', $this->getResourceTitle());

        return new ViewModel($data);
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost() && $this->service->createNew($request->getPost())) {
            return $this->redirectToIndex();
        }

        return [
            'title' => sprintf('Create New %s', $this->getResourceTitle()),
            'form' => $this->service->prepareForm($request->getUri()->getPath()),
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
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
            'form' => $this->service->prepareForm($request->getUri()->getPath()),
            'item' => $item,
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
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
     * Redirects to the Index action (base uri)
     *
     * @return \Zend\Http\Response
     */
    public function redirectToIndex()
    {
        return $this->redirect()->toUrl($this->getBaseUri());
    }

    /**
     * @return string
     */
    protected function getRouteName()
    {
        return $this->getEvent()->getRouteMatch()->getMatchedRouteName();
    }
}
