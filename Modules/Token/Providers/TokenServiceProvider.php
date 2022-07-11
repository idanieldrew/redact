<?php

namespace Module\Token\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Module\User\Models\User;
use Module\User\Policies\UserPolicy;

class TokenServiceProvider extends ServiceProvider
{
    private $namespace = 'Module\Token\Http\Controllers';

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
        Route::prefix('api/token')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/token_route.php');
    }
}
