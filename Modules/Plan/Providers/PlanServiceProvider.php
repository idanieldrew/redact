<?php

namespace Module\Plan\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Module\Plan\Models\Plan;
use Module\Plan\Observers\PlanObserver;
use Module\Plan\Policies\PlanPolicy;

class PlanServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Plan\Http\Controllers';

    protected $policies = [
        Plan::class => PlanPolicy::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // Routes
        Route::prefix('api/plans')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/plan_route.php');

        Plan::observe(PlanObserver::class);
    }
}
