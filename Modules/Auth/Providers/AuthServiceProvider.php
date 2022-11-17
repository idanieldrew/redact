<?php

namespace Module\Auth\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Auth\Observers\v1\AuthObserver;
use Module\User\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Auth\Http\Controllers';

    public function boot()
    {
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
        User::observe(AuthObserver::class);
    }
}
