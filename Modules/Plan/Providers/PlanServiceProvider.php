<?php

namespace Module\Plan\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Plan\Models\Plan;

class PlanServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Premium\Http\Controllers';

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Routes
        Route::prefix('api/premium')
            ->middleware(['api', 'lang'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/premium_route.php');
    }
}
