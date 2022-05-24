<?php

namespace Module\Post\Repository\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;
use Module\Post\Http\Resources\v1\PostCollection;
use Module\Post\Models\Post;
use Module\Post\Repository\PostRepository as Repository;

class PostRepository extends Repository
{
    /**
     * Paginate $this->model
     *
     * @param int $number
     * @return Post
     */
    public function paginate($number = 10)
    {
        return Cache::remember('posts.all', 900, function () use ($number) {
            return new PostCollection(Post::query()->paginate($number));
        });
    }

    /**
     * Show $this->model
     * @param string $post
     * @return object
     */
    public function show($post)
    {
        return $this->model()->firstOrFail();
    }

    /**
     * Destroy User model
     *
     * @param  \Module\Post\Models\Post $post
     * @return boolean
     */
    public function destroy($post)
    {
        if (Gate::denies('delete', [Post::class, $post])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $post->delete();
    }
}