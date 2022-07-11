<?php

namespace Module\Tag\Services;

use Module\Share\Service\Service;
use Module\Tag\Models\Tag;

class TagService implements Service
{
    public function model()
    {
        return Tag::query();
    }
}
