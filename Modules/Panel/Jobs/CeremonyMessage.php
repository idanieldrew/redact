<?php

namespace Module\Panel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Module\Panel\Mail\CeremonyMail;
use Module\User\Repository\v1\UserRepository;

class CeremonyMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = (new UserRepository)->simpleUsers();

        $mail = new CeremonyMail($this->content);

        foreach ($users as $user) {
            Mail::to($user->email)->send($mail);
        }

        Log::info('send mails');
    }
}
