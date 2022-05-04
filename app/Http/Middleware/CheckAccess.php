<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {

        $module = explode('.', $module);
        $result = count($module) > 1 ? user_current_can($module[0], $module[1]) : user_current_can($module[0], false);

        if (! $result) {
            return redirect()->route('homepage');
        }

        return $next($request);
    }
}
