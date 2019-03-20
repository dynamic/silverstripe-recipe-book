<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DB;

class RecipeCategoryPage extends \Page
{
    /**
     * @var string
     */
    private static $singular_name = 'Recipe Category';

    /**
     * @var string
     */
    private static $plural_name = 'Recipe Categories';

    /**
     * @var string
     */
    private static $description = 'A category for recipes.';

    /**
     * @var array
     */
    private static $db = [
        'RecipesPerPage' => 'Int',
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Recipes' => RecipePage::class,
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'RecipesPerPage' => 9,
    ];

    /**
     * @var array
     */
    private static $allowed_children = [
        RecipeCategoryPage::class,
        RecipePage::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'RecipeCategoryPage';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Main',
                NumericField::create('RecipesPerPage')
                    ->setTitle(_t(__CLASS__ . '.RecipesPerPage', 'Recipes Per Page')),
                'Content'
            );
        });

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sidebar',
        ]);

        return $fields;
    }

    public function getRecipeList()
    {
        $categories = RecipeCategoryPage::get()->filter('ParentID', $this->data()->ID)->column('ID');
        $categories[] = $this->data()->ID;

        $recipes = RecipePage::get()
            ->filterAny([
                'ParentID' => $categories,
                'Categories.ID' => $categories,
            ]);

        return $recipes;
    }

    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function getFeaturedRecipes()
    {
        $recipes = $this->getRecipeList()
            ->sort('Weight DESC')
            ->limit(15);

        $random = DB::get_conn()->random();
        return $recipes->sort($random);
    }
}
