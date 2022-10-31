<?php

namespace Module\Post\Repository\v1;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Module\Comment\Http\Resources\v1\CommentCollection;
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
     * @return array
     */
    public function show(string $post): array
    {
        return Cache::remember("post/$post", 900, function () use ($post) {

            $res = $this->specialPost($post);

            return [
                'post' => new PostResource($res[0]),
                'otherPosts' => new PostCollection($res[1])
            ];
        });
    }

    /**
     * Search in Module\Post\Models\Post
     * @param string $keyword
     * @return object
     */
    public function search(string $keyword): object
    {
        // elastic engine
        return Post::search($keyword)
            ->where('published', false)
            ->where('blue_tick', request()->blue_tick)
            ->cursor();

        /* Filter with pipeline laravel
        return app(Pipeline::class)
            ->send($this->model())
            ->through([
                Published::class,
                BlueTick::class,
                FilterPost::class
            ])
            ->thenReturn()
            ->cursor();
        */
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

    /**
     * Generate short link
     *
     * @param $post
     * @return CommentCollection
     */
    public function comments($post)
    {
        return new CommentCollection($post->comments);
    }

    /**
     * post & similar posts
     * @param string $post
     * @return array
     * @throws Exception
     */
    private function specialPost(string $post): array
    {
        DB::beginTransaction();

        try {
            $mainPost = $this->model()
                ->where('slug', $post)
                ->with(['user', 'categories', 'tags', 'media', 'comments'])
                ->firstOrFail();

            // Similar post with $mainPost
            $otherPosts = $this->model()->whereHas('categories', function ($query) use ($mainPost) {
                $query->where('slug', $mainPost->categories->all()[0]->slug);
            })->where('slug', '!=', $mainPost->slug)->get(['title', 'details']);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return [$mainPost, $otherPosts];
    }
}
