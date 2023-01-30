<?php

namespace Module\Token\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/../Resources/View', 'verify');

        // Routes
        Route::prefix('api/token')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/v1/token_route.php');
    }
}
