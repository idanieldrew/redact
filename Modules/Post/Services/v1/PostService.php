<?php

namespace Module\Post\Services\v1;

use Module\Post\Events\PostPublish;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Services\PostService as Service;

class PostService extends Service
{
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