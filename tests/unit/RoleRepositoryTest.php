<?php

use Order\Entity\Role;
use Tests\Traits\EntityManagerAwareTrait;

class RoleRepositoryTest extends \Codeception\TestCase\Test
{
    use EntityManagerAwareTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Order\Entity\RoleRepository
     */
    protected $repository;

    const ENTITY_CLASS = 'Order\Entity\Role';

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

    private function createDummyItem($name, Role $parent = null)
    {
        $role = new Role();
        $role->setRoleId($name);

        if (!is_null($parent)) {
            $role->setParent($parent);
        }

        $this->em->persist($role);
        $this->em->flush();

        return $role;
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
        $this->createDummyItem('Test Role');

        $list = $this->repository->fetchList();

        $items = $list->getIterator()->getArrayCopy();
        $total = $list->count();

        // Assert has items
        $this->assertTrue(is_array($items));
        $this->assertNotEmpty($items);
        $this->assertEquals(1, $total);

        // Should be instance of Role Entity
        $first = array_pop($items);
        $this->assertInstanceOf(self::ENTITY_CLASS, $first);
    }

    public function testFetchListReturnItemsBasedOnPagination()
    {
        $totalRecords = 10;
        for ($i = 1; $i <= $totalRecords; $i++) {
            $this->createDummyItem('Role' . $i);
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