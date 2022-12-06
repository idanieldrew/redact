<?php

namespace Module\Post\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Module\Post\Models\Post;
use Module\Post\Observers\PostObserver;
use Module\Post\Policies\PostPolicy;

class PostServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Post\Http\Controllers';

    protected $policies = [
        Post::class => PostPolicy::class
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
        Route::prefix('api/posts')
            ->middleware(['api', 'lang'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/post_route.php');

        // Routes
        Route::prefix('api')
            ->middleware(['api', 'lang'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/single_route_post.php');

        // View
        $this->loadViewsFrom(__DIR__ . "/../Resources/views/Post", "post");

        // Observer Post
        Post::observe(PostObserver::class);
    }
}
