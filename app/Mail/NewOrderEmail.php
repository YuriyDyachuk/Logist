<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $client;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $client, $order)
    {
        $this->user = $user;
        $this->client = $client;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new.order', [
            'title' => trans('all.invite'),
            'user' => $this->user,
            'client' => $this->client,
            'order' => $this->order
        ]);
    }
}
