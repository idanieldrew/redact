<?php

namespace Module\Post\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Module\Category\Repository\v1\CategoryRepository;
use Module\Media\Services\v1\ImageService;
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
     * @param $request
     * @return PostResource
     */
    public function store($request): PostResource
    {
        if (Gate::denies('create', [Post::class])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // Create post
        $post = auth()->user()->posts()->create([
            'title' => $title = $request->title,
            'details' => $request->details,
            'description' => $request->description,
            'banner' => $this->uploadBanner($request->banner, $title)
        ]);

        // Upload media(s)
        if ($request->attachment) {
            foreach ($request->attachment as $attachment) {
                $this->uploadMedia($post, $attachment);
            }
        }

        // Create Tag(s)
        $tagService = resolve(TagService::class);
        $tags = $tagService->store($request->tag);
        // Sync post & tag(s)
        $post->tags()->sync($tags);

        // Sync post with category(s)
        $categoryRepository = resolve(CategoryRepository::class);
        $categories = $categoryRepository->getCategories($request->category);
        $post->categories()->syncWithPivotValues($categories, []);

        // Report to admins
        PostPublish::dispatch($post->slug);

        return new PostResource($post->load(['media', 'categories', 'tags']));
    }

    /**
     * Update post
     * @param $post
     * @param UserRequest; $request
     * @return null
     */
    public function update($post, $request)
    {
        // Just user can edit our information
        if (Gate::denies('update', [Post::class, $post])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $post->update($request->validated());
    }

    /**
     * Make media(s) for post
     * @param $post
     * @param $request
     * @param bool $private
     */
    protected function uploadMedia($post, $request, bool $private = true)
    {
        $media = $private ?
            MediaService::privateUpload($request) :
            MediaService::publicUpload($request);

        $post->media()->create([
            'files' => $media->files,
            'type' => $media->type,
            'name' => $media->name,
            'isPrivate' => $media->isPrivate,
            'user_id' => $media->user_id
        ]);
    }

    /**
     * Make banner for post
     * @param $request
     * @param $filename
     * @return mixed
     */
    protected function uploadBanner($request, $filename)
    {
        $imageService = resolve(ImageService::class);
        return $imageService::upload($request, $filename, 'public', false);
    }
}
