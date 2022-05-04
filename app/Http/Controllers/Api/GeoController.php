<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrderDeviation;
use App\Models\Geo;
use App\Models\OrderGeo;
use App\Models\Order\Order;
use App\Models\Transport\Transport;
use App\Services\GoogleService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

use App\Search\Transport\TransportSearch;

class GeoController extends Controller
{
    private $redis_expiration_time = 3600; // sec

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @deprecated
     */
//    public function set(Request $request)
//    {
//        $validator = $this->validateSetPosition($request);
//
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->errors()], 401);
//        }
////        Log::info("Single ".json_encode($request->all()));
//        $user = \Auth::user();
//        $driver    = $user->drivers()->first();
//        $lang = $driver->locale;
//        $transport = false;
//        if ($user && $request->get('transport_id', 0) > 0) {
//            $data = $request->only(['transport_id', 'order_id', 'lat', 'lng', 'datetime', 'status_id']);
//
//            $data['speed'] = $request->get('speed', 0);
//            $data['odometer'] = $request->get('odometer', 0);
//            $data['gps_type_id'] = 1;
//            $data['status_id'] = isset($data['status_id']) && intval($data['status_id'])>0 ? $data['status_id'] : null;
//            // проверяем последние координаты транспорта
//            $transport=Transport::find($data['transport_id']);
//            if ($old_geo && $transport->lat != null)
//                $dist = app_map_distance_coo($data['lat'], $data['lng'], $transport->lat, $transport->lng);
//            else
//                $dist = 300;
//            if ($dist > 200) {
//                if ($transport && ($transport->current_date == null || strtotime($transport->current_date) < strtotime($data['datetime']))) {
//                    $transport->lat = $data['lat'];
//                    $transport->lng = $data['lng'];
//                    $transport->current_date = $data['datetime'];
//                    $transport->current_order_id = $data['order_id'];
//                    $transport->current_speed = $data['speed'];
//                    $transport->save();
//                }
//                OrderGeo::create($data);
//            }
//            Geo::create($data);
//
//            return response()->json(['result' => 'success'], 200);
//        } else {
//
//            return response()->json(['result' => 'false'], 404);
//        }
//    }

	public function setArray(Request $request)
	{
        $env = config('app.env');
		$transport = auth()->user();

        if ($transport->monitoring === 'gps') {
            return response()->json(['result' => 'success'], 200);
        }

        $redis_transport_id_key = $env.'transportid_'.$transport->id;
        $redis_order_id_key = $env.'transportidorderid_'.$transport->id;
        $redis = Redis::connection();
        $transportId = $redis->get($redis_transport_id_key);
        if(!$redis->exists($redis_transport_id_key)){
            Log::info("Redis Transport ID ".date('Y-m-d H:i:s'));
            $transportId = $transport->id;
            $redis->set($redis_transport_id_key, $transportId);
            $redis->expire($redis_transport_id_key, $this->redis_expiration_time);
        }

        $orderId = $redis->get($redis_order_id_key);
        if(!$redis->exists($redis_order_id_key)) {
            $performers = $transport->performers;
            $lastPerformer = $performers->last();
            if ($lastPerformer) {
                $orderId = $lastPerformer->order_id;
                $redis->set($redis_order_id_key, $orderId);
                $redis->expire($redis_order_id_key, $this->redis_expiration_time);
            } else {
                $orderId = 0;
            }
        }

		if ($request->has('data')) {
			$data = $request->data;
            $orderIds = array_column($request->data, 'order_id');
            $orderId = $orderIds[0] ?? $orderId;
			innlogger_geo("Array ".json_encode($request->all()));
            $old_lat = 0;
            $old_lng = 0;
            $transport = false;
			foreach($data as $key => $geo) {
				$item = [
					'transport_id'  => $transportId,
					'order_id'      => $orderId,
					'lat'           => $geo['lat'],
					'lng'           => $geo['lng'],
					'datetime'      => $geo['datetime'],
					'odometer'      => isset($geo['odometer']) ? $geo['odometer'] : 0,
					'deviation'     => isset($geo['deviation']) ? $geo['deviation'] : null,
					'status_id'     => isset($geo['statusId']) && intval($geo['statusId'])>0 ? $geo['statusId'] : null,
				];

                $item['speed'] = isset($geo['speed']) ? $geo['speed'] : 0;
                $item['gps_type_id'] = 1;
                
                $dist = app_map_distance_coo($item['lat'], $item['lng'], $old_lat, $old_lng);

				innlogger_geo("Array #item ".json_encode($item));
				innlogger_geo("Array #DIST ".$dist);

                if (!$transport || $dist > 200) {
//                    logger($data);
//	                Log::channel('innlogist_geo')->info("Array #2 ".json_encode($data));
                    if ($orderId !== null) {
                        $tmpGeo = OrderGeo::where('datetime', $item['datetime'])
                            ->where('order_id', $item['order_id'])
                            ->where('transport_id', $item['transport_id'])
                            ->first();

                        if (!$tmpGeo) {
                            OrderGeo::create($item);
                        }
                    }

                    $old_lat = $item['lat'];
                    $old_lng = $item['lng'];
                    if (!$transport) {
                        $transport=Transport::find($item['transport_id']);
                    }

                    if ($transport->current_date == null || strtotime($transport->current_date) < strtotime($item['datetime'])) {
                        $transport->lat = $item['lat'];
                        $transport->lng = $item['lng'];
                        $transport->current_date = $item['datetime'];
                        $transport->current_order_id = $item['order_id'];
                        $transport->current_speed = $item['speed'];
                    }
                }

				Geo::create($item);
			}

			if ($orderId !== null) {
                dispatch(new ProcessOrderDeviation($orderId, auth()->user()->id));
            }

            if ($transport) {
                $transport->save();
            }
			return response()->json(['result' => 'success'], 200);
		} else {
			return response()->json(['result' => 'false'], 404);
		}
	}

    /**
     * @param Request $request
     * @return mixed
     */
    public function validateSetPosition(Request $request)
    {
        return \Validator::make($request->all(), [
            'transport_id' => 'required',
            'order_id'     => 'required',
        ]);
    }

    public function getRoute(Request $request) {

        $order = Order::findOrFail($request->order_id);

        if($order->addresses){
            $address_last = $order->addresses->last();
            $points =  (new GoogleService())->getRoutePoints($request->start, $address_last->lat.','.$address_last->lng);
            return response()->json(['route' => $points]);
        }

        return response()->json(['route' => false]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransportGps()
    {
	    $filters['user'] = auth()->user()->company->id;
	    $filters['type'] = 'auto';

	    $query = TransportSearch::apply($filters);

        $data = $query->get();

        return response()->json($data, 200);
    }

}
