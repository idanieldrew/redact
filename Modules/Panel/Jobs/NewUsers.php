<?php

namespace Module\Panel\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Module\Panel\Mail\NewUserMail;
use Module\User\Repository\v1\UserRepository;

class NewUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = now()->subDays()->endOfDay();
        $users = (new UserRepository())->newUsers($date);
        $admins = (new UserRepository())->admins();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NewUserMail($users));
        }
    }
}
