<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class JwtRefresh
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
        $token = JWTAuth::getToken();
//        dump($token);

        $user = JWTAuth::toUser($token);

//        dump($user->toArray);
        if($token){
//            JWTAuth::refresh($token);
        }

//
        return $next($request);
    }
}
