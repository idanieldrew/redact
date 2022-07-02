<?php

namespace Module\Tag\Repository;

use Module\Category\Models\Category;
use Module\Share\Repository\Repository;
use Module\Tag\Models\Tag;

class TagRepository extends Repository
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return Tag::query();
    }
}
