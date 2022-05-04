<?php

namespace App\Services\Cron;

use Illuminate\Support\Facades\Mail;
use App\Models\PlanSubscription;
use App\Mail\PaymentReminder as PaymentReminderMail;

class PaymentReminder {

	/**
	 * @var
	 */
	private $payment_remind;

	public function __construct() {
		$this->payment_remind = config('innlogist.payment_remind');

		$this->handle();
	}

	public function handle(){

		$users = PlanSubscription::findEndingPeriod($this->payment_remind)->with('user')->get();

		if($users->isNotEmpty()){
			foreach ($users as $user){
				Mail::to($user->user->email)->send(new PaymentReminderMail($user->user));
			}
		}
	}
}