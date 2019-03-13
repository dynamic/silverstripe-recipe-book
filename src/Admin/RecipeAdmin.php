<?php

namespace Dynamic\RecipeBook\Admin;

use Dynamic\RecipeBook\Model\RecipeCategory;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class RecipeAdmin
 * @package Dynamic\RecipeBook\Admin
 */
class RecipeAdmin extends ModelAdmin
{
    /**
     * @var string
     */
    private static $menu_title = 'Recipes';

    /**
     * @var string
     */
    private static $url_segment = 'recipes-admin';

    /**
     * @var array
     */
    private static $managed_models = [
        RecipeCategory::class,
    ];
}
