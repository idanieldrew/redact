<?php

namespace Module\Status\Providers;

use Illuminate\Support\ServiceProvider;

class StatusServiceProvider extends ServiceProvider
{
    private string $namespace = 'Module\Status';

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
