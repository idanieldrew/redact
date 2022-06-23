<?php

namespace Module\Panel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PanelServiceProvider extends ServiceProvider
{
    private $namespace = 'Module\Panel\Http\Controllers';

    public function boot()
    {
        // Routes
        Route::prefix('api/panel')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/panel_route.php');
    }
}