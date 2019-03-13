<?php

namespace Dynamic\RecipeBook\Test\Page;

use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipePageTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipePage::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
