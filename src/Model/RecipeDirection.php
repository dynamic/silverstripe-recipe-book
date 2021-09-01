<?php

namespace Dynamic\RecipeBook\Model;

use Dynamic\RecipeBook\Page\RecipePage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataObject;

/**
 * Class RecipeDirection
 * @package Dynamic\RecipeBook\Page
 *
 * @property string $Title
 * @property int $Sort
 * @property int $RecipeID
 * @method RecipePage Recipe()
 */
class RecipeDirection extends DataObject
{
    /**
     * @var array
     */
    private static $db = [
        'Title' => 'HTMLText',
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
    private static $table_name = 'RecipeDirection';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $recipe = $fields->dataFieldByName('RecipeID');
            $fields->replaceField('RecipeID', $recipe->performReadonlyTransformation());

            $fields->addFieldToTab(
                'Root.Main',
                HTMLEditorField::create('Title')
                    ->setTitle('Direction Step')
                    ->setRows(5)
            );

            $fields->removeByName('Sort');
        });

        return parent::getCMSFields();
    }

    /**
     *
     */
    protected function onBeforeWrite()
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
