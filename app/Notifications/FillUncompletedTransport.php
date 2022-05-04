<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\Transport\Transport;

class FillUncompletedTransport extends Notification
{
    use Queueable;

	protected $transport_id;
	protected $transport_number;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transportId)
    {
	    $this->transport_id = $transportId;

	    $transport = Transport::find($transportId);

	    $this->transport_number = $transport->number;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
		    'transport_id'   => $this->transport_id,
		    'number'      => $this->transport_number
	    ];
    }
}
