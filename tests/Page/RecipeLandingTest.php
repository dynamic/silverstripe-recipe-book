<?php

namespace Dynamic\RecipeBook\Test\Page;

use Dynamic\RecipeBook\Page\RecipeLanding;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class RecipeLandingTest extends SapphireTest
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
        $object = $this->objFromFixture(RecipeLanding::class, 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
