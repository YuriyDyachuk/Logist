<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminLandingFeedback extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $title;
    private $email;
    private $msg;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $title
     * @param $email
     * @param $msg
     */
    public function __construct($name, $title, $email, $msg)
    {
        $this->name = $name;
        $this->title = $title;
        $this->email = $email;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this
		    ->subject($this->title)
		    ->view('emails.admin-landing-feedback', [
                'name'  => $this->name,
                'title' => $this->title,
                'email' => $this->email,
                'msg'   => $this->msg,
		    ]);
    }
}
