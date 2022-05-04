<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvitePartner extends Notification
{
    use Queueable;

    protected $user_invite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_invite)
    {
        $this->user_invite = $user_invite->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_invite'      => $this->user_invite,
        ];
    }
}
