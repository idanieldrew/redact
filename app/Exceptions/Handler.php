<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException as NotFound;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

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
        if ($e instanceof AuthorizationException) {
            throw new \App\Exceptions\AuthorizationException();
        }
        if ($e instanceof NotFoundHttpException) {
            throw new \App\Exceptions\NotFoundHttpException();
        }
        if ($e instanceof NotFound) {
            throw new ModelNotFoundException();
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            throw new \App\Exceptions\MethodNotAllowedHttpException();
        }
        if ($e instanceof ValidationException) {
            throw new \App\Exceptions\ValidationException($e->errors());
        }
        if ($e instanceof AuthenticationException) {
            throw new \App\Exceptions\AuthenticationException();
        }
        if ($e instanceof ThrottleRequestsException) {
            throw new \App\Exceptions\ThrottleRequestsException();
        }
        if ($e instanceof RouteNotFoundException) {
            throw new \App\Exceptions\RouteNotFoundException();
        }
        if ($e instanceof HttpException) {
            throw new \App\Exceptions\HttpException();
        }
//        dd($e);

        return parent::render($request, $e);
    }

    protected function isDebugMode()
    {
        return config('app.debug');
    }
}
