<?php

namespace Module\Post\Services\v1;

use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Module\Category\Repository\v1\CategoryRepository;
use Module\Comment\Http\Resources\v1\CommentResource;
use Module\Comment\Services\v1\CommentService;
use Module\Media\Jobs\ConvertVideoForDownloading;
use Module\Media\Jobs\ConvertVideoForStreaming;
use Module\Media\Models\Media;
use Module\Media\Repositories\v1\MediaRepository;
use Module\Media\Services\v1\ImageService;
use Module\Media\Services\v1\MediaService;
use Module\Post\Events\PostPublish;
use Module\Post\Events\SockdolagerPost;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Repository\v1\PostRepository;
use Module\Post\Services\PostService as Service;
use Module\Tag\Services\v1\TagService;

class PostService extends Service
{
    protected function repo()
    {
        return resolve(PostRepository::class);
    }

    /**
     * Create new post
     *
     * @param $request
     * @return PostResource
     *
     * @throws Exception
     */
    public function store($request): PostResource
    {
        DB::beginTransaction();

        try {
            // Store post
            $post = $this->repo()->store($request);

            // Upload media(s)
            if ($request->attachment) {
                foreach ($request->attachment as $attachment => $type) {
                    match ($attachment) {
                        'video' => $this->uploadMedia($post, $type, true, true),
                        'image' => $this->uploadMedia($post, $type),
                        default => 'unknown'
                    };
                }
            }

            // Sync tag(s)
            $this->syncTag($post, $request->tag);

            // Sync post with category(s)
            $this->syncCategory($post, $request->category);

            // Report to admins
            PostPublish::dispatch($post->slug);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return new PostResource($post->load(['media', 'categories', 'tags']));
    }

    /**
     * Update post
     *
     * @param $post
     * @param $request
     * @return null
     */
    public function update($post, $request)
    {
        return $post->update($request->validated());
    }

    /**
     * Make media(s) for post
     *
     * @param Post $post
     * @param $request
     * @param bool $private
     * @param bool $video
     * @throws \Throwable
     */
    protected function uploadMedia(Post $post, $request, bool $private = true, bool $video = false)
    {
        foreach ($request as $value) {
            $media = $private ?
                MediaService::privateUpload($value) :
                MediaService::publicUpload($value);
            $media = $this->storeMedia($post, $media);

            if ($video) {
                Bus::batch([
                    new ConvertVideoForDownloading($media),
                    new ConvertVideoForStreaming($media)
                ])->catch(function (Batch $batch, \Throwable $throwable) {
                    Log::error("this $batch has $throwable");
                })->name('video_operation')->dispatch();
            }
        }
    }

    /**
     * Make banner for post
     *
     * @param $request
     * @param $filename
     * @return mixed
     */
    public function uploadBanner($request, $filename)
    {
        $imageService = resolve(ImageService::class);

        return $imageService::upload($request, $filename, 'public', false);
    }

    /**
     * Create tag if not exist & sync with post
     *
     * @param $post
     * @param $tag
     * @return void
     */
    protected function syncTag($post, $tag)
    {
        $tagService = resolve(TagService::class);
        $tags = $tagService->store($tag);
        // Sync post & tag(s)
        $post->tags()->sync($tags);
    }

    /**
     * Sync post with category(s)
     *
     * @param $post
     * @param $category
     * @return void
     */
    protected function syncCategory($post, $category)
    {
        $categoryRepository = resolve(CategoryRepository::class);
        $categories = $categoryRepository->getCategories($category);
        $post->categories()->syncWithPivotValues($categories, []);
    }

    /**
     * Generate unique link
     *
     * @return string
     */
    public function generateLink()
    {
        $link = Str::random(5);

        if ((new PostRepository)->checkUniqueShortLink($link)) {
            $this->generateLink();
        }

        return $link;
    }

    /**
     * Create comment
     *
     * @param $post
     * @param $request
     * @return \Module\Comment\Http\Resources\v1\CommentResource
     */
    public function createComment($post, $request): CommentResource
    {
        $commentService = resolve(CommentService::class);
        $comment = $commentService->store($post, $request->body);

        return new CommentResource($comment);
    }

    /**
     * Reply comment
     *
     * @param $post
     * @param $comment
     * @param $request
     * @return CommentResource
     */
    public function replyComment($post, $comment, $request): CommentResource
    {
        $commentService = resolve(CommentService::class);
        $comment = $commentService->reply($post, $comment, $request->body);

        return new CommentResource($comment);
    }

    /**
     * admin update status
     *
     * @param Post $post
     * @param $request
     */
    public function update_license(Post $post, $request)
    {
        SockdolagerPost::dispatch($post);

        $post->statuses()->update([
            'name' => $request->name,
            'reason' => $request->reason,
        ]);
    }

    /**
     * Store media for post
     *
     * @param Post $post
     * @param Media $media
     * @return mixed
     */
    private function storeMedia(Post $post, Media $media)
    {
        return (new MediaRepository)->store($post, $media);
    }

    private function handleVideoWorks($media)
    {
        dd(777);
        ConvertVideoForDownloading::dispatch($media);
        ConvertVideoForStreaming::dispatch($media);
    }
}
