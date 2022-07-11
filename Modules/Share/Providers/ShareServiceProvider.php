<?php

namespace Module\Share\Providers;

use Carbon\Laravel\ServiceProvider;

class ShareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
