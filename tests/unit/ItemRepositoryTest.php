<?php

use Order\Entity\Item;

use Tests\Traits\EntityManagerAwareTrait;

class ItemRepositoryTest extends \Codeception\TestCase\Test
{
    use EntityManagerAwareTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Order\Entity\Repository\ItemRepository
     */
    protected $repository;

    const ENTITY_CLASS = 'Order\Entity\Item';

    protected function _before()
    {
        $this->repository = $this->getEntityManager()->getRepository(self::ENTITY_CLASS);

        $this->clearItems();
    }

    protected function _after()
    {
        $this->clearItems();
    }

    protected function clearItems()
    {
        $this->em->createQuery('DELETE FROM ' . self::ENTITY_CLASS)->execute();
    }

    public function testCreatingNewItem()
    {
        $data = [
            'name' => 'Coffee Mug',
            'rate' => '90.00'
        ];
        $this->tester->cantSeeInRepository(self::ENTITY_CLASS, $data);

        $this->repository->createNew($data);

        $this->tester->canSeeInRepository(self::ENTITY_CLASS, $data);
    }

    private function createDummyItem($name, $rate)
    {
        $item = new Item();
        $item->setName($name);
        $item->setRate($rate);
        $this->em->persist($item);
        $this->em->flush();

        return $item;
    }

    public function testDeletingAnItem()
    {
        $item = $this->createDummyItem('Item on Test', '67.77');

        $this->tester->canSeeInRepository(self::ENTITY_CLASS, [
            'name' => 'Item on Test'
        ]);
        // Delete the item
        $this->repository->remove($item);

        $this->tester->cantSeeInRepository(self::ENTITY_CLASS, [
            'name' => 'Item on Test'
        ]);
    }

    public function testUpdatingAnItem()
    {
        $item = $this->createDummyItem('Item on Test', '67.77');

        $this->tester->canSeeInRepository(self::ENTITY_CLASS, [
            'id' => $item->getId(),
            'name' => 'Item on Test',
            'rate' => '67.77'
        ]);

        $newName = 'Updated Test Item';
        $newRate = '127.77';

        $item->setName($newName);
        $item->setRate($newRate);
        $this->repository->update($item);

        $this->tester->canSeeInRepository(self::ENTITY_CLASS, [
            'id' => $item->getId(),
            'name' => $newName,
            'rate' => $newRate
        ]);
    }

    public function testFetchListReturnsPaginatorObject()
    {
        $this->assertInstanceOf('Doctrine\ORM\Tools\Pagination\Paginator', $this->repository->fetchList());
    }

    public function testFetchListReturnsEmptyIfNoRecordsFound()
    {
        $list = $this->repository->fetchList();

        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();

        $this->assertEmpty($items);
        $this->assertEquals(0, $total);
    }

    public function testFetchListReturnItemsIfRecordsFound()
    {
        $this->createDummyItem('Item on Test', '67.77');

        $list = $this->repository->fetchList();

        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();

        // Assert has items
        $this->assertTrue(is_array($items));
        $this->assertNotEmpty($items);
        $this->assertEquals(1, $total);

        // Should be instance of Item Entity
        $first = array_pop($items);
        $this->assertInstanceOf(self::ENTITY_CLASS, $first);
    }

    public function testFetchListReturnItemsBasedOnPagination()
    {
        $totalRecords = 10;
        for ($i = 1; $i <= $totalRecords; $i++) {
            $this->createDummyItem('Item ' . $i, '67.77' . $i);
        }

        $paginationLimit = 8;

        // Fetch First Page
        $paginationOffset = 0;
        $list = $this->repository->fetchList($paginationOffset, $paginationLimit);

        $total = $list->count();

        // Total should be equal to totalRecords
        $this->assertEquals($totalRecords, $total);

        // First page should have only limited records (based on paginationLimit)
        $this->assertEquals($paginationLimit, $list->getIterator()->count());

        // Fetch Second page
        $paginationOffset = 8;
        $list = $this->repository->fetchList($paginationOffset, $paginationLimit);

        // Total should again be equal to totalRecords
        $this->assertEquals($totalRecords, $list->count());

        // Second page should have only 2 items
        $this->assertEquals(2, $list->getIterator()->count());

    }
}
