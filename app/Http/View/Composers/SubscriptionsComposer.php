<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;

use Rinvex\Subscriptions\Models\Plan;

class SubscriptionsComposer {
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		// TODO CACHE
		$subscriptions = Plan::with('features')->get();
		$as_id=0;
		$view->with('subscriptions', $subscriptions)->with('as_id', $as_id);
	}
}