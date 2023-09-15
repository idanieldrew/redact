<?php

namespace Module\Post\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Module\Comment\Models\Comment;
use Module\Comment\Request\v1\CommentRequest;
use Module\Post\Models\Post;
use Module\Post\Repository\v1\PostRepository;
use Module\Post\Services\v1\PostService;
use Module\Share\Contracts\Response\ResponseGenerator;

class CommentController extends Controller implements ResponseGenerator
{
    /**
     * All comments for $post
     *
     * @param  Post  $post
     * @return JsonResponse
     */
    public function index(Post $post)
    {
        $comments = (new PostRepository)->comments($post);

        return $this->res('success', Response::HTTP_OK, "All comment for $post->slug", $comments);
    }

    /**
     * Create comment for post
     *
     * @param  Post  $post
     * @param  CommentRequest  $request
     * @return JsonResponse
     */
    public function store(Post $post, CommentRequest $request)
    {
        $service = (new PostService)->createComment($post, $request);

        return $this->res('success', Response::HTTP_CREATED, 'Successfully add comment for post', $service);
    }

    /**
     * Reply comment for post
     *
     * @param  Post  $post
     * @param  Comment  $comment
     * @param  CommentRequest  $request
     * @return JsonResponse
     */
    public function reply(Post $post, Comment $comment, CommentRequest $request)
    {
        $service = (new PostService)->replyComment($post, $comment, $request);

        return $this->res('success', Response::HTTP_CREATED, 'Successfully add reply for comment', $service);
    }

    public function res(string $status, int $code, string|null $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
