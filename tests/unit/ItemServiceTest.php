<?php

use Order\Entity\Item;
use Order\Service\ItemService;
use Tests\Traits\FakerAwareTrait;
use Tests\Traits\EntityManagerAwareTrait;

class ItemServiceTest extends \Codeception\TestCase\Test
{
    use FakerAwareTrait;
    use EntityManagerAwareTrait;
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $form;

    /**
     * @var ItemService
     */
    protected $service;

    /**
     * Set up the service with mock dependencies
     */
    protected function _before()
    {
        $this->repository = $this->getMockBuilder('Order\Entity\ItemRepository')->disableOriginalConstructor()->getMock();
        $this->form = $this->getMockBuilder('Order\Form\ItemForm')->disableOriginalConstructor()->getMock();
        $this->service = new ItemService($this->getServiceManager(), $this->repository, $this->form);

    }

    protected function _after()
    {
    }


    /**
     * Create an dummy array of Items
     * @param $n
     * @return array
     */
    private function getSomeDummyRecords($n)
    {
        $records = [];
        while ($n-- > 0) {
            $records[] = new Item();
        }

        return $records;
    }


    /**
     * Create test data
     * @return array
     */
    private function getTestItemData()
    {
        return [
            'name' => $this->getFaker()->word,
            'rate' => $this->getFaker()->numerify('##.##')
        ];
    }


    /**
     * Create a dummy test Item
     * @return Item
     */
    private function getTestItem()
    {
        $item = new Item();
        $item->setName($this->getFaker()->word);

        return $item;
    }


    /**
     * Base Uri for testing
     * @return string
     */
    private function getBaseUri()
    {
        return '/items';
    }

    /**
     * test ItemService::createNew() when data is valid
     */
    public function testCreateNewSucceedsWhenDataIsValid()
    {
        $data = [
            'name' => $this->getFaker()->word,
            'rate' => $this->getFaker()->numerify('##.##')
        ];

        $this->form->expects($this->once())->method('setData')->with($data)->willReturn(null);

        // The form says the data is valid
        $this->form->expects($this->once())->method('isValid')->willReturn(true);
        $this->form->expects($this->once())->method('getData')->willReturn($data);
        $this->repository->expects($this->once())->method('getClassName')->willReturn('Order\Entity\Item');

        $this->repository->expects($this->once())->method('createNew')->with($data)->willReturn($this->getTestItem());

        $successful = $this->service->createNew($data);

        $this->assertTrue($successful);
    }


    /**
     * test ItemService::createNew() when data is invalid
     */
    public function testCreateNewFailsWhenDataIsInvalid()
    {
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('setData')->with($data)->willReturn(null);

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(false);

        $successful = $this->service->createNew($data);

        $this->assertFalse($successful);
    }


    /**
     * test ItemService::bindToForm()
     */
    public function testBindToFormBindsAnItemToForm()
    {
        $item = $this->getTestItem();
        $item->setName('Foo');

        $this->form->expects($this->once())->method('bind')->with($item);
        $this->service->bindToForm($item);

    }


    /**
     * test ItemService::update() throws Exception if no Item has been bound to the form
     * @throws Exception
     */
    public function testUpdateThrowsExceptionIfFormNotBoundToAnyItem()
    {
        $this->setExpectedException('Exception');
        $this->repository->expects($this->once())->method('getClassName')->willReturn('Order\Entity\Item');
        $this->form->expects($this->once())->method('getObject')->willReturn(null);

        $data = $this->getTestItemData();
        $this->service->update($data);
    }


    /**
     * test ItemService::update() fails if data is invalid
     * @throws Exception
     */
    public function testUpdateFailsIfDataIsInvalid()
    {
        $item = $this->getTestItem();
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('getObject')->willReturn($item);
        $this->form->expects($this->once())->method('setData')->with($data);
        $this->repository->expects($this->once())->method('getClassName')->willReturn('Order\Entity\Item');

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(false);

        $successful = $this->service->update($data);

        $this->assertFalse($successful);
    }


