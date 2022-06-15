<?php

namespace Module\Tag\Repository\v1;

use Illuminate\Support\Facades\Cache;
use Module\Category\Repository\TagRepository as Repository;
use Module\Tag\Http\Resources\v1\TagCollection;
use Module\Tag\Models\Tag;

class TagRepository extends Repository
{
    /**
     * Paginate $this->model()
     *
     * @param int $number
     * @return Tag
     */
    public function paginate($number = 10)
    {
        return Cache::remember('tags.all', 900, function () use ($number) {
            return new TagCollection($this->model()->paginate($number));
        });
    }
}