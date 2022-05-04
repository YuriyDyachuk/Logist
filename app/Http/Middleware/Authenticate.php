<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authenticate
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
        if(!Auth::guest())
        {
            $user = Auth::user();

            if($user->verify_email == 0 || $user->verify_phone == 0){
                auth()->logout();
                $request->session()->flash('msg-warning', trans('all.account_not_activated'));
                return redirect()->to('/login');
            }

            if ($user->is_banned) {
                $request->session()->flash('msg-warning', trans('all.your_account_was_banned'));
                auth()->logout();
            }

        }

        return $next($request);
    }
}
