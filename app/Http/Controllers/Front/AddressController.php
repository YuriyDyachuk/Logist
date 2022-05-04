<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\GoogleService;

use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
	/**
	 * Get addresses json array for front (testing)
	 *
	 * @param Request $request
	 * @param GoogleService $google_service
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request, GoogleService $google_service){

		$request->validate([
				'address' => 'required|min:3',
				'g_recaptcha_response' => 'recaptcha:'.config('captcha.google_recaptcha_secret_3'),
			],
			[
				'address.required'=> 'no result', // hidden msg for front
				'address.max'=> 'no result', // hidden msg for front
				'g_recaptcha_response.recaptcha'=> 'false', // hidden msg for front
			]);

		innlogger_google('front\AdressController '.$request->address);
		innlogger_google('front\AdressController '.$request->ip());

		$result = $google_service->autocomplete($request->address);

		$data = ['status' => true];

		if($result['status'] == 'ZERO_RESULTS'){
			$data = ['status' => false];
		} else {
			foreach ($result['predictions'] as $item){
				$data['address'][] = [
					'name' => $item['description'],
					'place_id' => $item['place_id'],
				];
			}
		}
		return response()->json($data);
	}
}
