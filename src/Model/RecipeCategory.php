<?php

namespace Dynamic\RecipeBook\Model;

use Dynamic\RecipeBook\Page\RecipeListPage;
use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Hierarchy\Hierarchy;
use SilverStripe\ORM\ManyManyList;

/**
 * Class Category
 * @package Dynamic\RecipeBook\Model
 *
 * @property string $Title
 * @property int $ParentID
 * @method RecipeCategory Parent()
 * @method ManyManyList Recipes()
 */
class RecipeCategory extends DataObject
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
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Parent' => RecipeCategory::class,
    ];

    /**
     * @var array
     */
    private static $belongs_to = [
        'List' => RecipeListPage::class,
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
    private static $extensions = [
        Hierarchy::class,
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title',
        'Parent.Title' => 'Parent Category',
    ];

    /**
     * @var string
     */
    private static $table_name = 'RecipeCategory';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab('Root.Main', TextField::create('Title')->setTitle('Category Title'));

            if (RecipeCategory::get()->exclude('ID', $this->ID)->exists()) {
                /*
                $fields->addFieldtoTab(
                    'Root.Main',
                    TreeDropdownField::create('ParentID', 'Parent Category', RecipeCategory::class)
                        ->setTitle('Parent Category')
                        ->setFilterFunction(function (RecipeCategory $category) {
                            return $category->ID != $this->ID;
                        })
                );
                */
            }

            $fields->removeByName([
                'Recipes',
                'ParentID',
            ]);
        });

        return parent::getCMSFields();
    }

    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function getFeaturedRecipes()
    {
        $recipes = RecipePage::get()
            ->filter('Categories.ID', $this->ID)
            ->sort('Weight DESC')
            ->limit(15);
        $random = DB::get_conn()->random();
        return $recipes->sort($random);
    }

    /**
     * @return bool
     */
    public function getListLink()
    {
        if ($this->List()->exists()) {
            return $this->List()->Link();
        }
        return false;
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }
}
