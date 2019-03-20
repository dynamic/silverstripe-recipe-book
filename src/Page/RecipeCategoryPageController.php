<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\PaginatedList;

class RecipeCategoryPageController extends \PageController
{
    /**
     * @param HTTPRequest|null $request
     * @return PaginatedList
     */
    public function paginatedList(HTTPRequest $request = null)
    {
        if (!$request instanceof HTTPRequest) {
            $request = $this->getRequest();
        }

        $recipes = $this->data()->getRecipeList();

        $start = ($request->getVar('start')) ? (int)$request->getVar('start') : 0;

        $records = PaginatedList::create($recipes, $request);
        $records->setPageStart($start);
        $records->setPageLength($this->data()->RecipesPerPage);
        
        // allow $records to be updated via extension
        $this->extend('updatePaginatedList', $records);

        return $records;
    }
}
