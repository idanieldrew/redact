<?php

namespace Module\Post\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Module\Post\Models\Post;

class ReplyAuthor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private array $post)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('post::Mail/ReportToAuthor')
            ->with([
                'slug' => $this->post['slug'],
                'name' => $this->post['name'],
                'reason' => $this->post['reason']
            ]);
    }
}
