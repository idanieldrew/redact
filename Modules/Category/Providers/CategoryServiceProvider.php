<?php

namespace Module\Category\Providers;

use App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Category\Models\Category;
use Module\Category\Observers\CategoryObserver;
use Module\Category\Policies\CategoryPolicy;

class CategoryServiceProvider extends ServiceProvider
{
    // namespace
    private $namespace = 'Module\Category\Http\Controllers';

    // Policy
    protected $policies = [
        Category::class => CategoryPolicy::class
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

        app('domain');
        // Routes
        Route::prefix("api/{lang?}/category")
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/category_route.php');

        // Observer Category
        Category::observe(CategoryObserver::class);
    }
}
