<?php

namespace Dynamic\RecipeBook\Test\Model;

use Dynamic\RecipeBook\Model\RecipeCategory;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipeCategoryTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipeCategory::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
