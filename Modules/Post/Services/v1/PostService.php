<?php

namespace Module\Post\Services\v1;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Module\Category\Repository\v1\CategoryRepository;
use Module\Comment\Http\Resources\v1\CommentResource;
use Module\Comment\Services\v1\CommentService;
use Module\Media\Services\v1\ImageService;
use Module\Media\Services\v1\MediaService;
use Module\Post\Events\PostPublish;
use Module\Post\Events\SockdolagerPost;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Repository\v1\PostRepository;
use Module\Post\Services\PostService as Service;
use Module\Tag\Services\v1\TagService;
use Throwable;

class PostService extends Service
{
    /**
     * Create new post
     * @param $request
     * @return PostResource
     * @throws Exception
     */
    public function store($request): PostResource
    {
        DB::beginTransaction();

        try {
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
    public function createComment($post, $request): \Module\Comment\Http\Resources\v1\CommentResource
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
    public function replyComment($post, $comment, $request): \Module\Comment\Http\Resources\v1\CommentResource
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
            'reason' => $request->reason
        ]);
    }
}
