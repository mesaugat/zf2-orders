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

    protected function _before()
    {
        $this->repository = $this->getMockBuilder('Order\Entity\ItemRepository')->disableOriginalConstructor()->getMock();
        $this->form = $this->getMockBuilder('Order\Form\ItemForm')->disableOriginalConstructor()->getMock();
        $this->service = new ItemService($this->getServiceManager(), $this->repository, $this->form);
    }

    protected function _after()
    {
    }

    // tests
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

        $this->repository->expects($this->once())->method('createNew')->with($data)->willReturn($this->getTestItem());

        $successful = $this->service->createNew($data);

        $this->assertTrue($successful);
    }

    private function getTestItemData()
    {
        return [
            'name' => $this->getFaker()->word,
            'rate' => $this->getFaker()->numerify('##.##')
        ];
    }

    private function getTestItem()
    {
        $item = new Item();
        $item->setName($this->getFaker()->word);
        return $item;
    }

    public function testCreateNewFailsWhenDataIsInvalid()
    {
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('setData')->with($data)->willReturn(null);

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(false);

        $successful = $this->service->createNew($data);

        $this->assertFalse($successful);
    }

    public function testBindToFormBindsAnItemToForm()
    {
        $item = $this->getTestItem();
        $item->setName('Foo');

        $this->form->expects($this->once())->method('bind')->with($item);
        $this->service->bindToForm($item);

    }

    public function testUpdateThrowsExceptionIfFormNotBoundToAnyItem()
    {
        $this->setExpectedException('Exception');
        $this->form->expects($this->once())->method('getObject')->willReturn(null);

        $data = $this->getTestItemData();
        $this->service->update($data);
    }

    public function testUpdateFailsIfDataIsInvalid()
    {
        $item = $this->getTestItem();
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('getObject')->willReturn($item);
        $this->form->expects($this->once())->method('setData')->with($data);

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(false);

        $successful = $this->service->update($data);

        $this->assertFalse($successful);
    }

    public function testUpdateSucceedsIfDataIsValid()
    {
        $item = $this->getTestItem();
        $data = $this->getTestItemData();

        $this->form->expects($this->once())->method('getObject')->willReturn($item);
        $this->form->expects($this->once())->method('setData')->with($data);

        // The form says the data is invalid
        $this->form->expects($this->once())->method('isValid')->willReturn(true);

        $this->form->expects($this->once())->method('getData')->willReturn($item);
        $this->repository->expects($this->once())->method('update')->with($item);

        $successful = $this->service->update($data);

        $this->assertTrue($successful);
    }

    public function testGetFormReturnsTheForm()
    {
        $this->assertEquals($this->form, $this->service->getForm());
    }

    public function testFetchReturnsCorrespondingItemEntity()
    {
        $itemId = 1;
        $item = $this->getTestItem();
        $this->repository->expects($this->once())->method('find')->with($itemId)->willReturn($item);
        $result = $this->service->fetch($itemId);

        $this->assertEquals($item, $result);
    }

    public function testFetchThrowsExceptionIfTheRepositoryReturnsNull()
    {
        $this->setExpectedException('Foundation\Exception\NotFoundException');

        $notExistingItemId = 6;
        $this->repository->expects($this->once())->method('find')->with($notExistingItemId)->willReturn(null);
        $this->service->fetch($notExistingItemId);
    }

    public function testRemoveWorks()
    {
        $item = $this->getTestItem();
        $this->repository->expects($this->once())->method('remove')->with($item);

        $this->assertTrue($this->service->remove($item));
    }

}