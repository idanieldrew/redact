<?php

namespace Module\Post\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Module\Post\Events\SockdolagerPost;
use Module\Post\Mail\ReplyAuthor;

class ReplyAuthorPost implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param SockdolagerPost $event
     * @return void
     */
    public function handle(SockdolagerPost $event)
    {
        $post = $event->getPosts();

        $mail = new ReplyAuthor([
            'slug' => $post->slug,
            'name' => $post->statuses->name,
            'reason' => $post->statuses->reason
        ]);

        Mail::to($post->user->email)->send($mail);
    }
}
