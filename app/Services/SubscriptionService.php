<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\User;
use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;
use App\Models\Transport\Transport;

use App\Search\Transport\TransportSearch;
use App\Enums\TransportStatus;


use Swap;
use Auth;

class SubscriptionService {

	/**
	 * @param null $user
	 *
	 * @return mixed
	 */
	public static function getSubscription($user = null){
		if(!$user){
			$user = auth()->user();
		}

		return $user->company->subscription(self::getSlug($user));
	}

	/**
	 * @param $user
	 *
	 * @return string
	 */
	public static function getSlug($user) {
		return 'main-'.$user->company->id;
	}

	/**
	 * @param $featureSlug
	 * @param $active_subscription
	 *
	 * @return string
	 */
	private static function getFeatureSlug($featureSlug, $active_subscription){
		return 'tms_control_'.$featureSlug.'__'.$active_subscription->plan_id;
	}

	/**
	 * @param $expire_date
	 * @return int|null
	 */
	public static function daysLeft($expire_date){
		$date = Carbon::now();
		if(!is_null($expire_date))
			return $date->diffInDays($expire_date, false);
		else
			return null;
	}

	/**
	 * @param $featureSlug
	 * @param null $user
	 *
	 * @return bool
	 */
	public static function checkFeatureUsage($featureSlug, $user = null){
		if(!$user){
			$user = auth()->user();
		}

		$active_subscription = $user->company->subscription(self::getSlug($user));

		$featureSlugFull = self::getFeatureSlug($featureSlug, $active_subscription);

		$feature = PlanFeature::where('slug', $featureSlugFull)->first();

		if(!$feature){
			return false;
		}
		return $user->company->subscription(self::getSlug($user))->getFeatureUsage($featureSlugFull);
	}

	/**
	 * @param $user
	 */
	public static function checkDefaultSubscription($user){

		if(!is_object($user)){
			$user = User::find($user);
		}

		$active_subscription = $user->company->subscription(self::getSlug($user));

		if (!$active_subscription) {
			$subscriptions = Plan::with('features')->get();

			// TODO Remove Later
			if (count($subscriptions) == 0) {
				\Artisan::call('db:seed', ['--class' => 'SubscriptionsTableSeeder']);
			}

			self::addUpdateSubscription($user->id, 1);
		}
	}

	/**
	 * @param $user_id
	 * @param $plan_id
	 * @param int $count_transport
	 */
	public static function addUpdateSubscription($user_id, $plan_id, $count_transport = 10, $renew = null){
		$user = User::find($user_id);
		$plan = Plan::find($plan_id);

		if($plan === null){
			return;
		}

		$plan->load('features');

		$active_subscription = $user->company->subscription(self::getSlug($user));

		if (!$active_subscription) {
			$user->company->newSubscription(self::getSlug($user), $plan);
			$active_subscription = $user->company->subscription(self::getSlug($user));
		} else {
			$user->company->subscription(self::getSlug($user))->usage()->delete();
			$user->company->subscription(self::getSlug($user))->renew();
			$active_subscription->changePlan($plan);
		}

		foreach ($plan->features as $feature) {
			if (strpos($feature->slug, self::getFeatureSlug('transports', $active_subscription)) !== false) // TODO update
				$user->company->subscription(self::getSlug($user))->recordFeatureUsage($feature->slug, $count_transport);
			else
				$user->company->subscription(self::getSlug($user))->recordFeatureUsage($feature->slug, 1);
		}

		self::setCarsBySubscribePlan($active_subscription, $user);
	}

