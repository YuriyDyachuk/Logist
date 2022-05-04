<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Models\Order\Order;
use App\Models\Analytics;
use App\Models\OrderGeo;
use App\Models\Transport\TransportDriver;
use Carbon\Carbon;
use App\Enums\AnalyticsType;
use App\Enums\ExpensesTypes;

class AnalyticService {

    protected
        $parent_id,
        $isOwn,
	    $isDriver,
        $user_id,
        $driver_id,
        $transport_id,
        $order,
        $distance_full,
        $distance_empty,
        $fuel,
        $duration,
        $amount_plan,
        $amount_fact,
        $timeNow;

	protected $expenses_array = [
				'fuel'      => ExpensesTypes::FUEL,
				'parking'   => ExpensesTypes::PARKING,
				'parts'     => ExpensesTypes::PARTS,
				'other'     => ExpensesTypes::OTHER
				];

	protected $expenses = [];

	/**
	 * AnalyticService constructor.
	 */
    public function __construct()
    {
        $this->timeNow = Carbon::now();
        $user = auth()->user();

        $this->user_id = $user->id;

	    $this->isDriver = false;
	    $this->isOwn = false;

        if($user->parent_id == 0 && $user->parent_id !== null){
            // own company
            $this->parent_id = $user->id;
            $this->isOwn = true;
        }
        elseif ($user->getTable() == 'transports') {
			// if driver
	        $this->parent_id = $user->user_id;
	        $this->transport_id = $user->id;
	        $driver = TransportDriver::whereTransportId($this->transport_id)->first();
	        if($driver){
		        $this->driver_id = $driver->user_id;
	        }

	        $this->isDriver = true;
        }
        else {
            // logist
            $this->parent_id = $user->parent_id;
        }

    }

	/**
	 * @param Order $order
	 * @param array $params
	 */
    public function updateStat(Order $order, $params = []){

        $this->order = $order;

        $this->transport_id = $order->transports->first()->id;
        $this->driver_id = TransportDriver::where('transport_id', $this->transport_id)->value('user_id');

	    $performer = $order->getPerformer();
	    $user = auth()->user();
	    if($performer === null && $user->getTable() == 'transports'){
		    $performer = $order->getPerformer($user->user_id); // if driver complete order
		    $this->user_id = $this->driver_id;
	    }

        if($order->geo->isNotEmpty()){

            if($order->geo->first()->gps_type_id == 1){
                // app
	            $distance_empty = OrderGeo::where('order_id', $order->id)->whereNull('status_id')->get()->first();

	            $this->distance_full = $this->order->geo->first()->odometer/1000;
	            $this->distance_empty = $distance_empty !== null ? $distance_empty->odometer/1000 : 0;

            }
            else {
                // gps globus
                $odometer_start = $this->order->geo->last()->odometer;
                $odometer_end = $this->order->geo->first()->odometer;

                $this->distance_full = $odometer_end - $odometer_start;
                $this->distance_empty = 0;
            }

            $fuel_start = $this->order->geo->last()->fuel;
            $fuel_end = $this->order->geo->last()->fuel;
            $this->fuel = $fuel_end - $fuel_start;

            $date_end = Carbon::parse($this->order->geo->last()->datetime);
            $date_start = Carbon::parse($this->order->geo->first()->datetime);

            $this->duration = $date_end->diffInSeconds($date_start);

            $this->amount_plan = $performer->amount_plan;
            $this->amount_fact = $performer->amount_fact;


        } else {
            $this->fuel = 0;
            $this->distance_full = 0;
            $this->distance_empty = 0;
            $this->duration = 0;
            $this->amount_plan = $performer->amount_plan;
            $this->amount_fact = $performer->amount_fact;
        }

        $this->storeStatOrder();
        $this->storeStatDriver();
    }


