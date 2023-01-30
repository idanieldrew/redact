<?php

namespace Module\Token\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class MailVerify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private        $id,
        private string $mail,
        private string $name,
    ) {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute('verify.v2',
            now()->addMinutes(15),
            ['user' => $this->id]
        );

        return $this->view('verify::Mail/verify')
            ->with('mail', $this->mail)
            ->with('name', $this->name)
            ->with('url', $url);
    }
}
