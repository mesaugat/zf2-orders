<?php 

namespace Tests\Functional;

use FunctionalTester;

class ItemCest
{
    public function testAddItem(FunctionalTester $I)
    {
        $I->wantTo('Add a Item');
        $I->amOnPage('/items');
        $I->click('Create New');
        $I->seeCurrentUrlEquals('/items/add');
        $I->fillField('name', 'iPod Classic');
        $I->fillField('rate', '72.50');
        $I->click('Create');

        $I->seeCurrentUrlEquals('/items');
        $I->seeInDatabase('items', ['name' => 'iPod Classic', 'rate' => '72.50']);
    }

    public function testEditItem(FunctionalTester $I)
    {
        $I->wantTo('Edit a Item');
        $I->amOnPage('/items');
        $I->click('Edit');
        $I->seeCurrentUrlMatches('~/items/edit/(\d+)~');
        $I->fillField('name', 'iPod Nano');
        $I->fillField('rate', '20.20');
        $I->click('Update Post');

        $I->seeCurrentUrlEquals('/items');
        $I->seeInDatabase('items', ['name' => 'iPod Nano', 'rate' => '20.20']);
    }

    public function testDeleteItem(FunctionalTester $I)
    {
        $I->wantTo('Delete a Item');
        $I->amOnPage('/items');
        $I->click('Delete');
        $I->seeCurrentUrlMatches('~/items/delete/(\d+)~');
        $I->click('yes');

        $I->seeCurrentUrlEquals('/items');
        $I->dontSeeInDatabase('items', ['name' => 'iPod Nano', 'rate' => '20.20']);
    }
}

