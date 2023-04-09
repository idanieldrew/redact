<?php

namespace Module\Post\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
        return $this->repo()->paginate();
    }

    /**
     * Display the specified resource.
     *
     * @param string $post
     * @return JsonResponse
     */
    public function show(string $post): JsonResponse
    {
        $res = $this->repo()->show($post);

        return $this->res('success', Response::HTTP_OK, "this $post post", $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return JsonResponse
     * @throws AuthorizationException|\Throwable
     */
    public function store(PostRequest $request): JsonResponse
    {
        // Check permissions
        $this->authorize('create', Post::class);

        $post = $this->service()->store($request);

        return $this->res('success', ResponseAlias::HTTP_CREATED, null, new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Post $post
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Post $post)
    {
        // Check permissions
        $this->authorize('update', [Post::class, $post]);

        $this->service()->update($post, $request);

        return $this->res('success', Response::HTTP_NO_CONTENT, null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Post $post)
    {
        // Check permissions
        $this->authorize('delete', [Post::class, $post]);

        $this->repo()->destroy($post);

        return $this->res('success', Response::HTTP_OK, 'Successfully delete post');
    }

    /**
     * Search with elasticsearch or pipeline
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $response = $this->repo()->search($request->keyword);

        return $this->res('success', Response::HTTP_OK, null, new PostCollection($response));
    }

    /**
     * Add short link
     *
     * @param $link
     * @return RedirectResponse
     */
    public function short_link($link)
    {
        $post = $this->repo()->checkUniqueShortLink($link);

        return redirect()->route('post.show', $post->slug);
    }

    /**
     * @return void
     * @throws AuthorizationException
     */
    public function updateLicense(Post $post, Request $request)
    {
        $this->authorize('update_license', [Post::class, $post]);

        $this->service()->update_license($post, $request);

        return $this->res('success', Response::HTTP_OK, null, new PostResource($post));
    }

    public function res($status, $code, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /* Logic for upload file with tus,coming soon complete it
    public function uploadWithTus(Request $request)
    {
        $client = Storage::disk('minio');
        $client->getClient()->registerStreamWrapper();

        $bucket = config('filesystems.disks.minio.bucket');
        $basePath = "/projectz/hhh";
        $fullPath = "minio://$bucket/$basePath";

        $server = new Server('file');
        $server->setApiPath($request->getRequestUri())->setUploadDir($fullPath);
        $server->event()->addListener('tus-server.upload.complete', listener: function (TusEvent $event) use ($basePath, $fullPath) {
            $filemeta = $event->getFile()->details();
            $basePath = $basePath . DIRECTORY_SEPARATOR;
            $originalName = $filemeta['metadata']['filename'];
            $newFilename = Str::uuid() . pathinfo($originalName, PATHINFO_EXTENSION);
            $client->move("{$basePath}{$originalName}", "{$basePath}{$newFilename}");
        });

        $server->serve();
    }*/
}
