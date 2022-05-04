<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\SubscriptionService;

class isSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    if($user = auth()->user()) {
		    SubscriptionService::checkDefaultSubscription($user);
	    }

        return $next($request);
    }
}
