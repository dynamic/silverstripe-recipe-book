<?php

namespace Dynamic\RecipeBook\Page;

class RecipeListPageController extends \PageController
{
    /**
     * @return \SilverStripe\ORM\DataList
     */
    public function PaginatedList(HTTPRequest $request = null)
    {
        $cats = [];
        foreach ($this->Categories() as $category) {
            $cats->push($category->ID);
        }

        $recipes = RecipePage::get()
            ->filterAny([
                'Categories.ID' => $cats,
            ]);

        $start = ($request->getVar('start')) ? (int) $request->getVar('start') : 0;

        $records = PaginatedList::create($recipes, $request);
        $records->setPageStart($start);
        $records->setPageLength($this->data()->RecipesPerPage);

        // allow $records to be updated via extension
        $this->owner->extend('updatePaginatedList', $records);

        return $records;
    }
}
