<?php

namespace Module\Post\Services;

use Illuminate\Database\Eloquent\Collection;
use Module\Post\Events\PostPublish;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Share\Service\Service;

class PostService implements Service
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Post::query();
    }

    /**
    * Create new post
    * @param \Module\Post\Http\Requests\PostRequest $request
    * @return \Module\Post\Http\Resources\v1\PostResource
    */
    public function store($request)
    {
        $post =  auth()->user()->posts()->create([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description
        ]);

        PostPublish::dispatch($post->slug);

        return new PostResource($post);
    }
}