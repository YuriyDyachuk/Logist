<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $features)
    {
	    $user = auth()->user();

	    if($features == 'order_creating' && $user->isClient())
		    return $next($request);

	    if(!checkPaymentAccess($features))
	    	return redirect()->route('orders');

        return $next($request);
    }
}
