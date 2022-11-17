<?php

namespace Module\User\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\User\Models\User;
use Module\User\Policies\UserPolicy;

class UserServiceProvider extends ServiceProvider
{
    private const SUPER = 'super';

    private string $namespace = 'Module\User\Http\Controllers';

    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // super user
        Gate::before(function ($user) {
            if ($user->role->name === static::SUPER) {
                return true;
            }
        });

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Routes
        /** v1 */
        Route::prefix('api/users')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/v1/user_route.php');
    }
}
