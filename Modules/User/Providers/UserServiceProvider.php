<?php

namespace Module\User\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Module\User\Models\User;
use Module\User\Policies\UserPolicy;

class UserServiceProvider extends ServiceProvider
{

    private $namespace = 'Module\User\Http\Controllers';

    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Routes

        /* v1 */
        Route::prefix('api/user')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/user_route.php');

        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/auth_route.php');

        /* v2 */
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v2/auth_route.php');
    }
}