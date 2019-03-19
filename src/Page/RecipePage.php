<?php

namespace Dynamic\RecipeBook\Page;

use Dynamic\RecipeBook\Model\RecipeCategory;
use Dynamic\RecipeBook\Model\RecipeDirection;
use Dynamic\RecipeBook\Model\RecipeIngredient;
use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use Sheadawson\Linkable\Models\EmbeddedObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\HasManyList;
use SilverStripe\ORM\ManyManyList;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class RecipePage
 * @package Dynamic\RecipeBook\Page
 *
 * @property int $Servings
 * @property string $PrepTime
 * @property string $CookTime
 * @property string $Difficulty
 * @property int $VideoID
 * @method EmbeddedObject Video()
 * @method HasManyList Ingredients()
 * @method HasManyList Directions()
 * @method ManyManyList Categories()
 */
class RecipePage extends \Page
{

    /**
     * @var string
     */
    private static $table_name = 'RecipePage';

    /**
     * @var array
     */
    private static $db = [
        'Servings' => 'Varchar(20)',
        'PrepTime' => 'Varchar(255)',
        'CookTime' => 'Varchar(255)',
        'Difficulty' => 'Varchar(255)',
        'Weight' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Video' => EmbeddedObject::class,
    ];

    /**
     * @var array
     */
    private static $has_many = [
        'Ingredients' => RecipeIngredient::class,
        'Directions' => RecipeDirection::class,
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
    private static $many_many_extraFields = [
        'Categories' => [
            'SortOrder' => 'Int',
        ],
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title',
        'Ingredients.Title',
        'Categories.Title',
        'Servings',
        'PrepTime',
        'CookTime',
        'Difficulty',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title',
        'PrimaryCategory' => 'Main Category',
        'Servings',
        'PrepTime',
        'CookTime',
        'Difficulty',
        'Weight',
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'ShowInMenu' => false,
        'Weight' => 25,
    ];

    public function populateDefaults()
    {
        $this->Weight = 25;
        return parent::populateDefaults();
    }

    /**
     * @var bool
     */
    private static $can_be_root = false;

    /**
     * @var bool
     */
    private static $show_in_sitetree = false;

    /**
     * @var array
     */
    private static $allowed_children = [];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create('Weight', 'Weight', $this->getWeightValues())
                    ->setDescription('assign a weight to this recipe, 50 being heaviest'),
                'MainContentHD'
            );

            $fields->addFieldsToTab(
                'Root.Info',
                [
                    $toggle = FieldGroup::create(
                        'RecipeStatistics',
                        [
                            TextField::create('Servings')
                                ->setTitle('Servings'),
                            TextField::create('PrepTime')
                                ->setTitle('Prep Time'),
                            TextField::create('CookTime')
                                ->setTitle('Cook Time'),
                            TextField::create('Difficulty')
                                ->setTitle('Difficulty'),
                        ]
                    )->setTitle('Recipe Statistics'),
                    $video = EmbeddedObjectField::create('Video', 'Video', $this->Video()),
                ]
            );

            $fields->addFieldToTab(
                'Root.Ingredients',
                $ingredients = GridField::create(
                    'Ingredients',
                    'Ingredients',
                    $this->Ingredients(),
                    $ingredientsConfig = GridFieldConfig_RelationEditor::create()
                )
            );

            $fields->addFieldToTab(
                'Root.Directions',
                $directions = GridField::create(
                    'Directions',
                    'Directions',
                    $this->Directions(),
                    $directionsConfig = GridFieldConfig_RelationEditor::create()
                )
            );

            $fields->addFieldToTab(
                'Root.Categories',
                $categories = GridField::create(
                    'Categories',
                    'Categories',
                    $this->Categories()->sort('SortOrder'),
                    $catConfig = GridFieldConfig_RelationEditor::create()
                )
            );

            $ingredientsConfig
                ->addComponent(new GridFieldOrderableRows('Sort'))
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

            $directionsConfig
                ->addComponent(new GridFieldOrderableRows('Sort'))
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

            $catConfig
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->addComponent(new GridFieldAddExistingSearchButton())
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
        });

        $fields = parent::getCMSFields();

        $content = $fields->dataFieldByName('Content');

        $fields->removeByName([
            'Content',
            'Sidebar',
        ]);

        $fields->addFieldToTab(
            'Root.Info',
            $content->setTitle('Recipe Description')
        );

        return $fields;
    }

    /**
     * @return RecipeCategory|DataObject|null
     */
    public function getPrimaryCategory()
    {
        return $this->Categories()->sort('SortOrder')->first();
    }

    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function getRelatedRecipes()
    {
        $category = $this->getPrimaryCategory();

        $recipes = RecipePage::get()->exclude('ID', $this->ID);

        if ($category instanceof RecipeCategory) {
            $recipes = $recipes->filter('Categories.ID', $this->getPrimaryCategory()->ID);
        }

        return $recipes;
    }

    /**
     * @return array
     */
    public function getWeightValues()
    {
        $x = 1;
        $y = [];

        while ($x <= 50) {
            $y[$x] = $x;
            $x++;
        }

        return $y;
    }
}
