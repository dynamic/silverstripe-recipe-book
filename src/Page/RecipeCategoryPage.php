<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DB;

/**
 * Class \Dynamic\RecipeBook\Page\RecipeCategoryPage
 *
 * @property int $RecipesPerPage
 * @method \SilverStripe\ORM\ManyManyList|\Dynamic\RecipeBook\Page\RecipePage[] Recipes()
 */
class RecipeCategoryPage extends \Page
{
    /**
     * @var string
     */
    private static string $singular_name = 'Recipe Category';

    /**
     * @var string
     */
    private static string $plural_name = 'Recipe Categories';

    /**
     * @var string
     */
    private static string $description = 'A category for recipes.';

    /**
     * @var array
     */
    private static array $db = [
        'RecipesPerPage' => 'Int',
    ];

    /**
     * @var array
     */
    private static array $belongs_many_many = [
        'Recipes' => RecipePage::class,
    ];

    /**
     * @var array
     */
    private static array $defaults = [
        'RecipesPerPage' => 9,
    ];

    /**
     * @var array
     */
    private static array $allowed_children = [
        RecipeCategoryPage::class,
        RecipePage::class,
    ];

    /**
     * @var string
     */
    private static string $table_name = 'RecipeCategoryPage';

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Main',
                NumericField::create('RecipesPerPage')
                    ->setTitle(_t(__CLASS__ . '.RecipesPerPage', 'Recipes Per Page')),
                'Content'
            );

            $fields->dataFieldByName('Content')
                ->setTitle('Summary')
                ->setRows(5);
        });

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sidebar',
        ]);

        return $fields;
    }

    /**
     * @return DataList
     */
    public function getRecipeList(): DataList
    {
        $categories = RecipeCategoryPage::get()->filter('ParentID', $this->data()->ID)->column('ID');
        $categories[] = $this->data()->ID;

        return RecipePage::get()
            ->filterAny([
                'ParentID' => $categories,
                'Categories.ID' => $categories,
            ]);
    }

    /**
     * @return DataList
     */
    public function getFeaturedRecipes(): DataList
    {
        $recipes = $this->getRecipeList()
            ->sort('Weight DESC')
            ->limit(15);

        $random = DB::get_conn()->random();
        return $recipes->sort($random);
    }
}
