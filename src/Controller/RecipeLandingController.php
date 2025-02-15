<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;

/**
 * Class \Dynamic\RecipeBook\Page\RecipeLandingController
 *
 * @property \Dynamic\RecipeBook\Page\RecipeLanding $dataRecord
 * @method \Dynamic\RecipeBook\Page\RecipeLanding data()
 * @mixin \Dynamic\RecipeBook\Page\RecipeLanding
 */
class RecipeLandingController extends \PageController
{
    /**
     * @param HTTPRequest|null $request
     * @return PaginatedList
     */
    public function paginatedList(HTTPRequest $request = null): PaginatedList
    {
        if ($request === null) {
            $request = $this->request;
        }
        $start = ($request->getVar('start')) ? (int) $request->getVar('start') : 0;

        $records = PaginatedList::create($this->data()->Children(), $request);
        $records->setPageStart($start);

        if ($limit = $this->data()->PerPage) {
            $records->setPageLength($limit);
        }

        // allow $records to be updated via extension
        $this->extend('updatePaginatedList', $records);

        return $records;
    }
}
