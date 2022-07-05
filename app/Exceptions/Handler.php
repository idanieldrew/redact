<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            Log::error($e);
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Not Found',
            ], Response::HTTP_NOT_FOUND, $e->getHeaders());
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], Response::HTTP_METHOD_NOT_ALLOWED, $e->getHeaders());
        }
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], Response::HTTP_TOO_MANY_REQUESTS, $e->getHeaders());
        }
        if ($e instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            return response()->json([
                'status' => 'error',
                'message' => $this->isDebugMode() ? $e->getMessage() : 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            return response()->json([
                'status' => 'error',
                'message' => $this->isDebugMode() ? "forbidden" : 'forbidden',
            ], Response::HTTP_FORBIDDEN);
        }
//        dd($e);

        return parent::render($request, $e);
    }

    protected function isDebugMode()
    {
        return config('app.debug');
    }
}
