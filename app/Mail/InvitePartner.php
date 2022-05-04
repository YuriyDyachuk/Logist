<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitePartner extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $client;
    public $password;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $client, $password, $token)
    {
        $this->user = $user;
        $this->client = $client;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new.invite_partner',
            [
                'title' => trans('all.invite'),
                'client' => $this->client,
                'user' => $this->user,
                'password' => $this->password,
                'token' => $this->token,
            ]
        );
    }
}
