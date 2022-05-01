<?php

namespace Module\Image\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Module\Image\Services\v1\ImageService;
use Module\Image\Http\Requests\v1\ImageRequest;
use Module\Share\Contracts\Response\ResponseGenerator;

class ImageController extends Controller implements ResponseGenerator
{
    // resolve \Module\Image\Services\ImageService
    public function service()
    {
        return resolve(ImageService::class);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Module\Image\Http\Requests\v1\ImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $post = $this->service()->store($request);

        return $this->res('success',Response::HTTP_CREATED,null,new PostResource($post));
    }

    public function res($success, $status, $message, $data)
    {
        // TODO: Implement res() method.
    }
}