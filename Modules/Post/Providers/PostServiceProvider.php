<?php

namespace Module\Post\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Post\Models\Post;
use Module\Post\Observers\PostObserver;
use Module\Post\Policies\PostPolicy;

class PostServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Post\Http\Controllers';

    protected $policies = [
        Post::class => PostPolicy::class,
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
        $this->loadViewsFrom(__DIR__ . '/../Resources/views/Post', 'post');

        // Observer Post
        Post::observe(PostObserver::class);

        RateLimiter::for('store', function (Request $request) {
            return $request->user()->isVip()
                ? Limit::none()
                : Limit::perMinutes(30,1);
        });
    }
}
