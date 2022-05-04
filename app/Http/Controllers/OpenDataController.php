<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\OpenData\OpendatabotService;

class OpenDataController extends Controller
{
	public function getOpendatabotInfo(Request $request, OpendatabotService $opendatabot_service){
		$result = $opendatabot_service->sentRequest($request);
		return response()->json($result);
	}
}
