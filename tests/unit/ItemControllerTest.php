<?php

namespace Tests\Unit;

use Zend\Http\Request as HttpRequest;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ItemControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../application.config.php'
        );

        parent::setUp();
    }

    /**
     * Common assertions for controller testing.
     * @param string $actionName
     */
    public function assertCommonMethodsForAction($actionName)
    {
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Item');
        $this->assertControllerClass('ItemController');
        $this->assertActionName($actionName);
        $this->assertMatchedRouteName('items');
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/items');
        $this->assertResponseStatusCode(200);

        $this->assertCommonMethodsForAction('index');
    }

    public function testAddActionCanBeAccessed()
    {
        $this->dispatch('/items/add');
        $this->assertResponseStatusCode(200);

        $this->assertCommonMethodsForAction('add');
    }

    public function testAddActionCannotInsertInvalidItem()
    {
        $post = [
            'id' => '',
            'name' => '',
            'rate' => 45.73
        ];
        $this->dispatch('/items/add', HttpRequest::METHOD_POST, $post);
        $this->assertResponseStatusCode(200);

        $this->assertQueryContentContains('form ul li', "Value is required and can't be empty");
        $this->assertCommonMethodsForAction('add');
    }

    public function testAddActionCanInsertValidItemAndRedirect()
    {
        $postData = [
            'id' => '',
            'name' => 'Tea',
            'rate' => 2.23
        ];
        $this->dispatch('/items/add', HttpRequest::METHOD_POST, $postData);
        $this->assertResponseStatusCode(302);

        $this->assertCommonMethodsForAction('add');
        $this->assertRedirectTo('/items');
    }

    /**
     * @depends testAddActionCanInsertValidItemAndRedirect
     */
    public function testEditActionCannotEditInvalidItem()
    {
        $postData = [
            'id' => 1,
            'name' => '',
            'rate' => 12.62
        ];
        $this->dispatch('/items/edit/1', HttpRequest::METHOD_POST, $postData);
        $this->assertResponseStatusCode(200);

        $this->assertQueryContentContains('form ul li', "Value is required and can't be empty");
        $this->assertCommonMethodsForAction('edit');
    }

    /**
     * @depends testAddActionCanInsertValidItemAndRedirect
     */
    public function testEditActionCanEditValidItemAndRedirect()
    {
        $postData = [
            'id' => 1,
            'name' => 'Bottle',
            'rate' => 12.22
        ];
        $this->dispatch('/items/edit/1', HttpRequest::METHOD_POST, $postData);
        $this->assertResponseStatusCode(302);

        $this->assertCommonMethodsForAction('edit');
        $this->assertRedirectTo('/items');
    }

    public function testEditActionCannotBeAccessedWithoutValidId()
    {
        $this->dispatch('/items/edit/100');
        $this->assertApplicationException('Foundation\Exception\NotFoundException', 500);
    }

    public function testEditActionCannotBeAccessedWithoutId()
    {
        $this->dispatch('/items/edit');
        $this->assertApplicationException('Doctrine\ORM\ORMException', 500);
    }

    /**
     * @depends testAddActionCanInsertValidItemAndRedirect
     */
    public function testDeleteActionDiscardDeleteInvalidItem()
    {
        $postData = [
            'id' => 1,
            'delete_confirmation' => 'no'
        ];
        $this->dispatch('/items/delete/1', HttpRequest::METHOD_POST, $postData);
        $this->assertResponseStatusCode(302);

        $this->assertCommonMethodsForAction('delete');
        $this->assertRedirectTo('/items');
    }

    /**
     * @depends testAddActionCanInsertValidItemAndRedirect
     */
    public function testDeleteActionConfirmDeleteValidItemAndRedirect()
    {
        $postData = [
            'id' => 1,
            'delete_confirmation' => 'yes'
        ];
        $this->dispatch('/items/delete/1', HttpRequest::METHOD_POST, $postData);
        $this->assertResponseStatusCode(302);

        $this->assertCommonMethodsForAction('delete');
        $this->assertRedirectTo('/items');
    }

    public function testDeleteActionCannotBeAccessedWithoutValidId()
    {
        $this->dispatch('/items/delete/100');
        $this->assertApplicationException('Foundation\Exception\NotFoundException', 500);
    }

    public function testDeleteActionCannotBeAccessedWithoutId()
    {
        $this->dispatch('/items/delete');
        $this->assertApplicationException('Doctrine\ORM\ORMException', 500);
    }

    public function tearDown()
    {
        $sm = $this->getApplicationServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');
        $dbh = $em->getConnection();
        $dbh->exec('ALTER SEQUENCE items_id_seq RESTART WITH 1;');

        parent::tearDown();
    }
}