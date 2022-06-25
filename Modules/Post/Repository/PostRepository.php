<?php

namespace Module\Post\Repository;

use Module\Post\Models\Post;
use Module\Share\Repository\Repository;

class PostRepository extends Repository
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return Post::query();
    }
}
