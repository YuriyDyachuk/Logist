<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DriverStatus extends Notification
{
    use Queueable;

    protected $user;
    protected $status;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $status, $order)
    {
        $this->user = $user->id;
        $this->status = $status;
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
            'user'      => $this->user,
            'status'    => $this->status,
            'order_id'  => $this->order->id,
        ];
    }
}
