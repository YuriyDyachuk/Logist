<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Auth;
use Carbon\Carbon;
//use Unicodeveloper\Identify\Facades\IdentityFacade as Identify;

class LanguageSwitcher
{
    /**
     * This function checks if language to set is an allowed lang of config.
     *
     * @param string $locale
     **/
    private function setLocale($locale)
    {
        // Check if is allowed and set default locale if not
        if (!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        // Set app language
        App::setLocale($locale);

        // Set carbon language
        if (config('language.carbon')) {
            // Carbon uses only language code
            if (config('language.mode.code') == 'long') {
                $locale = explode('-', $locale)[0];
            }

            Carbon::setLocale($locale);
        }

        // Set date language
        if (config('language.date')) {
            // Date uses only language code
            if (config('language.mode.code') == 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Date::setLocale($locale);
        }
    }

    public function setDefaultLocale()
    {
        if (config('language.auto')) {
            $this->setLocale(\Identify::lang()->getLanguage());
        } else {
            $this->setLocale(config('app.locale'));
        }
    }

    public function setUserLocale()
    {
        $user = Auth::user();

        if ($user->locale) {
            $this->setLocale($user->locale);
        } else {
            $this->setDefaultLocale();
        }
    }

    public function setSystemLocale($request)
    {
        if ($request->session()->has('locale')) {
            $this->setLocale(session('locale'));
        } else {
            $this->setDefaultLocale();
        }
    }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            $this->setUserLocale();
        } else {
            $this->setSystemLocale($request);
        }

        $locale = Session::has('locale') ? session('locale') : Config::get('app.locale');
        App::setLocale($locale);


        return $next($request);
    }
}
