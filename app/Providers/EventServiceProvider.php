<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Category\Events\NewCategory;
use Module\Category\Listeners\ReportCategoryPublishedAdmin;
use Module\Post\Events\PostPublish;
use Module\Post\Listeners\ReportPostPublishedAdmin;
use Module\Token\Listeners\SendMailVerification;
use Module\User\Events\Registered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*Registered::class => [
            SendEmailVerificationNotification::class,
        ],*/ // work in v1
        Registered::class => [
            SendMailVerification::class,
        ], // work in v2
        PostPublish::class => [
            ReportPostPublishedAdmin::class,
        ],
        NewCategory::class => [
            ReportCategoryPublishedAdmin::class,
        ]
    ];
}
