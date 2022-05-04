<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetAuthProviders
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
	    Auth::shouldUse('api');

//        if (config('auth.providers.users.model') != 'App\Models\Transport\Transport') {
//            config(['auth.providers.users.model' => 'App\Models\Transport\Transport']);
//        }

        return $next($request);
    }
}
