<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\ORM\DB;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\HasManyList;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\GridField\GridField;
use Dynamic\RecipeBook\Model\RecipeDirection;
use Dynamic\RecipeBook\Model\RecipeIngredient;
use Dynamic\RecipeBook\Page\RecipeCategoryPage;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

/**
 * Class RecipePage
 * @package Dynamic\RecipeBook\Page
 *
 * @property int $Servings
 * @property string $PrepTime
 * @property string $CookTime
 * @property string $Difficulty
 * @method HasManyList Ingredients()
 * @method HasManyList Directions()
 * @method ManyManyList Categories()
 */
class RecipePage extends \Page
{
    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Recipe';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Recipes';

    /**
     * @var string
     * @config
     */
    private static string $table_name = 'RecipePage';

    /**
     * @var array
     * @config
     */
    private static array $db = [
        'Servings' => 'Varchar(20)',
        'PrepTime' => 'Varchar(255)',
        'CookTime' => 'Varchar(255)',
        'Difficulty' => 'Varchar(255)',
    ];

    /**
     * @var array
     * @config
     */
    private static $has_one = [
        'Image' => Image::class,
    ];

    /**
     * @var array
     */
    private static array $has_many = [
        'Ingredients' => RecipeIngredient::class,
        'Directions' => RecipeDirection::class,
    ];

    /**
     * @var array
     * @config
     */
    private static array $many_many = [
        'Categories' => RecipeCategoryPage::class,
    ];

    /**
     * @var array
     * @config
     */
    private static array $many_many_extraFields = [
        'Categories' => [
            'SortOrder' => 'Int',
        ],
    ];

    /**
     * @var string[]
     */
    private static $owns = [
        'Image',
    ];

    /**
     * @var array
     * @config
     */
    private static $cascade_duplicates = [
        'Image',
        'Ingredients',
        'Directions',
    ];

    /**
     * @var array
     * @config
     */
    private static array $defaults = [
        'ShowInMenu' => false,
        'RelatedLimit' => 2,
    ];

    /**
     * @var bool
     * @config
     */
    private static bool $can_be_root = false;

    /**
     * @var bool
     * @config
     */
    private static bool $show_in_sitetree = false;

    /**
     * @var array
     * @config
     */
    private static array $allowed_children = [];

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->insertAfter(
                'Title',
                UploadField::create('Image')
                    ->setAllowedMaxFileNumber(1)
                    ->setAllowedFileCategories('image')
                    ->setFolderName('Uploads/Recipe/Image')
            );

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

            $fields->dataFieldByName('Content')
                ->setTitle('Summary')
                ->setRows(5);

            if ($this->exists()) {
                $fields->addFieldToTab(
                    'Root.Ingredients',
                    GridField::create(
                        'Ingredients',
                        'Ingredients',
                        $this->Ingredients(),
                        $ingredientsConfig = GridFieldConfig::create()
                    )
                );

                $fields->addFieldToTab(
                    'Root.Directions',
                    GridField::create(
                        'Directions',
                        'Directions',
                        $this->Directions(),
                        $directionsConfig = GridFieldConfig::create()
                    )
                );

                $fields->addFieldsToTab(
                    'Root.Categories',
                    [
                        ReadonlyField::create('PrimaryCategoryDisplay')
                            ->setTitle('Primary Category')
                            ->setValue($this->getPrimaryCategory()->Title),
                        GridField::create(
                            'Categories',
                            'Additional Categories',
                            $this->Categories()->exclude('ID', $this->ParentID)->sort('SortOrder'),
                            $catConfig = GridFieldConfig_RelationEditor::create()
                        ),
                    ]
                );

                $ingredientsConfig
                    ->addComponent(new GridFieldOrderableRows('Sort'))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->addComponent(GridFieldButtonRow::create('before'))
                    ->addComponent(GridFieldToolbarHeader::create())
                    ->addComponent(GridFieldTitleHeader::create())
                    ->addComponent(GridFieldEditableColumns::create())
                    ->addComponent(GridFieldDeleteAction::create())
                    ->addComponent(GridFieldAddNewInlineButton::create());

                $directionsConfig
                    ->addComponent(new GridFieldOrderableRows('Sort'))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->addComponent(GridFieldButtonRow::create('before'))
                    ->addComponent(GridFieldToolbarHeader::create())
                    ->addComponent(GridFieldTitleHeader::create())
                    ->addComponent(GridFieldEditableColumns::create())
                    ->addComponent(GridFieldDeleteAction::create())
                    ->addComponent(GridFieldAddNewInlineButton::create())
                    ->addComponent(GridFieldEditButton::create());

                $directionsConfig->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
                    'Title' => array(
                        'title' => 'Title',
                        'field' => TextField::class
                    ),
                ));

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
     * @return RecipeCategoryPage|DataObject
     */
    public function getPrimaryCategory(): RecipeCategoryPage|DataObject
    {
        return $this->Parent();
    }

    /**
     * @return DataList
     */
    public function getCategoryList(): DataList
    {
        $categories[] = $this->ParentID;

        foreach ($this->Categories() as $cat) {
            $categories[] = $cat->ID;
        }

        return RecipeCategoryPage::get()->byIDs($categories);
    }

    /**
     * @return DataList
     */
    public function getRelatedRecipes(): DataList
    {
        $categories = $this->getCategoryList()->column();

        $recipes = RecipePage::get()
            ->exclude('ID', $this->ID)
            ->filterAny([
                'ParentID' => $categories,
                'Categories.ID' => $categories,
            ])
            ->limit(15);

        $random = DB::get_conn()->random();
        return $recipes->sort($random)->limit($this->RelatedLimit);
    }
}
