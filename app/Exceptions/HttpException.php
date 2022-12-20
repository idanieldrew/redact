<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class HttpException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
        ], Response::HTTP_FORBIDDEN);
    }
}