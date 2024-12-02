<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\ManyManyList;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class RecipeLanding extends \Page
{
    /**
     * @var array
     */
    private static array $db = [
        'PerPage' => 'Int',
    ];

    /**
     * @var array
     */
    private static array $many_many = [
        'FeaturedCategories' => RecipeCategoryPage::class,
    ];

    /**
     * @var array
     */
    private static array $many_many_extraFields = [
        'FeaturedCategories' => [
            'SortOrder' => 'Int',
        ],
    ];

    /**
     * @var array
     */
    private static array $defaults = [
        'PerPage' => 9,
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Recipe Landing Page';

    /**
     * @var string
     */
    private static string $plural_name = 'Recipe Landing Pages';

    /**
     * @var array
     */
    private static array $allowed_children = [
        RecipeCategoryPage::class,
    ];

    /**
     * @var string
     */
    private static string $table_name = 'RecipeLanding';

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setTitle('Summary')
                ->setRows(5);
            
            if ($this->ID) {
                $config = GridFieldConfig_RelationEditor::create()
                    ->addComponent(new GridFieldOrderableRows('SortOrder'))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->removeComponentsByType(GridFieldAddNewButton::class)
                    ->addComponent(new GridFieldAddExistingSearchButton());
                $cats = $this->FeaturedCategories()->sort('SortOrder');
                $catsField = GridField::create(
                    'FeaturedCategories',
                    'Featured Categories',
                    $cats,
                    $config
                );

                $fields->addFieldsToTab('Root.Featured', array(
                    $catsField,
                ));
            }

            $fields->addFieldsToTab('Root.Browse', [
                NumericField::create('PerPage', 'Categories per page'),
            ]);
        });

        return parent::getCMSFields();
    }

    /**
     * @return ManyManyList
     */
    public function getFeaturedList(): ManyManyList
    {
        return $this->FeaturedCategories()->sort('SortOrder');
    }
}
