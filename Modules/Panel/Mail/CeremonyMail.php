<?php

namespace Module\Panel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CeremonyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('panel::Mail.CeremonyMessage')
            ->with(['content' => $this->content]);
    }
}
