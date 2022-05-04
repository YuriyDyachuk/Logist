<?php

namespace App\Http\Controllers\Dic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\GeographerService;

class GeographerController extends Controller
{
	public function index(Request $request){
		$type = $request->type;

		$result = array();

		switch ($type) {
			case 'states':
				$result = $this->getStatesByCountry($request->code);
				break;
			case 'cities':
				$result = $this->getCitiesByState($request->code);
				break;
			case 2:
				echo "i равно 2";
				break;
		}

		return response()->json($result);
	}

	public function getStatesByCountry($code){
		return (new GeographerService())->getStates($code);
	}

	public function getCitiesByState($code){
		return (new GeographerService())->getCities($code);
	}
}
