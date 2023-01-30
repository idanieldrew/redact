<?php

namespace Module\Category\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CategoryPublishedPermission extends Mailable
{
    use Queueable, SerializesModels;

    protected $slug;

    /**
     * Create a new message instance.
     *
     * @param  string  $slug
     * @return void
     */
    public function __construct(string $slug)
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
        return $this->view('category::Mail/CategoryPublishedPermission')
            ->with(['slug' => $this->slug]);
    }
}
