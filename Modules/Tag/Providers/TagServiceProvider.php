<?php

namespace Module\Tag\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Tag\Models\Tag;
use Module\Tag\Observers\TagObserver;

class TagServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Observers
        Tag::observe(TagObserver::class);
    }
}