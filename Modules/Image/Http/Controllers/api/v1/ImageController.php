<?php

namespace Module\Image\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Module\Image\Http\Requests\v1\ImageRequest;
use Module\Image\Services\v1\ImageService;
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
     * @param  \Module\Image\Http\Requests\v1\ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $this->service()->store($request);

        return $this->res('success', Response::HTTP_CREATED, null, null);
    }

    public function res($status, $code, $message, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}