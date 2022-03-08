<?php

namespace Module\Post\Repository\v1;

use Module\Post\Models\Post;
use Module\Share\Repository\Repository;

class PostRepository extends Repository
{
    public function model()
    {
        return Post::query();
    }
}