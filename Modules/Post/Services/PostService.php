<?php

namespace Module\Post\Services;

use Module\Post\Models\Post;
use Module\Share\Service\Service;

class PostService implements Service
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Post::query();
    }
}