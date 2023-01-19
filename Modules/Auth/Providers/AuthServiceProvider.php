<?php

namespace Module\Auth\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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

        $this->loadViewsFrom(__DIR__ . "/../Resources/views/Auth", "auth");
    }
}
