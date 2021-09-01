<?php

namespace Dynamic\RecipeBook\Test\Model;

use Dynamic\RecipeBook\Model\RecipeDirection;
use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;

class RecipeDirectionTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipeDirection::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * @throws ValidationException
     */
    public function testDefaultSortValue()
    {
        $recipe = $this->objFromFixture(RecipePage::class, 'two');

        $direction = RecipeDirection::create();
        $direction->Title = 'My First Direction';
        $direction->RecipeID = $recipe->ID;

        $this->assertEquals(0, $direction->Sort);

        $direction->write();

        $this->assertNotEquals(0, $direction->Sort);

        $direction2 = RecipeDirection::create();
        $direction2->Title = 'My Second Direction';
        $direction2->RecipeID = $recipe->ID;

        $this->assertEquals(0, $direction2->Sort);

        $direction2->write();

        $this->assertGreaterThan($direction->Sort, $direction2->Sort);
    }
}
