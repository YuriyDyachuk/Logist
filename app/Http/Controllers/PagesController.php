<?php

namespace App\Http\Controllers;

use Rinvex\Subscriptions\Models\Plan;


class PagesController extends Controller
{

    /**
     * Show the application's Home page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function homePage($locale = null)
	{
		if($locale){
			\App::setLocale($locale);
		}

		return view('landing.main');
	}

	public function homePageCarrier($locale = null)
	{
		if($locale){
			\App::setLocale($locale);
		}

		return view('landing.carrier');
	}

	/**
	 * @deprecated
	 *
	 * @return $this
	 */
    public function homePageOLD()
    {
        $subscriptions = Plan::with('features')->get();
        return view('landing-OLD')->with('subscriptions', $subscriptions);
    }

    public function privacy(){
        return view('pages.privacy_ua');
    }

    public function privacyApp(){
        return view('pages.privacy_app');
    }

    public function terms(){
        return view('pages.terms_ua');
    }

}
