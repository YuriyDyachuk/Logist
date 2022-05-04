<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Testing;
use App\Models\RequestTest;
use App\Http\Controllers\Controller;

class RequestTestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Testing $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Testing $request)
    {
        try {
            RequestTest::create($request->only('from', 'type'));

            return redirect('/profile/register/logistic')->withInput([$request->type => $request->from, 'role' =>
                $request->get('role')]);
//            return response()->json(['status' => 'success', 'msg' => trans('landing.msg_send_test')]);
        } catch (\Exception $exc) {

            return back();
//            return response()->json(['status' => 'error'], 400);
        }
    }
}
