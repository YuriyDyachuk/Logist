<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserDataService;

class CheckTutorials
{

	private $tutorials = [

//		'register-fill-client',
//		'register-fill-logistic',

		'profile-fill',
		'transport-section-link',

		'transport-new',
		'transport-new-added',
		'order-section-link',

		'order-link-new',
		'order-new',
		'order-created',

		'order-show',
		'order-show-activated',

		'staff-link-add',
	];

	private $tutorialsClient = [
		'profile-fill',
		'order-section-link',
		'order-link-new',
		'order-new',
	];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$user = auth()->user();

		if($user && $user->tutorial !==1 ){
			$tutorial = $user->isClient() ? $this->tutorialsClient : $this->tutorials;
			$check = true;

			$userDataService = new UserDataService();

			foreach($tutorial as $page){

				$page_title = 'tutorials_'.$page;
				$cookie = \Cookie::get($page_title);
				$userData = $userDataService->get($user->id, $page_title);
				if($cookie === null || $userData === false){
					$check = false;
				}
		    }

		    if($check){
			    $user->update(['tutorial' => 1]);
		    }
	    }

        return $next($request);
    }
}
