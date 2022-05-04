<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminSystemMsg extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $title = null)
    {
        $this->msg = $msg;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this
		    ->subject('Системная ошибка')
		    ->view('emails.admin-system-msg', [
			    'title' => 'Системная ошибка'. ($this->title ? ' - '.$this->title : ''),
			    'msg' => $this->msg,

		    ]);
    }
}
