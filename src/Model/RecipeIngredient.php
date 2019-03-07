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
 * @method RecipePage RecipePage()
 */
class RecipeIngredient extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Recipe Ingredient';

    /**
     * @var string
     */
    private static $plural_name = 'Recipe Ingredients';

    /**
     * @var string
     */
    private static $description = 'An ingredient used in a Recipe';

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Sort' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Recipe' => RecipePage::class,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Sort';

    /**
     * @var string
     */
    private static $table_name = 'RecipeIngredient';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab('Root.Main', TextField::create('Title')->setTitle('Ingredient and measurement'));
            $fields->removeByName('Sort');
        });

        return parent::getCMSFields();
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
