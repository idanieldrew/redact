<?php

namespace Module\Category\Services;

use Module\Category\Models\Category;
use Module\Share\Service\Service;

class CategoryService implements Service
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