    /**
     * test ItemService::update() succeeds if data is valid
     * @throws Exception
     */
    public function testUpdateSucceedsIfDataIsValid()
    {
        $item = $this->getTestItem();
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('getObject')->willReturn($item);
        $this->form->expects($this->once())->method('setData')->with($data);

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(true);

        $this->form->expects($this->once())->method('getData')->willReturn($item);

        $this->repository->expects($this->once())->method('getClassName')->willReturn('Order\Entity\Item');
        $this->repository->expects($this->once())->method('update')->with($item);

        $successful = $this->service->update($data);

        $this->assertTrue($successful);
    }


    /**
     * test ItemService::getForm() returns the form
     */
    public function testGetFormReturnsTheForm()
    {
        $this->assertEquals($this->form, $this->service->getForm());
    }

    /**
     * test ItemService::fetch() returns corresponding Item
     */
    public function testFetchReturnsCorrespondingItemEntity()
    {
        $itemId = 1;
        $item = $this->getTestItem();
        $this->repository->expects($this->once())->method('find')->with($itemId)->willReturn($item);
        $result = $this->service->fetch($itemId);

        $this->assertEquals($item, $result);
    }

    /**
     * test ItemService::fetch() throws NotFoundException
     * if Item with the id not found
     *
     */
    public function testFetchThrowsExceptionIfEntityNotFound()
    {
        $this->setExpectedException('Foundation\Exception\NotFoundException');

        $notExistingItemId = 6;
        $this->repository->expects($this->once())->method('find')->with($notExistingItemId)->willReturn(null);
        $this->service->fetch($notExistingItemId);
    }

    /**
     * test ItemService::remove() works
     */
    public function testRemoveWorks()
    {
        $item = $this->getTestItem();
        $this->repository->expects($this->once())->method('remove')->with($item);

        $this->assertTrue($this->service->remove($item));
    }

    /**
     * test ItemService::fetchList() throws InvalidArgumentException
     * if invalid page is given in the query parameters
     */
    public function testFetchListThrowsExceptionForInvalidPageQuery()
    {
        $query = $this->getMock('Zend\Stdlib\Parameters');
        $query->expects($this->any())->method('get')->willReturnCallback(function ($key) {
            return $key === 'page' ? -1 : null;
        });

        $this->setExpectedException('InvalidArgumentException');
        $this->service->fetchList($this->getBaseUri(), $query);
    }

    /**
     * test ItemService::fetchList() returns correct data
     * even if there are no records in the database
     */
    public function testFetchListReturnsCorrectDataWhenNoRecords()
    {
        $query = $this->getMock('Zend\Stdlib\Parameters');
        $query->expects($this->at(0))->method('get')->with('max')->willReturn(5);
        $query->expects($this->at(1))->method('get')->with('page')->willReturn(1);

        $paginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')->disableOriginalConstructor()->getMock();

        $paginator->expects($this->once())->method('getIterator')->willReturn(new ArrayIterator([]));
        $paginator->expects($this->once())->method('count')->willReturn(0);

        $this->repository->expects($this->once())->method('fetchList')->with(0, 5)->willReturn($paginator);

        $data = $this->service->fetchList($this->getBaseUri(), $query);

        $this->assertTrue(is_array($data));
        $this->assertEquals(0, $data['total']);
        $this->assertEquals(1, $data['page']);
        $this->assertEquals(1, $data['noOfPages']);
        $this->assertEmpty($data['items']);
        $this->assertEmpty($data['links']);
        $this->assertInstanceOf('Closure', $data['pageLink']);
    }

