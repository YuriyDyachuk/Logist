<?php

namespace App\Http\Middleware;

use Closure;

class UserIsLogistic
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
        if (!\Auth::user()->isLogistic()){
            return redirect('/orders');
        }

        return $next($request);
    }
}
