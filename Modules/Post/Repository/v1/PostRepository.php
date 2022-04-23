<?php

namespace Module\Post\Repository\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Module\Post\Models\Post;
use Module\Share\Repository\Repository;

class PostRepository implements Repository
{
    /**
     * Specify Model
     * Abstract function
     */
    public function model()
    {
        return Post::query();
    }

    /**
     * Paginate $this->model
     * @param int $number
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function paginate($number = 10)
    {
        return $this->model()->paginate($number);
    }

    /**
     * Show $this->model
     * @param string $post
     * @return \Module\Post\Models\Post
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