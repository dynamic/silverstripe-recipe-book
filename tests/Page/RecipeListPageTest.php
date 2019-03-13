<?php

namespace Dynamic\RecipeBook\Test\Page;

use Dynamic\RecipeBook\Page\RecipeListPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipeListPageTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(RecipeListPage::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
