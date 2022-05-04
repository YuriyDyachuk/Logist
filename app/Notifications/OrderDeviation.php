<?php

namespace App\Notifications;

use App\Models\Order\Order;
use Illuminate\Notifications\Notification;

class OrderDeviation extends Notification
{
    protected $order;

    /**
     * OrderDeviation constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id'  => $this->order->id,
            'type'      => $this->order->type,
        ];
    }
}