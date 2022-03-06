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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::prefix('api/user')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group( __DIR__. '/../Routes/user_route.php');
    }
}