<?php

namespace Module\Post\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Module\Post\Http\Requests\v1\PostRequest;
use Module\Post\Http\Requests\v1\UpdateRequest;
use Module\Post\Http\Resources\v1\PostCollection;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Module\Post\Repository\v1\PostRepository;
use Module\Post\Services\v1\PostService;
use Module\Share\Contracts\Response\ResponseGenerator;

class PostController extends Controller implements ResponseGenerator
{
    // resolve \Module\Post\Repository\v1\PostRepository
    public function repo()
    {
        return resolve(PostRepository::class);
    }

    // resolve \Module\Post\Services\PostService
    public function service()
    {
        return resolve(PostService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(): PostCollection
    {
        return $this->repo()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Module\Post\Http\Requests\v1\PostRequest $request
     * @return Response
     */
    public function store(PostRequest $request)
    {
        $post = $this->service()->store($request);

        return $this->res('success', Response::HTTP_CREATED, null, new PostResource($post));
    }

    /**
     * Display the specified resource.
     *
     * @param string $post
     * @return JsonResponse
     */
    public function show(string $post): JsonResponse
    {
        $post = $this->repo()->show($post);

        return $this->res('success', Response::HTTP_OK, null, $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Module\Post\Http\Requests\v1\UpdateRequest $request
     * @param Post $post
     * @return Response
     */
    public function update(UpdateRequest $request, Post $post)
    {
        $this->service()->update($post, $request);

        return $this->res('success', Response::HTTP_NO_CONTENT, null, null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        $this->repo()->destroy($post);

        return $this->res('success', Response::HTTP_OK, 'Successfully delete post', null);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $response = $this->repo()->search($request->keyword);

        return $this->res('success', Response::HTTP_OK, null, new PostCollection($response));
    }

    public function storeImages(Request $request, Filesystem $filesystem)
    {
        $this->service()->storeImages($request, $filesystem);

        return $this->res('success', Response::HTTP_OK, 'Successfully store images', null);
    }

    // manage response
    public function res($status, $code, $message, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
