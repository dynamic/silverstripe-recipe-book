<?php

namespace Dynamic\RecipeBook\Test\Page;

use Dynamic\RecipeBook\Page\RecipeCategoryPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipeCategoryPageTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipeCategoryPage::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
