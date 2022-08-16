<?php

namespace Module\Category\Listeners;

use Illuminate\Support\Facades\Mail;
use Module\Category\Events\NewCategory;
use Module\Category\Mail\CategoryPublishedPermission;
use Module\User\Repository\v1\UserRepository;

class ReportCategoryPublishedAdmin
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'admin-category';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 90;

    /**
     * Handle the event.
     *
     * @param NewCategory $event
     * @return void
     */
    public function handle(NewCategory $event)
    {
        $mail = new CategoryPublishedPermission($event->getSlug());
        $repo = resolve(UserRepository::class);

        foreach ($repo->admins() as $admin) {
            Mail::to($admin->email)->send($mail);
        }
    }
}