	public static function cancelSubscription($user_id){
		$user = User::find($user_id);
		$active_subscription = $user->company->subscription(self::getSlug($user));
		if ($active_subscription) {
			$user->company->subscription(self::getSlug($user))->cancel();
		}

		// set default
		self::addUpdateSubscription($user->id, 1);
	}
	/**
	 * @param $user_id
	 * @param $subscription_id
	 * @param $subscription_period
	 * @param $transport
	 */
	public static function addSubscription($user_id, $subscription_id, $subscription_period, $transport){


		$user = User::find($user_id);
		$active_subscription = $user->activeSubscription();

		$calculator = new SubscriptionCalculator($subscription_id, $subscription_period, $transport, SubscriptionsTypes::DEFAULT_CURRENCY, $user_id);
		$calculator->calculate();

		if($calculator->return_balance > 0){
			$user->balance_return += $calculator->return_balance;
			$user->save();
		}

		if($active_subscription->id == $subscription_id && $active_subscription->pivot->transports == $transport){
			//renewal of subscription
			$user->subscriptions()->updateExistingPivot($active_subscription->id, ['expire_at' => $calculator->datetime_expire]);
		} else {
			//disable active subscriptions
			$user->subscriptions()->updateExistingPivot($active_subscription->id, ['is_active' => 0]);

			//Connecting a new subscription
			$user->subscriptions()->attach($subscription_id, [
				'is_active'         => 1,
				'expire_at'         => $calculator->datetime_expire,
				'subscription_id'   => $subscription_id,
				'transports'        => $transport,
				'period'            => $subscription_period
			]);
		}
	}

	/**
	 * @param $subscription_id
	 * @param $period
	 * @param int $transports
	 * @param string $service_currency
	 * @param null $user_id
	 * @return int
	 */
	public static function getAmmount($subscription_id, $period, $transports = 1, $service_currency = 'UAH', $user_id = null){

		$calculator = new SubscriptionCalculator($subscription_id, $period, $transports, $service_currency, $user_id);
		$calculator->calculate();

		return $calculator->total;
	}


	/**
	 * @param $subscription_id
	 * @param $subscription_type
	 * @param $transport
	 * @param null $user_id
	 */
	public static function calculate($subscription_id, $subscription_type, $transport, $user_id = null) {

		$calculator = new SubscriptionCalculator(
				$subscription_id,
				$subscription_type,
				$transport,
				SubscriptionsTypes::DEFAULT_CURRENCY,
				$user_id
		);

		$calculator->calculate();

		return [
			'total'         => $calculator->total,
			'expire'        => $calculator->expire,
			'datetime_expire'=> $calculator->datetime_expire,
			'new_transport' => $calculator->new_transport,
			'return_balance'=> $calculator->return_balance,
			'save'          => $calculator->charged_return,
			'discount'      => $calculator->total_discount
		];
	}

	public static function setCarsBySubscribePlan($subsciption = null, $user = null){

		if($user === null){
			$user = auth()->user();
		}

		if($subsciption === null){
			$subsciption = $user->company->subscription(self::getSlug($user));
		}

		if($subsciption->plan_id == 1){
			return;
		}

		$count_transport = self::checkFeatureUsage('transports', $user);

		$filters['user'] = $user->company->id;
		$filters['type'] = 'auto';
		$filters['transport_relationships'] = 'status';

		$transports = TransportSearch::apply($filters)->get();

		if($transports->isEmpty()){
			return;
		}

		$status_on_flight = TransportStatus::FLIGHT;

		// when order finished some cars will set to Disabled
		$transports_on_flight = $transports->filter(function ($value, $key) use ($status_on_flight)  {
			return $value->status->name == $status_on_flight;
		});

		$amountCanWork = $count_transport - $transports_on_flight->count();

		$transports_others = $transports->filter(function ($value, $key) use ($status_on_flight)  {
			return $value->status->name != $status_on_flight;
		});

		$transport_array_updated = [];

		$amount = 1;
		foreach ($transports_others as $transport){

			if($amount <= $amountCanWork && $transport->active == 1){
				$amount++;
				continue;
			}

			$transport->update( [ 'active' => 0 ] );
			$transport_array_updated[] = $transport->id;
			$amount++;
		}

		return $transport_array_updated;
	}

	public static function checkAutoLimit($subsciption = null, $active = false){
		$user = auth()->user();

		if($subsciption === null){
			$subsciption = $user->company->subscription(self::getSlug($user));
		}

		if($subsciption->plan_id == 1){
			// if plan 1 - no limit
			return true;
		}

		$filters['user'] = auth()->user()->company->id;
		$filters['type'] = 'auto';
		$filters['transport_relationships'] = 'status';

		if($active)
			$filters['active'] = true;

		$transports = TransportSearch::apply($filters)->get();

		if($transports->isEmpty()){
			return true;
		}

		$can_usage_transport = self::checkFeatureUsage('transports');

		if($transports->count() >= $can_usage_transport){
			//cant activate transport
			return false;
		}

		return true;
	}

}