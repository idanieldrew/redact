<?php

namespace Module\Category\Repository\v1;

use Module\Category\Repository\CategoryRepository as Repository;

class CategoryRepository extends Repository
{
    /**
     *return id categories
     * @param $request
     * @return array
     */
    public function getCategories($request): array
    {
        return $this->model()
            ->whereIn('slug', $request)
            ->get()
            ->pluck('id')
            ->toArray();
    }
}
