<?php

namespace Module\Category\Repository;

use Module\Category\Models\Category;
use Module\Share\Repository\Repository;
use Module\Tag\Models\Tag;

class TagRepository extends Repository
{
    public function model()
    {
        return Tag::query();
    }
}