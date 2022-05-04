<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var
	 */
	public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
	    $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->view('emails.new.payment_reminder', [
		    'title' => trans('pay.email_payment_reminder_title'),
		    'user' => $this->user,
	    ]);
    }
}
