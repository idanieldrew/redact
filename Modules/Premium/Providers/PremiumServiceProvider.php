<?php

namespace Module\Premium\Providers;

use Illuminate\Support\ServiceProvider;

class PremiumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
