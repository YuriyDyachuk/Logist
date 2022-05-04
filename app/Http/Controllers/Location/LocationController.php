<?php

namespace App\Http\Controllers\Location;

use App\Services\PositionDashboardService;
use App\Models\OrderGeo;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Enums\OrderStatus;

use App\Http\Requests\Location\AjaxRequests;

use App\Models\Order\Cargo;
use App\Models\Order\Order;
use App\Models\Order\OrderPerformer;
use App\Models\Status;
use App\Models\Transport\Transport;
use App\Models\Transport\TransportDriver;
use App\Models\User;

use App\Services\GeoService;
use App\Services\GlobusService;
use App\Services\GoogleService;
use App\Services\RedisService;
use App\Services\UserDataService;

use App\Search\Transport\TransportSearch;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request, UserDataService $user_data_service)
    {

        $user = \Auth::user();

	    if ($request->ajax()) {
		    // GLOBUS GPS - not used
		    $geoService = new GeoService( $user->transports );
		    $geoService->createOrUpdateDataGeo();
	    }


        $transport_number = $request->get('filters');

        $status_active = Status::getId('active');

	    // FILTERS

	    $filters['user'] = $user->company->id;
	    $filters['type'] = 'auto';
	    $filters['transport_relationships'] = 'status';

	    if(isset($transport_number['number']) && $transport_number['number'] != 0) {
		    $filters['id'] = $transport_number['number'];
	    }

	    if(isset($transport_number['location']) && $transport_number['location'] != 0) {
		    if($transport_number['location'] == 1)
		        $filters['monitoring'] = 'gps';
		    if($transport_number['location'] == 2)
		        $filters['monitoring'] = 'app';
	    }

	    if(isset($transport_number['status']) && $transport_number['status'] != 0) {
		    $status_active = Status::getId($transport_number['status']);
		    $filters['status'] = $transport_number['status'];
	    }

	    $user_transports = TransportSearch::apply($filters)->with(['getAttachedOrders' => function($q) use ($status_active){
		    return $q->where('current_status_id', $status_active);
	    },'gps_parameters'])->get();

	    // TRANSFORMS
        $user_transports->transform(function ($transport, $key) use ($user) {

	        $order = false;
	        $order_active_id = 0;

	        if($transport->getAttachedOrders()->count() > 0){
		        $order_active_id = $transport->getAttachedOrders()->first()->id;
		        $order = $transport->getAttachedOrders()->first();
		        $order->load(['addresses', 'performers', 'payment_type', 'payment_term']);
	        }

                $cargo = Cargo::query()->where('order_id', $transport->current_order_id)->value('name');

	            if (!$order) {
	                $order = Order::query()
	                              ->where('id', $transport->current_order_id)
	                              ->with(['addresses', 'performers', 'payment_type', 'payment_term'])
	                              ->first();
                    if ($order) {
                        $order_active_id = $order->id;
                    } else {
                        $order_active_id = 0;
                    }
                }

                $coords = $transport->latestGeoLastTwo;

		        $angle = 0;

		        if($coords->count() > 1){
					$lat_current = $coords->last()->lat;
			        $lng_current = $coords->last()->lng;
			        $lat_prev = $coords->first()->lat;
			        $lng_prev = $coords->first()->lng;

			        if(($lat_prev - $lat_current) != 0){
				        $angle = atan(($lng_prev - $lng_current) / ($lat_prev - $lat_current)) * 180 / pi();
			        }
		        }

                return [
                    'id'            => $transport->id,
                    'name'          => $transport->model . ' ' . $transport->number,
	                'status_id'     => $transport->status_id,
	                'status'        => ($transport->status) ? $transport->status->name : null,
                    'lat'           => $transport->lat,
                    'lng'           => $transport->lng,
	                'angle'         => $angle,
	                'location'      => false,
//	                'location'      => $this->getAddressByCoordinates($transport->lat, $transport->lng, $transport->id),
	                'gps_params'    => $transport->gps_parameters,
	                'monitoring'    => $transport->monitoring,
                    'speed'         => $transport->current_speed,
                    'ignition'      => \App\Services\RedisService::getParam('globus_ignition_'.$transport->id),
                    'odometer'      => 0,
                    'fuel'          => 0,
                    'data'          => $transport->current_data,
                    'order'         => ($transport->current_order_id && $transport->status_id == Status::getOnFlightTransportStatusId()) ? $order_active_id : null,
                    'driver'        => $transport->drivers->first() ? $transport->drivers->first()->name : [],
                    'driver_phone'  => $transport->drivers->first() ? $transport->drivers->first()->phone : null,
                    'cargo'         => $cargo,
                    'amount_plan'   => $order['amount_plan'],
                    'payment_type'  => ($order['payment_type'] !== null) ? trans('all.order_'.$order['payment_type']->name) : '',
                    'payment_term'  => ($order['payment_term'] !== null) ? trans('all.order_'.$order['payment_term']->name) : '',
                    'client'        => $user->name,
                    'client_phone'  => $user->phone,
                    'order_full'    => $order
                ];
        });

        $transports = $user_transports->filter()->values()->all();
        if ($request->ajax()) {

            $refreshHTML = $request->get('refresh');
            $html = '';
            if ($refreshHTML) {
                $html = \View::make('location.includes.lists-content', ['transports' => json_encode($transports)])->render();
            }

            return response()->json(['transports' => $transports, 'errors' => $geoService->getErrors(), 'html' => $html]);
        }

        // ORDER MODAL BLOCKS
	    $userBlockModalPostions = $user_data_service->get($user->id, 'locations_modal_blocks', true);

        return view('location.index', [
            'transports' => json_encode($transports),
//            'errors'     => json_encode($geoService->getErrors()),
            'position' => $userBlockModalPostions
        ]);
    }

    public function position(Request $request, UserDataService $user_data_service, PositionDashboardService $positionDashboardBlock){

	    $positionDashboardBlock->ajaxPosDashboard($request, $user_data_service);

    }

    /**
     * Select number of transport for search-filter in view
     */
    public function search_number(Request $request)

    {
//        if(!app_has_access('locations.all'))
//            abort(404);

        $user = \Auth::user();

        if ($request->ajax()) {

            $number = $request->get('filters');

            $transport_list = [];

	        $transports_number = Transport::query()
				->where('user_id', $user->id)
                ->where(function($q) use ($number){
                    $q->where(function ($query) use ($number) {
                        $query->where('number', 'like', '%' . ($number['number'] ? $number['number'] : '') . '%')
                            ->where('number', '<>', '');
                    })
                        ->orWhere(function($query)  use ($number) {
                            $query->where('id', $number['number']);
                        });
                })
		        ->orderBy('number')
                ->has('geo')
		        ->get();

            if ($transports_number->isNotEmpty()) {
                foreach ($transports_number as $transport) {
                    $transport_list[$transport->id] = $transport->number;
                }
            }

            return response()->json($transport_list);
        }
    }

    /**
     * Return list of transports (search by order id, transport number, transport id)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search_data(Request $request)
    {
        $user = \Auth::user();
        if (!$request->ajax()) {
            return response()->json([]);
        }

        $activeStatus = Status::where('name', OrderStatus::ACTIVE)->first();
        $number = $request->get('search', '');
        $query = Transport::query()
            ->with(['orders'])
            ->usersJoin()
            ->ordersJoin()
            ->where((new Transport)->getTable().'.user_id', $user->id)
            ->where(function($q) use ($number, $activeStatus) {
                $q->where(function ($query) use ($number, $activeStatus) {
                    $query->whereRaw('CONCAT(`' . (new Transport)->getTable() . '`.`model`, " ", `' . (new Transport)->getTable() . '`.`number`) like "%'. $number . '%"');
                    $query->orWhere((new Transport)->getTable() . '.id', 'like', '%'. $number .'%');
                    $query->orWhere((new User)->getTable() . '.name', 'like', '%'. $number .'%');
                    $query->orWhere((new User)->getTable() . '.phone', 'like', '%'. $number .'%');
                    $query->orWhere(function ($query) use ($number, $activeStatus) {
                        $query->where('current_status_id', $activeStatus->id);
                        $query->whereNull((new OrderPerformer)->getTable() . '.deleted_at');
                        $query->where(function ($query) use ($number) {
                            $query->where((new Order)->getTable() . '.id', 'like', '%'. $number .'%');
                            $query->orWhere((new Order)->getTable() . '.inner_id', 'like', '%'. $number .'%');
                        });
                    });
                });
            })
            ->select(['transports.id', 'transports.number']);

        $transportIds = $query->get()
            ->pluck('number', 'id')
            ->toArray();

        return response()->json($transportIds);
    }
    
    /**
     * @param $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRouteOrder($order)
    {
        $order = Order::query()->findOrFail($order);
        $order->load(['transports', 'addresses']);
        $data['addresses'] = $order->addresses->map(function ($address) {
            return [
                'type' => $address->pivot->type,
                'lat'  => $address->lat,
                'lng'  => $address->lng,
            ];
        });

        $data['directions_plan'] = $order->directions;
        $data['directions_fact'] = GeoService::getDirections(
            $order->transports->first(),
            $order->addresses->first()->pivot->date_at,
            $order->addresses->last()->pivot->date_at,
            $order->id
        );

        return response()->json($data, 200);
    }

    public function getRouteTransport(Request $request){

	    $from = Carbon::createFromFormat('d/m/Y', $request->from);
	    $to = Carbon::createFromFormat('d/m/Y', $request->to);

		$result = OrderGeo::query()->whereBetween('datetime', [$from, $to])->orderBy('datetime')->limit(1000)->get();

	    $route = null;

		if($result->isNotEmpty()){
			$route = $result->map(function ($geo) {
				return [
					'lat'  => $geo->lat,
					'lng'  => $geo->lng,
				];
			});
		}

	    return response()->json(['route' => $route]);
    }

    /**
     * @param $id
     */
    public function globusRouteLayerKml($id)
    {
        $data = [
            'key'       => \Cache::get($id . '-key'),
            'from_date' => \Cache::get($id . '-from_date'),
            'to_date'   => \Cache::get($id . '-to_date'),
            'ids'       => $id,
        ];

        $kml = (new GlobusService())->moveGGeoKml($data);

        header('Content-type: application/vnd.google-earth.kml+xml');

        echo $kml;
    }

    private function getAddressByCoordinates($lat,$lng,$transport_id){

	    $dist = 10; /* m*/
	    $duration = 5*60; /* sec */

        if(is_numeric($lat) && is_numeric($lng)){

	        innlogger_google('LocationController@getAddressByCoordinates');
	        $google_service = new GoogleService();
//	        $address =  $google_service->getAddressByCoordinates($lat, $lng); //TODO need uncomment

	        // get prev coord
	        $transport_lat_last = RedisService::getParam('transport_geo_lat_'.$transport_id);
	        $transport_lng_last = RedisService::getParam('transport_geo_lng_'.$transport_id);

	        $transport_address = RedisService::getParam('transport_geo_address_'.$transport_id);
	        $transport_address_time = RedisService::getParam('transport_geo_address_time_'.$transport_id);

	        //store next coord
	        RedisService::setParam('transport_geo_lat_'.$transport_id, $lat, 250);
	        RedisService::setParam('transport_geo_lng_'.$transport_id, $lng, 250);

	        if($transport_address === false || $transport_address == ''){
		        innlogger_google('GET ADDRESS 0 FALSE');
		        $google_service = new GoogleService();
		        $transport_address =  $google_service->getAddressByCoordinates($lat, $lng);
	        }

	        if($transport_lat_last && $transport_lng_last){
		        $diff = app_map_distance_coo($transport_lat_last, $transport_lng_last, $lat, $lng);

		        innlogger_google('DIFF '.$diff);

		        if($diff < $dist){
			        innlogger_google('GET ADDRESS 1 '.$transport_address);
			        return $transport_address;
		        }
	        }

	        if($transport_address_time){
		        innlogger_google('GET ADDRESS 2 '.$transport_address);
		        return $transport_address;

	        } else {
		        RedisService::setParam('transport_geo_address_time_'.$transport_id, time(), $duration);
	        }

	        $transport_address =  $google_service->getAddressByCoordinates($lat, $lng);

	        innlogger_google('GET ADDRESS 3 FINAL '.$transport_address);

	        RedisService::setParam('transport_geo_address_'.$transport_id, $transport_address, 400);

	        return $transport_address;

        }

        return false;
    }

    public function ajaxRequests(AjaxRequests $request)
    {
        $data = false;

        switch ($request->action) {
            case 'getAddressByCoordinat':
                $data = $this->getAddressByCoordinates($request->lat, $request->lng, $request->transport_id);
                break;
        }

        return response()->json(['data' => $data]);
    }
}
