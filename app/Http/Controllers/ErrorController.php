<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
	/**
	 * Page Error 404
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function notfound(){
		if(auth()->user()){
			return response()->view('errors.404back', [], 404);
		}
		else {
			return response()->view('errors.404front', [], 404);
		}

	}
}
