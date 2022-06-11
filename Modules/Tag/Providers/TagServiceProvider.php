<?php

namespace Module\Tag\Providers;

use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}