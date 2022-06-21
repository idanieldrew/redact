<?php

namespace Module\Post\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Module\Post\Events\PostPublish;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Services\PostService as Service;
use Module\Tag\Services\v1\TagService;

class PostService extends Service
{
    /**
     * Create new post
     * @param \Module\Post\Http\Requests\v1\PostRequest $request
     * @return \Module\Post\Http\Resources\v1\PostResource
     */
    public function store($request)
    {
        // Create post
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description,
            'banner' => $request->banner
        ]);

        // Create Tags or tag
        $tagService = resolve(TagService::class);
        $tags = $tagService->store($request->tag_request);

        // Sync post and tag(s)
        $post->tags()->sync($tags);

        // Report to admins
        PostPublish::dispatch($post->slug);

        return new PostResource($post);
    }

    /**
     * Update post
     * @param string $post
     * @param \Module\User\Http\Requests\v1\UserRequest; $request
     * @return null
     */
    public function update($post, $request)
    {
        // Just user can edit our information
        if (Gate::denies('update', [Post::class, $post])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $post->update($request->all());
    }
}