<?php

namespace Module\Post\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Module\Comment\Models\Comment;
use Module\Comment\Request\v1\CommentRequest;
use Module\Post\Models\Post;
use Module\Post\Services\v1\PostService;
use Module\Share\Contracts\Response\ResponseGenerator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentController extends Controller implements ResponseGenerator
{
    /**
     * Create comment for post
     *
     * @param Post $post
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function create_comment(Post $post, CommentRequest $request)
    {
        $service = (new PostService)->createComment($post, $request);

        return $this->res('success', ResponseAlias::HTTP_CREATED, "Successfully add comment for post", $service);
    }

    /**
     * Reply comment for post
     *
     * @param Post $post
     * @param Comment $comment
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function reply_comment(Post $post, Comment $comment, CommentRequest $request)
    {
        $service = (new PostService)->replyComment($post, $comment, $request);

        return $this->res('success', ResponseAlias::HTTP_CREATED, "Successfully add reply for comment", $service);
    }

    public function res($status, $code, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