	public function updateStatByDriver($params = []){

		try {

		$this->expenses = $params;

		$params['fuel_consumption'] = 0;
		$fuel_expenses_liters = 0;

		// costs
		if(isset($params['expenses']) && !empty($params['expenses'])){
			foreach ($params['expenses'] as $key => $expenses)    {

				if($key == 1 && isset($params['fuel_tank'])){
					$fuel_expenses_liters = $params['fuel_liters'];
				}

				Analytics::create([
					'parent_id' => $this->parent_id,
					'driver_id' => $this->driver_id,
					'transport_id' => $this->transport_id,
					'user_id'   => $this->user_id,
					'fuel'      => ($key == 1 && isset($params['fuel_liters'])) ? $params['fuel_liters'] : 0,
					'expenses_id' => $key,
					'expenses_amount' => $expenses,
					'comment' => $params['comment'],
					'time'      => $this->timeNow,
					'type'      => AnalyticsType::DRIVER_UPDATE,
					'report_id'      => $params['report_id'],
				]);
			}
		}

		$fuel_last_fuel_tank_litres = 0;

		$last_consumptions = Analytics::where('driver_id', $this->driver_id)
		                              ->where('parent_id', $this->parent_id)
		                              ->where('transport_id', $this->transport_id)
		                              ->whereNull('expenses_id')
		                              ->latest()
		                              ->first();

	    $last_row = Analytics::where('driver_id', $this->driver_id)
										->where('parent_id', $this->parent_id)
										->where('transport_id', $this->transport_id)
										->where(function($q) {
										    $q->where('expenses_id', 1) // fuel
										      ->orWhere('fuel_tank', null);
										})
										->latest()
										->first();

	    if($last_row && $last_row->fuel_tank === null){
			// if in request no expenses fuel parameter
		    $fuel_expenses_liters = $last_row->fuel;
	    }

		if($last_consumptions && $last_consumptions->fuel_tank !== null) {
			$fuel_last_fuel_tank_litres    = $last_consumptions->fuel_tank;
		}

		if(isset($params['fuel_tank'])){
			$params['fuel_consumption'] = ($fuel_last_fuel_tank_litres + $fuel_expenses_liters) - $params['fuel_tank'];
		}

		if(isset($params['fuel_tank'])){

			Analytics::create([
				'parent_id' => $this->parent_id,
				'driver_id' => $this->driver_id,
				'transport_id' => $this->transport_id,
				'user_id'   => $this->user_id,
				'fuel'      => isset($params['fuel_consumption']) ? $params['fuel_consumption'] : 0,
				'fuel_tank' => $params['fuel_tank'],
				'comment' => $params['comment'],
				'time'      => $this->timeNow,
				'type'      => AnalyticsType::DRIVER_UPDATE,
				'report_id'      => $params['report_id'],
			]);
		}


			return true;

		} catch (\Exception $e) {
			DB::rollback();
			logger(['line' => $e->getLine(), 'message' => $e->getMessage()]);

			return false;
		}
	}

	/**
	 * storeStatOrder
	 */
    private function storeStatOrder(){

        Analytics::create([
            'parent_id' => $this->parent_id,
            'driver_id' => $this->driver_id,
            'transport_id' => $this->transport_id,
            'user_id'   => $this->user_id,
            'order_id'  => $this->order->id,
            'distance'  => $this->distance_full,
            'distance_empty'  => $this->distance_empty,
            'duration' => $this->duration,
            'fuel'      => $this->fuel,
            'amount_plan'    => $this->amount_plan,
            'amount_fact'    => ($this->amount_fact !== null ) ? $this->amount_fact : 0,
            'time'      => $this->timeNow,
            'type'      => AnalyticsType::ORDER,
        ]);
    }

	/**
	 * storeStatDriver
	 */
    private function storeStatDriver(){

        Analytics::create([
            'parent_id' => $this->parent_id,
            'driver_id' => $this->driver_id,
            'transport_id' => $this->transport_id,
            'user_id'   => $this->user_id,
            'order_id'  => $this->order->id,
            'distance'  => $this->distance_full,
            'distance_empty'  => $this->distance_empty,
            'duration' => $this->duration,
            'fuel'      => $this->fuel,
            'amount_plan'    => $this->amount_plan,
            'amount_fact'    => ($this->amount_fact !== null ) ? $this->amount_fact : 0,
            'time'      => $this->timeNow,
            'type'      => AnalyticsType::DRIVER,
        ]);
    }

