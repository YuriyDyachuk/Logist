<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Models\Transport\TransportDriver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\GcmService;

class ProgressController extends Controller
{
    /**
     * @param $orderId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($orderId, Request $request)
    {
        $order = Order::query()->findOrFail($orderId);
        $performer = $order->getPerformer();
        $driver_id = TransportDriver::where('transport_id', $performer->transport_id)->value('user_id');

        $data = $request->get('data');

	    if($data) {
		    foreach ( $data as $k => $item ) {
			    if ( preg_match( "/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $item['date_at'] ) ) {
				    $time1                 = Carbon::createFromFormat( 'd/m/Y H:i', $item['date_at'] );
				    $data[ $k ]['date_at'] = $time1->format( 'Y-m-d H:i:s' );
			    }
		    }
	    }

        if(is_string($data)) {
            $data = json_decode($data);
        }

        $order->progress = $data;
        $order->save();

        GcmService::sendOrderNotification(5, $driver_id, $order->id);

        return response()->json(['status' => 'OK', 'data' => $data]);
    }
}
