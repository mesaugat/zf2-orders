<?php

namespace Foundation\Crud;

use Zend\View\Model\ViewModel;
use Foundation\AbstractForm as Form;
use Foundation\Exception\ValidationException;
use Foundation\AbstractController as Controller;
use Foundation\Crud\AbstractCrudService as CrudService;

abstract class AbstractCrudController extends Controller
{
    protected $service;
    protected $form;

    /**
     * Returns the title of the resource associated with this controller
     *
     * @return string
     */
    protected abstract function getResourceTitle();

    /**
     * @param AbstractCrudService $service
     * @param Form $form
     */
    public function __construct(CrudService $service, Form $form)
    {
        $this->service = $service;
        $this->form = $form;
    }

    /**
     * Default action if none provided.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        // fetch list with pagination
        $data = $this->service->fetchList($this->getRequest()->getQuery(), [
            'baseUri' => $this->getBaseUri()
        ]);

        // Title for the resource list
        $data['title'] = sprintf('%s List', $this->getResourceTitle());
        $data['pagination'] = $this->getPaginationControl($data['paginator']);

        return new ViewModel($data);
    }


    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        if ($this->handleFormPost()) {
            return $this->redirectToIndex();
        }

        return [
            'title' => sprintf('Create New %s', $this->getResourceTitle()),
            'form' => $this->form,
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {
        $entity = $this->service->fetch($this->params('id'));

        $data = $this->service->extract($entity);

        $this->form->setData($data);

        if ($this->handleFormPost()) {
            return $this->redirectToIndex();
        }

        return [
            'title' => sprintf('Edit %s', $this->getResourceTitle()),
            'form' => $this->form,
            'item' => $entity,
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {
        $this->service->remove($this->params('id'));

        return $this->redirectToIndex();
    }

    /**
     * Handles form submit and processes the form data
     *
     * @return bool
     *      true if form is successfully submitted
     *      false if form has not been submitted has errors
     */
    protected function handleFormPost()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            try {
                $this->service->save($data);

                return true;
            } catch (ValidationException $e) {

                $this->form->setData($data);
                $this->form->setMessages($e->getValidationMessages());
            }
        }

        $this->form->setAttribute('action', $request->getUri()->getPath())->prepare();

        return false;
    }

    protected function  getPaginationControl($paginator)
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $paginationControl = $viewHelperManager->get('paginationControl');

        return $paginationControl($paginator, 'Sliding', 'crud/pagination', [
            'baseUri' => $this->getBaseUri()
        ]);
    }

    /**
     * Redirects to the Index action (base uri)
     *
     * @return \Zend\Http\Response
     */
    protected function redirectToIndex()
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

    /**
     * Returns the base uri of the resource associated with this controller
     * from the router config
     *
     * @return string|null
     */
    protected function getBaseUri()
    {
        // get router config
        $routesConfig = $this->getServiceLocator()->get('config')['router']['routes'];
        $matchedRouteName = $this->getRouteName();

        // Get the base route
        if (isset($routesConfig[$matchedRouteName])) {
            $baseRoute = $routesConfig[$matchedRouteName];
        } else {
            $baseRoute = substr($matchedRouteName, 0, strpos($matchedRouteName, '/'));
            $baseRoute = $routesConfig[$baseRoute];
        }

        $uri = $baseRoute['options']['route'];

        return $uri;
    }
}
