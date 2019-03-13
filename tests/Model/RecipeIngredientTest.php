<?php

namespace Dynamic\RecipeBook\Test\Model;

use Dynamic\RecipeBook\Model\RecipeIngredient;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipeIngredientTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipeIngredient::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
