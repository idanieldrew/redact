<?php

namespace Module\Post\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostPublishedPermission extends Mailable
{
    use Queueable, SerializesModels;

    protected $slug;
    /**
     * Create a new message instance.
     *
     * @param string $slug
     * @return void
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('post::Mail/PostPublishedPermission')
            ->with(['slug' => $this->slug]);
    }
}