    /**
     * test ItemService::fetchList() throws NotFoundException
     * if the page given in the query parameters does not exist
     */
    public function testFetchListThrowsExceptionIfPageNotFound()
    {
        $query = $this->getMock('Zend\Stdlib\Parameters');

        // Set Max records 5 & page 2 as query string parameters
        $query->expects($this->at(0))->method('get')->with('max')->willReturn($max = 5);
        $query->expects($this->at(1))->method('get')->with('page')->willReturn($page = 2);

        $paginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')->disableOriginalConstructor()->getMock();

        $records = $this->getSomeDummyRecords($totalRecords = 3);

        $paginator->expects($this->once())->method('getIterator')->willReturn(new ArrayIterator($records));
        $paginator->expects($this->once())->method('count')->willReturn($totalRecords);

        $this->repository->expects($this->once())->method('fetchList')->with(5, $max)->willReturn($paginator);

        $this->setExpectedException('Foundation\Exception\NotFoundException');

        $this->service->fetchList($this->getBaseUri(), $query);
    }

    /**
     * test ItemService::fetchList() works correctly when there are only
     * few items that does not require pagination
     */
    public function testFetchListReturnsCorrectDataWithoutPagination()
    {
        $query = $this->getMock('Zend\Stdlib\Parameters');

        // Set Max records 5 & page 2 as query string parameters
        $query->expects($this->at(0))->method('get')->with('max')->willReturn($max = 5);
        $query->expects($this->at(1))->method('get')->with('page')->willReturn($page = 1);

        $paginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')->disableOriginalConstructor()->getMock();

        $records = $this->getSomeDummyRecords($totalRecords = 3);

        $paginator->expects($this->once())->method('getIterator')->willReturn(new ArrayIterator($records));
        $paginator->expects($this->once())->method('count')->willReturn($totalRecords);

        $this->repository->expects($this->once())->method('fetchList')->with(0, $max)->willReturn($paginator);

        $data = $this->service->fetchList($this->getBaseUri(), $query);

        $expectedNoOfPages = 1;

        $this->assertTrue(is_array($data));
        $this->assertEquals($totalRecords, $data['total']);
        $this->assertEquals($page, $data['page']);
        $this->assertEquals($expectedNoOfPages, $data['noOfPages']);
        $this->assertEquals($records, $data['items']);

        // Since there is only one page no other links are available
        $this->assertEmpty($data['links']);
        $this->assertInstanceOf('Closure', $data['pageLink']);
    }

    /**
     * test ItemService::fetchList() works correctly when there are
     * lots of data with pagination
     */
    public function testFetchListReturnsCorrectDataWithPagination()
    {
        $query = $this->getMock('Zend\Stdlib\Parameters');

        // Set Max records 5 & page 2 as query string parameters
        $query->expects($this->at(0))->method('get')->with('max')->willReturn($max = 5);
        $query->expects($this->at(1))->method('get')->with('page')->willReturn($page = 2);

        $query->expects($this->any())->method('set')->willReturnCallback(function ($key, $value) {
            return new \Zend\Stdlib\Parameters([$key => $value]);
        });

        $paginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')->disableOriginalConstructor()->getMock();

        $records = $this->getSomeDummyRecords($max);

        $paginator->expects($this->once())->method('getIterator')->willReturn(new ArrayIterator($records));
        $paginator->expects($this->once())->method('count')->willReturn($totalRecords = 13);

        $this->repository->expects($this->once())->method('fetchList')->with(5, $max)->willReturn($paginator);

        $data = $this->service->fetchList($this->getBaseUri(), $query);

        $expectedNoOfPages = (int)ceil($totalRecords / $max);

        // Since current page = 2, these should be the links returned
        $expectedLinks = [
            'prev' => $this->getBaseUri() . '?page=1',
            'next' => $this->getBaseUri() . '?page=3',
        ];

        $this->assertTrue(is_array($data));
        $this->assertEquals($totalRecords, $data['total']);
        $this->assertEquals($page, $data['page']);
        $this->assertEquals($expectedNoOfPages, $data['noOfPages']);
        $this->assertEquals($records, $data['items']);
        $this->assertEquals($expectedLinks, $data['links']);
        $this->assertInstanceOf('Closure', $data['pageLink']);
    }

}
