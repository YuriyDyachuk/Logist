<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteClient extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $client;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $client, $token)
    {
        $this->user = $user;
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new.invite_client',
            [
                'title' => trans('all.invite'),
                'client' => $this->client,
                'user' => $this->user,
                'token' => $this->token
            ]
        );
    }
}
