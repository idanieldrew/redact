<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class MethodNotAllowedHttpException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $this->getMessage(),
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
