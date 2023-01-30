<?php

namespace Module\User\Http\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Module\User\Http\Notifications\Channels\SmsChannel;
use Module\User\Http\Notifications\Messages\SmsMessage;

class CeremonyMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the voice representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SmsMessage
     */
    public function toSms($notifiable): SmsMessage
    {
        return (new SmsMessage())
            ->to($notifiable->name)
            ->from('idanieldrew')
            ->line($notifiable->phone);
    }
}
