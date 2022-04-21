<?php

namespace Module\Post\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Module\Post\Http\Requests\PostRequest;
use Module\Post\Http\Resources\v1\PostCollection;
use Module\Post\Http\Resources\v1\PostResource;
use Module\Post\Models\Post;
use Illuminate\Http\Request;
use Module\Post\Repository\v1\PostRepository;
use Module\Post\Services\v1\PostService;

class PostController extends Controller
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
     * @return \Module\Post\Http\Resources\v1\PostCollection
     */
    public function index()
    {
        $posts = $this->repo()->paginate(15);

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Module\Post\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = $this->service()->store($request);

        return $this->res('success',null,$post,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Post\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $this->repo()->show($post);

        return $this->res('success',null,new PostResource($post),Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function res($status,$message,$data,$code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$code);
    }
}
