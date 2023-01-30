<?php

namespace Module\Media\Repositories\v1;

use Module\Media\Repositories\MediaRepository as Repository;

class MediaRepository extends Repository
{
    /**
     * @param  int  $number
     * @return PostCollection
     */
    public function paginate(int $number = 10): PostCollection
    {
        return Cache::remember('posts.all', 900, function () use ($number) {
            return new PostCollection(Post::query()->with(['user', 'tags:name'])->paginate($number));
        });
    }
}
