<?php

namespace Module\Post\Repository;

use Module\Post\Models\Post;
use Module\Share\Repository\Repository;

class PostRepository extends Repository
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