<?php

namespace Dynamic\RecipeBook\Test\Model;

use Dynamic\RecipeBook\Model\RecipeIngredient;
use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;

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

    /**
     * @throws ValidationException
     */
    public function testDefaultSortValue()
    {
        $recipe = $this->objFromFixture(RecipePage::class, 'two');

        $ingredient = RecipeIngredient::create();
        $ingredient->Title = 'My First Ingredient';
        $ingredient->RecipeID = $recipe->ID;

        $this->assertEquals(0, $ingredient->Sort);

        $ingredient->write();

        $this->assertNotEquals(0, $ingredient->Sort);

        $ingredient2 = RecipeIngredient::create();
        $ingredient2->Title = 'My Second Ingredient';
        $ingredient2->RecipeID = $recipe->ID;

        $this->assertEquals(0, $ingredient2->Sort);

        $ingredient2->write();

        $this->assertGreaterThan($ingredient->Sort, $ingredient2->Sort);
    }
}
