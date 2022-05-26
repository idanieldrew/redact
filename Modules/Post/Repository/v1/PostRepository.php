<?php

namespace Module\Post\Repository\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
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
     * Search in Module\Post\Models\Post
     * @param string $keyword
     * @return object
     */
    public function search($keyword)
    {
        return Post::query()
            ->where('title','LIKE',"%" . $keyword . "%")
            ->orWhere('slug','LIKE',"%" . $keyword . "%")
            ->paginate();
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