<?php

namespace Module\Media\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;

class MediaServiceProvider extends ServiceProvider
{

    private $namespace = 'Module\Media\Http\Controllers';

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
        Route::prefix('api/image')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/media_route.php');
    }
}