	/**
	 * @param array $data
	 * @param array $types
	 *
	 * @return array
	 */
    public function getAnalytics($data = [], $types = []){
        if(empty($types)) {
            $types[0] = AnalyticsType::ORDER;
            $types[1] = AnalyticsType::ORDER_UPDATE;
        }

        $stat_current_query = Analytics::whereIn('type', $types);

        if($this->isOwn === true){
            $stat_current_query->where('parent_id', $this->parent_id);
        }
        elseif ($this->isDriver) {
	        $stat_current_query->where('driver_id', $this->driver_id);
        }
        else {
            $stat_current_query->where('user_id', $this->user_id);
        }

        if(isset($data['date_from']) && isset($data['date_to'])){
            $stat_current_query->whereBetween('time', [$data['date_from'], $data['date_to']]);
        }

        if(isset($data['driver_id'])){
            $stat_current_query->where('driver_id', $data['driver_id']);
        }

	    $stat_current_query_full = clone $stat_current_query;

        $stat_current = $stat_current_query_full->whereNull('expenses_id')->first( array(
            \DB::raw( 'SUM(distance) AS distance' ),
            \DB::raw( 'SUM(distance_empty) AS distance_empty' ),
            \DB::raw( 'SUM(fuel) AS fuel' ),
            \DB::raw( 'SUM(duration) AS duration' ),
            \DB::raw( 'SUM(amount_plan) AS amount_plan' ),
            \DB::raw( 'SUM(amount_fact) AS amount_fact' ),
            \DB::raw( 'COUNT(order_id) AS orders' ),
        ));

        $data = [];

        foreach($this->expenses_array as $key => $expenses){
	        $stat_expenses_query = clone $stat_current_query;

	        $stat_expenses = $stat_expenses_query->where('expenses_id', $expenses)->select(\DB::raw( 'SUM(expenses_amount) AS '.$key ))->first();

	        $data['expenses'][$key] = ($stat_expenses &&  $stat_expenses->{$key} !== null) ? $stat_expenses->{$key} : 0;

	        // fuel
	        if($key === 'fuel'){
		        $stat_expenses_query_fuel =  clone $stat_current_query;
		        $stat_fuel = $stat_expenses_query_fuel->where('expenses_id', $expenses)->select(\DB::raw( 'SUM(fuel) AS '.$key ))->first();
		        $data['expenses']['fuel_quantity'] = ($stat_fuel &&  $stat_fuel->{$key} !== null) ? $stat_fuel->{$key} : 0;
	        }
        }

	    $data['distance'] = $stat_current->distance !== null ? $stat_current->distance : '0';
	    $data['fuel'] = $stat_current->fuel !== null ? $stat_current->fuel : 0;
	    $data['fuel_tank'] = $stat_current->fuel_tank !== null ? $stat_current->fuel_tank : 0;
	    $data['distance_empty'] = $stat_current->distance_empty !== null ? $stat_current->distance_empty : '0';
	    $data['duration'] = $stat_current->duration !== null ? $stat_current->duration : '0';
	    $data['amount'] = $stat_current->amount_plan !== null ? $stat_current->amount_plan : '0';
	    $data['amount_fact'] = $stat_current->amount_fact !== null ? $stat_current->amount_fact : '0';
	    $data['orders'] = $stat_current->orders !== null ? $stat_current->orders : '0';
	    $data['date_from'] = isset($data['date_from']) ? $data['date_from'] : '';
        $data['date_to'] = isset($data['date_to']) ? $data['date_to'] : '';

        return $data;
    }

    public function getLastDriverTrip($data = [], $types = []){

	    $last_trip = Analytics::whereIn('type', $types)->whereDriverId($this->driver_id)->first();

	    if($last_trip){
			return $last_trip;
	    }

	    return false;
    }

