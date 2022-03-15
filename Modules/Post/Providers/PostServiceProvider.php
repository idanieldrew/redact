<?php

namespace Module\Post\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Module\Post\Models\Post;
use Module\Post\Observers\PostObserver;

class PostServiceProvider extends ServiceProvider
{

    private $namespace = 'Module\Post\Http\Controllers';

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
        Route::prefix('api/post')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/post_route.php');

        // View
        $this->loadViewsFrom(__DIR__ . "/../Resources/views/Post","post");

        // Observer Post
        Post::observe(PostObserver::class);
    }
}