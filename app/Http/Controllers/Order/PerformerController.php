<?php

namespace App\Http\Controllers\Order;


use App\Models\Order\OrderPerformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerformerController extends Controller
{
    /**
     * @param Request $request
     * @param integer $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAdditionalLoading(Request $request, $order)
    {
        $performer = OrderPerformer::query()
            ->where('order_id', $order)
            ->where('user_id', \Auth::id())
            ->first();

        if ($performer) {
            $performer->additional_loading = $request->get('additional_loading');
            $performer->save();

            return response()->json(['status' => 'OK']);
        }

        return response()->json(['status' => 'ERROR', 'msg' => 'The performer not found.']);
    }
}
