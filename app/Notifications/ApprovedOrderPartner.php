<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedOrderPartner extends Notification
{
    use Queueable;

    protected $user_partner;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_partner, $order)
    {
        $this->user_partner = $user_partner->id;
        $this->order = $order;
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
            'user_partner'      => $this->user_partner,
        ];
    }
}
