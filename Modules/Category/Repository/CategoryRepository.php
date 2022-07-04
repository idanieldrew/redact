<?php

namespace Module\Category\Repository;

use Module\Category\Models\Category;
use Module\Share\Repository\Repository;

class CategoryRepository extends Repository
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return Category::query();
    }
}
