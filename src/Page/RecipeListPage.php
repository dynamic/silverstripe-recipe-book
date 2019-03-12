<?php

namespace Dynamic\RecipeBook\Page;

use Dynamic\RecipeBook\Model\RecipeCategory;
use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Lumberjack\Model\Lumberjack;

/**
 * Class RecipeListPage
 * @package Dynamic\Nucu\Page
 *
 * @property int $RecipesPerPage
 */
class RecipeListPage extends \Page
{
    /**
     * {@inheritDoc}
     * @var string
     */
    private static $table_name = 'RecipeListPage';

    /**
     * @var array
     */
    private static $db = [
        'RecipesPerPage' => 'Int',
    ];

    /**
     * @var array
     */
    private static $many_many = [
        'Categories' => RecipeCategory::class,
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Lumberjack::class,
    ];

    /**
     * @var array
     */
    private static $allowed_children = [
        RecipePage::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Main',
                NumericField::create('RecipesPerPage')
                    ->setTitle(_t(__CLASS__ . '.RecipesPerPage', 'Recipes Per Page')),
                'Content'
            );

            $fields->addFieldToTab(
                'Root.Main',
                ListboxField::create('Categories')
                    ->setSource(RecipeCategory::get()->map())
                    ->setTitle(_t(__CLASS__ . '.RecipeCategories', 'Recipe Categories'))
            );
        });

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sidebar',
        ]);

        return $fields;
    }
}
