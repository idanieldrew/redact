<?php

namespace Module\Premium\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Premium\Models\Premium;
use Module\Premium\Observer\PremiumObserver;

class PremiumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // observer
        Premium::observe(PremiumObserver::class);
    }
}
