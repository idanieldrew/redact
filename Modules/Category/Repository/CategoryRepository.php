<?php

namespace Module\Category\Repository;

use Module\Category\Models\Category;
use Module\Share\Repository\Repository;

class CategoryRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Category::query();
    }
}