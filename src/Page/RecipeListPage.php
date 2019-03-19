<?php

namespace Dynamic\RecipeBook\Page;

use Dynamic\RecipeBook\Model\RecipeCategory;
use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
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

    private static $has_one = [
        'Category' => RecipeCategory::class,
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

            $exclude = RecipeListPage::get()->exclude('ID', $this->ID)->column('CategoryID');

            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create('CategoryID')
                    ->setSource(RecipeCategory::get()->exclude('ID', $exclude)->map())
                    ->setTitle(_t(__CLASS__ . '.RecipeCategory', 'Category'))
                    ->setEmptyString('')
            );
        });

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sidebar',
        ]);

        return $fields;
    }

    /**
     * @return string
     */
    public function getLumberjackTitle()
    {
        return 'Recipes';
    }
}
