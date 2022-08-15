<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Category\Events\NewCategory;
use Module\Category\Listeners\ReportCategoryPublishedAdmin;
use Module\Post\Events\PostPublish;
use Module\Post\Listeners\ReportPostPublishedAdmin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostPublish::class => [
            ReportPostPublishedAdmin::class,
        ],
        NewCategory::class => [
            ReportCategoryPublishedAdmin::class,
        ]
    ];
}
