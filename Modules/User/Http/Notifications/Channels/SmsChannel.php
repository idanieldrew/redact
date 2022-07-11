<?php

namespace Module\User\Http\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification;  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        $message->send();
        // Send notification to the $notifiable instance...
    }
}
