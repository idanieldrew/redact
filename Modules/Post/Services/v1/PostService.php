<?php

namespace Module\Post\Services\v1;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Module\Post\Events\PostPublish;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Image;
use Module\Post\Models\Post;
use Module\Post\Services\PostService as Service;
use Illuminate\Support\Str;
use function PHPSTORM_META\type;

class PostService extends Service
{
    /**
    * Create new post
    * @param \Module\Post\Http\Requests\v1\PostRequest $request
    * @return \Module\Post\Http\Resources\v1\PostResource
    */
    public function store($request)
    {
        $post =  auth()->user()->posts()->create([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description,
            'banner' => $request->banner
        ]);
        PostPublish::dispatch($post->slug);

        return new PostResource($post);
    }

    /**
     * Update post
     * @param string $post
     * @param \Module\User\Http\Requests\v1\UserRequest; $request
     * @return null
     */
    public function update($post,$request)
    {
        // Just user can edit our information
        if (Gate::denies('update',[Post::class,$post])){
            abort(Response::HTTP_FORBIDDEN);
        }

        return $post->update($request->all());
    }

    public function storeImages($request)
    {
        $path = "uploads/post";

        foreach ($request->name as $key => $value) {
            $name = $request->images[$key]->hashName();
            $request->images[$key]->move(public_path($path), $name);

            Image::query()->create([
                'name' => $value,
                'address' => $name
            ]);
        }

        return;
    }
}