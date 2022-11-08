<?php

namespace Module\User\Providers;

use Illuminate\Http\Response;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\User\Models\User;
use Module\User\Observers\v1\UserObserver;
use Module\User\Policies\UserPolicy;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserServiceProvider extends ServiceProvider
{
    private const SUPER = 'super';

    private string $namespace = 'Module\User\Http\Controllers';

    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (InvalidSignatureException $e) {
            response()->json([
                'status' => 'error',
                'message' => "forbidden",
            ], ResponseAlias::HTTP_FORBIDDEN);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // super user
        Gate::before(function ($user) {
            if ($user->role->name === static::SUPER) {
                return true;
            }
        });

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Routes
        /** v1 */
        Route::prefix('api/users')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/user_route.php');

        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/auth_route.php');

        /** v2 */
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v2/auth_route.php');

        // Observer User
        User::observe(UserObserver::class);
    }
}
