<?php

namespace App\Http\Controllers\Api;

use App\Models\Order\Order;
use App\Models\User;
use App\Notifications\DriverStatus;
use App\Notifications\DriverStatusComplete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $user_driver = \Auth::user();

//        $user = User::query()->find($user_driver->user_id);

        $status = isset($request->status) ? $request->status : '';

        $order = Order::find($request->order_id);
        $logist = User::findOrFail($order->user_id);

        $complete = isset($request->complete) ? $request->complete : 0;

        if ($complete && $logist->isLogist()) {
            Notification::send($logist, new DriverStatusComplete($user_driver, $status, $order)); // to order own
        } else if (!$complete && $logist->isLogist()){
            Notification::send($logist, new DriverStatus($user_driver, $status, $order)); // to order own
        }

        return response()->json(['result' => 'ok']);
    }
}
