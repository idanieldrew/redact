<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ValidationException extends Exception
{
    public function __construct(
        private array $datas
    )
    {
        parent::__construct();
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $this->getMessage(),
            'errors' => $this->datas,

        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
