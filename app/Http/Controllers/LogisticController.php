<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalFreight\LardiTransService;

class LogisticController extends Controller
{
    /**
     * @param $transportId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($name)
    {

//        $result = LogisticService::getList($name);
//
//        return response()->json($result);
	    return response()->json();

    }

    public function store(Request $request)
    {
        $data = $request->all();

        return response()->json($data);

    }

}
