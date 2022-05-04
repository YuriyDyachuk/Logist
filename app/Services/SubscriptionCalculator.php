<?php

namespace App\Services;

use App\Enums\SubscriptionsTypes;
use App\Models\Subscriptions\Subscription;
use Carbon\Carbon;
use App\Models\User;
use Swap;
use Auth;


class SubscriptionCalculator {


	private $id;                    // selected subscription id
	private $transports;            // selected number of transports
	private $period;                // selected period

	private $user;                  //current or given user
	private $subscription;          //selected subscription entity
	private $active_subscription;   //Current subscription of given user

	private $daysLeft;              //Days left, of current subscription (Only days, not months)
	private $monthsLeft;            //Months left of current subscription

	private $expire_current;        //datetime of expiring current (active) subscription
	private $transport_current;     //current number of transports

	private $currency = 'UAH';      //currency, that can be converted
	private $price;                 //price of selected subscription

	public $total = 0;             //result of calculating, total amount.
	public $expire = null;         //result of calculating, expiring date
	public $new_transport = 0;     //result of calculating, total new transports
	public $increment;             //result of calculating, increment of transports
	public $return_balance = 0;    //balance amount, that will be returned to user
	public $datetime_expire;       //result of calculating, Date of expiring in Carbon format
	public $return_total = 0;      //result of calculating, return total balance that was returned by user
	public $charged_return = 0;    //result of calculating, return how much returned balance will be used
	public $total_discount = 0;    //result of calculating, return total discount for 1 year and more payment



	/**
	 * SubscriptionCalculator constructor.
	 * @param $id
	 * @param $period
	 * @param $transports
	 * @param null $user_id
	 */
	public function __construct($id, $period, $transports, $currency = 'UAH', $user_id = null) {

		/* getting data from parameters */
		$this->id = $id;
		$this->transports = $transports;
		$this->period = $period;
		$this->currency = $currency;

		if(!is_null($user_id))
			$this->user = User::find($user_id);
		else
			$this->user = Auth::user();

		/*getting given subsription */
		$this->getSubscription($id);
	}

	/**
	 * @param $id
	 */
	public function getSubscription($id){

		$this->subscription = Subscription::find($id);
		$this->active_subscription  = $this->user->activeSubscription();
		$this->expire_current       = $this->active_subscription->pivot->expire_at;
		$this->transport_current    = $this->active_subscription->pivot->transports;
		$this->price                = $this->subscription->price;
		$this->return_total         = $this->user->balance_return;
	}

	public function calculate(){

		/* Setting default price */
		if($this->subscription->type == SubscriptionsTypes::FREE){
			$this->new_transport = 0;
			return true;
		}

		$this->total = $this->price * $this->period;

		$date               = Carbon::now();
		$this->monthsLeft   = $date->diffInMonths($this->expire_current, false);
		$last_month         = Carbon::now()->addMonths($this->monthsLeft);
		$this->daysLeft     = $last_month->diffInDays($this->expire_current, false);

		if($this->monthsLeft < 1 && $this->daysLeft < 0){
			//if subscription is expired, remove subscription, and add new
			$this->user
					->subscriptions()
					->updateExistingPivot(
							$this->active_subscription->id,
							['is_active' => 0]
					);

			$this->getSubscription($this->active_subscription->pivot->subscription_id);
		}


		if($this->active_subscription->pivot->subscription_id == $this->id){
			/*if user select current subscription */

			if($this->active_subscription->pivot->period >= 12){

				/* If user select more then 1 year */
				if($this->transports >= $this->transport_current) {
					// if user want to increment number transport or stay same

					$this->increment = $this->transports - $this->transport_current;

					if($this->increment > 0){
						// if number of transport is incremented
						$this->total            =   ($this->increment * $this->price * $this->monthsLeft) +
								(($this->price / 30) * $this->daysLeft * $this->increment);
						$this->expire           =   $this->expire_current;
						$this->new_transport    =   $this->increment;
					} else {
						// if number of transport is same
						$this->expire = Carbon::createFromTimeString($this->expire_current)->addMonths($this->period);
						$this->total *= $this->transports;
						$this->new_transport    = 0;
					}
				} else {
					// if user want to reduce number of transports > 1 Year
					$this->expire           = $this->expire_current;
					$this->total            = 0;
					$this->new_transport    = $this->transports;
					$decrement              = $this->transport_current - $this->transports;

					$this->return_balance   = ($decrement * $this->monthsLeft) + (($this->price / 30) * $this->daysLeft * $decrement);
				}
			} else {

				/* If user select less then 1 year */
				if($this->transports >= $this->transport_current) {
					// if user want to add number transport or stay same
					$this->expire           = Carbon::createFromTimeString($this->expire_current)->addMonths($this->period);
					$this->total            *= $this->transports;
					$this->new_transport    = $this->transports;
				} else {
					// if user want to reduce number of transports
					$this->expire                   = $this->expire_current;
					$this->total                    = 0;
					$this->new_transport            = $this->transports;
					$decrement                      = $this->transport_current - $this->transports;

					$this->return_balance           = $decrement  * (($this->price / 30) * $this->daysLeft);
				}
			}
		} else {

			$this->expire = Carbon::now()->addMonths($this->period);
			$this->total *= $this->transports;
			$this->new_transport    = 0;
		}

		if($this->period >= 12) {
			/* 1 Year discount */
			$this->total_discount   = $this->total * 0.1;
			$this->total            = $this->total - $this->total_discount;
		}

		/* If user select less number of transports, but select bigger subscription period  */

		if($this->return_balance > 0 && $this->total > 0){

			if($this->return_balance > $this->total){
				$this->return_balance -= $this->total;
				$this->total = 0;
			} else {
				$this->total -=  $this->return_balance;
				$this->return_balance = 0;
			}
		}


		if($this->return_total > 0 && $this->total > 0){

			if($this->return_total > $this->total){
				$this->return_total     -= $this->total;
				$this->charged_return   = $this->total;
				$this->total            = 0;
			} else {
				$this->total            -=  $this->return_total;
				$this->charged_return   = $this->return_total;
				$this->return_total     = 0;
			}

		}

		$this->round_data();
		$this->datetime_expire = $this->expire;
		$this->expire = Carbon::createFromTimeString($this->expire)->format('d.m.Y');
		$this->convert();

		return true;
	}

	public function round_data(){

		$this->return_balance       = round($this->return_balance,  2);
		$this->return_total         = round($this->return_total,    2);
		$this->total_discount       = round($this->total_discount,  2);
		$this->total                = round($this->total,           2);
	}


	// Converting total amount to Default currency, if it's already not in default currency
	public function convert(){

		if($this->currency != SubscriptionsTypes::DEFAULT_CURRENCY){

			$rate = Swap::latest(SubscriptionsTypes::DEFAULT_CURRENCY.'/'.$this->currency);
			$rate->getValue();
			$this->total = $this->total * $rate->getValue();
		}

	}
}