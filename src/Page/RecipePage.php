<?php

namespace Dynamic\RecipeBook\Page;

use Dynamic\RecipeBook\Model\RecipeDirection;
use Dynamic\RecipeBook\Model\RecipeIngredient;
use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use Sheadawson\Linkable\Models\EmbeddedObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\HasManyList;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Versioned\GridFieldArchiveAction;
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
    private static $singular_name = 'Recipe';

    /**
     * @var string
     */
    private static $plural_name = 'Recipes';

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
        'Categories' => RecipeCategoryPage::class,
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
    private static $defaults = [
        'ShowInMenu' => false,
        'RelatedLimit' => 2,
    ];

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

            $fields->addFieldsToTab(
                'Root.Main',
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
                    )->setTitle('Info'),
                ],
                'Content'
            );

            if ($this->exists()) {
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

                $fields->addFieldsToTab(
                    'Root.Categories',
                    [
                        ReadonlyField::create('PrimaryCategoryDisplay')
                            ->setTitle('Primary Category')
                            ->setValue($this->getPrimaryCategory()->Title),
                        $categories = GridField::create(
                            'Categories',
                            'Additional Categories',
                            $this->Categories()->exclude('ID', $this->ParentID)->sort('SortOrder'),
                            $catConfig = GridFieldConfig_RelationEditor::create()
                        ),
                    ]
                );

                $ingredientsConfig
                    ->addComponent(new GridFieldOrderableRows('Sort'))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

                $directionsConfig
                    ->addComponent(new GridFieldOrderableRows('Sort'))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

                $catConfig
                    ->removeComponentsByType([
                        GridFieldAddExistingAutocompleter::class,
                        GridFieldArchiveAction::class,
                        GridFieldEditButton::class,
                    ])
                    ->addComponents(
                        new GridFieldOrderableRows('SortOrder'),
                        $list = new GridFieldAddExistingSearchButton()
                    );

                $list->setSearchList(RecipeCategoryPage::get()->exclude('ID', $this->ParentID));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return RecipeCategory|DataObject|null
     */
    public function getPrimaryCategory()
    {
        return $this->Parent();
    }

    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function getCategoryList()
    {
        $categories[] = $this->ParentID;

        foreach ($this->Categories() as $cat) {
            $categories[] = $cat->ID;
        }

        $records = RecipeCategoryPage::get()->byIDs($categories);

        return $records;
    }

    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function getRelatedRecipes()
    {
        $categories = $this->getCategoryList()->column('ID');

        $recipes = RecipePage::get()
            ->exclude('ID', $this->ID)
            ->filterAny([
                'ParentID' => $categories,
                'Categories.ID' => $categories,
            ])
            ->limit(15);

        $random = DB::get_conn()->random();
        $records = $recipes->sort($random)->limit($this->RelatedLimit);

        return $records;
    }
}
