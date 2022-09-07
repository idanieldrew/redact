<?php

namespace Module\Post\Repository\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Module\Post\Filters\BlueTick;
use Module\Post\Filters\FilterPost;
use Module\Post\Filters\Published;
use Module\Post\Http\Resources\v1\PostCollection;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Repository\PostRepository as Repository;

class PostRepository extends Repository
{
    /**
     * Paginate $this->model
     *
     * @param int $number
     * @return PostCollection
     */
    public function paginate(int $number = 10): PostCollection
    {
        return Cache::remember('posts.all', 900, function () use ($number) {
            return new PostCollection($this->model()->with(['user', 'tags:name', 'media'])->paginate($number));
        });
    }

    /**
     * Display the specified resource.
     *
     * @param string $post
     * @return PostResource
     */
    public function show(string $post): PostResource
    {
        return Cache::remember("post/$post", 900, function () use ($post) {
            return new PostResource(
                $this->model()->where('slug', $post)->with(['user', 'tags', 'media', 'comments'])->firstOrFail()
            );
        });
    }

    /**
     * Search in Module\Post\Models\Post
     * @param string $keyword
     * @return object
     */
    public function search(string $keyword): object
    {
        return app(Pipeline::class)
            ->send($this->model())
            ->through([
                Published::class,
                BlueTick::class,
                FilterPost::class
            ])
            ->thenReturn()
            ->cursor();
    }

    /**
     * Destroy User model
     *
     * @param Post $post
     * @return bool
     */
    public function destroy(Post $post): bool
    {
        return $post->delete();
    }

    /**
     * Generate short link
     *
     * @param string $link
     * @return Builder|Model|object|null
     */
    public function checkUniqueShortLink($link)
    {
        return $this->model()->where('short_link', $link)->first();
    }
}
