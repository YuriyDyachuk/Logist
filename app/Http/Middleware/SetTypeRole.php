<?php

namespace App\Http\Middleware;

use Closure;

class SetTypeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

	    $user = \Auth::user();

        if (!$user) {
            return redirect('/home');
        }

		$role = $user->getRoleName();

        if(!$role) {
	        return redirect('/home');
        }

	    $request->request->add(['role' => $role]);

        return $next($request);
    }
}
