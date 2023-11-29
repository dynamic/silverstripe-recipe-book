<?php

namespace Dynamic\RecipeBook\Model;

use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

/**
 * Class RecipeIngredient
 * @package Dynamic\Nucu\Model
 *
 * @property string $Title
 * @property int $Sort
 * @property int $RecipeID
 * @method RecipePage Recipe()
 */
class RecipeIngredient extends DataObject
{
    /**
     * @var string
     */
    private static string $singular_name = 'Recipe Ingredient';

    /**
     * @var string
     */
    private static $plural_name = 'Recipe Ingredients';

    /**
     * @var string
     */
    private static string $description = 'An ingredient used in a Recipe';

    /**
     * @var array
     */
    private static array $db = [
        'Title' => 'Varchar(255)',
        'Sort' => 'Int',
    ];

    /**
     * @var array
     */
    private static array $has_one = [
        'Recipe' => RecipePage::class,
    ];

    /**
     * @var string
     */
    private static string $default_sort = 'Sort';

    /**
     * @var string
     */
    private static string $table_name = 'RecipeIngredient';

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $recipe = $fields->dataFieldByName('RecipeID');
            $fields->replaceField('RecipeID', $recipe->performReadonlyTransformation());

            $fields->addFieldToTab('Root.Main', TextField::create('Title')->setTitle('Ingredient and measurement'));
            $fields->removeByName('Sort');
        });

        return parent::getCMSFields();
    }

    /**
     * @return void
     */
    protected function onBeforeWrite(): void
    {
        parent::onBeforeWrite();

        if (!$this->Sort) {
            $this->Sort = static::get()->filter('RecipeID', $this->RecipeID)->max('Sort') + 1;
        }
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canCreate($member = null, $context = []): bool
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null): bool
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null): bool
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null): bool
    {
        return true;
    }
}
