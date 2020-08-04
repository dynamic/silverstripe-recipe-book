<?php

namespace Dynamic\RecipeBook\Page;

use SilverStripe\ORM\PaginatedList;

class RecipeLandingController extends \PageController
{
    public function paginatedList(HTTPRequest $request = null)
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
        $this->owner->extend('updatePaginatedList', $records);

        return $records;
    }
}