    public function getFuelConsumption($data = [], $types = []){
	    if(empty($types)) {
		    $types[0] = AnalyticsType::DRIVER;
		    $types[1] = AnalyticsType::DRIVER_UPDATE;
	    }

	    $stat_current_query = Analytics::whereIn('type', $types)->whereNull('expenses_id');

	    if(isset($data['date_from']) && isset($data['date_to'])){
		    $stat_current_query->whereBetween('time', [$data['date_from'], $data['date_to']]);
	    }

	    if(isset($data['driver_id'])){
		    $stat_current_query->where('driver_id', $data['driver_id']);
	    } else {
		    $stat_current_query->where('driver_id', $this->driver_id);
	    }

	    $stat_current = $stat_current_query->get();

	    if($stat_current->isNotEmpty()){
		    return $stat_current;
	    }

	    return false;
	}


	/**
	 * @param array $data
	 * @param array $types
	 *
	 * @return array
	 */
	public function getAnalyticsByExpensesId($data = [], $types = []){
		if(empty($types)) {
			$types[0] = AnalyticsType::ORDER;
			$types[1] = AnalyticsType::ORDER_UPDATE;
		}

		$stat_current_query = Analytics::whereIn('type', $types);

		if(isset($data['date_from']) && isset($data['date_to'])){
			$stat_current_query->whereBetween('time', [$data['date_from'], $data['date_to']]);
		}

		if(isset($data['driver_id'])){
			$stat_current_query->where('driver_id', $data['driver_id']);
		} else {
			$stat_current_query->where('driver_id', $this->driver_id);
		}

		$data = [];

		foreach($this->expenses_array as $key => $expenses){
			$stat_expenses_query = clone $stat_current_query;
			$stat_expenses = $stat_expenses_query->whereExpensesId($expenses)->get();
			$data[$key] = ($stat_expenses->isNotEmpty()) ? $stat_expenses : null;
		}

		return $data;
	}

	/**
	 * @param $request
	 *
	 * @return array|bool
	 */
    public function setCompanyParameter($request){

        $date_from = substr($request->daterange, 0, strrpos($request->daterange, "-"));
        $date_from = str_replace("/", "-", $date_from);
        $date_from = Carbon::parse($date_from)->startOfDay();

        $date_to = substr($request->daterange, strrpos($request->daterange, "-") + 1);
        $date_to = str_replace("/", "-", $date_to);
        $date_to = Carbon::parse($date_to)->endOfDay();

        $data = [
            'date_from' => $date_from,
            'date_to' => $date_to,
        ];

        $value = str_replace(',', '.', $request->value);

        if(!in_array($request->parameter, ['distance', 'distance_empty', 'fuel', 'amount'])) return false;
        if(!is_numeric($value)) return false;

        if($request->driver_id == ''){
            $this->driver_id = 0;
            $this->transport_id = 0;
        }
        else {
            $this->driver_id = $request->driver_id;
            $driver = TransportDriver::where('user_id', $this->driver_id)->first();
            $this->transport_id = $driver ? $driver->transport_id : 0;

            $data['driver_id'] = $this->driver_id;
        }

        $data_insert = [
            'parent_id' => $this->parent_id,
            'driver_id' => $this->driver_id,
            'transport_id' => $this->transport_id,
            'user_id'   => $this->user_id,
            $request->parameter    => $value,
            'time'      => $this->timeNow,
            'type'      => AnalyticsType::DRIVER_UPDATE,
        ];

       Analytics::create($data_insert);

        return $this->getAnalytics($data, [AnalyticsType::DRIVER, AnalyticsType::DRIVER_UPDATE]);
    }

    public function updDriverReportStatus($data){

//		$types = [AnalyticsType::DRIVER, AnalyticsType::DRIVER_UPDATE];

		Analytics::whereBetween('time', [$data['date_from'], $data['date_to']])
		    ->where('driver_id', $data['driver_id'])
			->whereNull('report_id')
//		    ->whereIn('type', $types)
		    ->update(['report_id' => $data['report_id']]);
    }

}
