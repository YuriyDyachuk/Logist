<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationLink extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token, $title = null)
    {
        $this->user = $user;
        $this->token = $token;
        $this->title = $title ? $title : trans('all.activate');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new.activate', ['title' => $this->title, 'user' => $this->user, 'token' => $this->token]);
    }
}
