<?php

namespace Module\Post\Services;

use Module\Post\Events\PostPublish;
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

    /*
    *Create new post
    * @param \Module\Post\Http\Requests\PostRequest$request
    * @return [\Module\User\Models\User,number]
    */
    public function store($request)
    {
        PostPublish::dispatch(1203);

        return auth()->user()->posts()->create([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description
        ]);
    }
}