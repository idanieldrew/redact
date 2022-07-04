<?php

namespace Module\Post\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Module\Category\Repository\v1\CategoryRepository;
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
        if ($request->attachment) {
            foreach ($request->attachment as $attachment) {
                $this->uploadMedia($post, $attachment);
            }
        }

        // Create Tag(s)
        $tagService = resolve(TagService::class);
        $tags = $tagService->store($request->tag_request);

        // Sync post & tag(s)
        $post->tags()->sync($tags);

        // Sync post with category(s)
        $categoryRepository = resolve(CategoryRepository::class);
        $categories = $categoryRepository->getCategories($request->category);
        $post->categories()->syncWithPivotValues($categories, []);

        // Report to admins
        PostPublish::dispatch($post->slug);

        return new PostResource($post->load(['media', 'categories']));
    }

    /**
     * Create media(s) for post
     * @param $post
     * @param $request
     * @return void
     */
    public function uploadMedia($post, $request)
    {
        $media = MediaService::privateUpload($request);
        $post->media()->create([
            'files' => $media->files,
            'type' => $media->type,
            'name' => $media->name,
            'isPrivate' => $media->isPrivate,
            'user_id' => $media->user_id
        ]);
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
