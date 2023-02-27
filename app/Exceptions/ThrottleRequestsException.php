<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ThrottleRequestsException extends Exception
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
            'message' => 'Try to later',
        ], Response::HTTP_TOO_MANY_REQUESTS);
    }
}
