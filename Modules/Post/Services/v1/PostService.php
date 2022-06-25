<?php

namespace Module\Post\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Module\Media\Services\v1\MediaService;
use Module\Post\Events\PostPublish;
use Module\Post\Http\Requests\v1\PostRequest;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Services\PostService as Service;
use Module\Tag\Services\v1\TagService;
use Module\User\Http\Requests\v1\UserRequest;

class PostService extends Service
{
    /**
     * Create new post
     * @param PostRequest $request
     * @return PostResource
     */
    public function store(PostRequest $request): PostResource
    {
        // Create post
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description,
            'banner' => $request->banner
        ]);

        // Upload media(s)
        if ($request->attachment && ($request->attachment instanceof UploadedFile)) {
            $media = MediaService::privateUpload($request->attachment);
            $post->medias()->create([
                'files' => $media->files,
                'type' => $media->type,
                'name' => $media->name,
                'isPrivate' => $media->isPrivate,
                'user_id' => $media->user_id
            ]);
        }

        // Create Tag(s)
        $tagService = resolve(TagService::class);
        $tags = $tagService->store($request->tag_request);

        // Sync post & tag(s)
        $post->tags()->sync($tags);

        // Report to admins
        PostPublish::dispatch($post->slug);

        return new PostResource($post);
    }

    /**
     * Update post
     * @param string $post
     * @param UserRequest; $request
     * @return null
     */
    public function update(string $post, $request)
    {
        // Just user can edit our information
        if (Gate::denies('update', [Post::class, $post])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $post->update([
            'title' => $request->title,
            'details' => $request->details,
            'description' => $request->description,
            'published' => $request->published,
        ]);
    }
}
