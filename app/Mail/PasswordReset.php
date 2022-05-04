<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
		$this->token = $token;
		$this->link = url('/password/reset/'.$this->token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this
		    ->subject(trans('email.password_reset_title'))
		    ->view('emails.new.password_reset', [
			    'title' => trans('email.password_reset_title'),
			    'link' => $this->link,
		    ]);
    }
}
