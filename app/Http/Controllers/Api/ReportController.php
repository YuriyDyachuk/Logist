<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\AnalyticService;
use App\Services\DriverReportService;

use App\Models\Analytics;
use App\Models\Transport\Transport;
use App\Models\Transport\TransportDriver;
use App\Models\Order\Order;
use App\Models\Analytics\DriverReport;
use App\Models\User;

use App\Enums\AnalyticsType;
use App\Enums\ExpensesTypes;


class ReportController extends Controller
{
	private $analytic_service;
	private $user;

//	public function fix(){
//		$data = Analytics::all();
//
//		foreach ($data as $item){
//			if($item->parent_id == $item->transport_id && $item->parent_id == $item->user_id){
//				$transport = Transport::findOrFail($item->transport_id);
//				$item->parent_id = $transport->user_id;
//				$item->user_id = $item->driver_id;
//				$item->save();
//			}
//		}
//	}

//	public function fix(){
//		$data = Analytics::whereNull('expenses_id')->get();
//
//		foreach ($data as $item){
//			$item->fuel = 0;
//			$item->save();
//		}
//	}


	/**
	 * @OA\Post(
	 *      path="/api/v2/report",
	 *      operationId="getDriverReport",
	 *      tags={"Driver report"},
	 *      summary="Get report",
	 *      @OA\Parameter(
	 *          name="date_from",
	 *          description="date_from",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="date_to",
	 *          description="date_to",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      description="Returns Json array",
	 *      @OA\Response(
	 *          response=200,
	 *          description="Json array",
	 *       ),
	 *     )
	 */
	public function getDriverStat(Request $request, AnalyticService $analytic_service){
		$this->analytic_service = $analytic_service;
		$this->user = auth()->user(); // transport id

		$data = [];

		$driver = TransportDriver::whereTransportId($this->user->id)->first();

		$request['date_from'] = $request->date_from !== null ? Carbon::parse($request->date_from)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
		$request['date_to'] = $request->date_to !== null ? Carbon::parse($request->date_to)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();
		$request['date_from_prev'] = $request['date_from']->copy()->subMonth();
		$request['date_to_prev'] = $request['date_from']->copy()->subMonth()->endOfMonth()->endOfDay();

		if($driver){
			$data['data'] = $this->analytic_service->getAnalytics($request, [AnalyticsType::DRIVER, AnalyticsType::DRIVER_UPDATE]);

//			unset($data['data']['fuel_tank']);

			$data['data']['date_from'] = $request['date_from'];
			$data['data']['date_to'] = $request['date_to'];

			$request['date_from'] = $request['date_from_prev'];
			$request['date_to'] = $request['date_to_prev'];

			$fuel_balance_cuurent_month_expenses = $data['data']['expenses']['fuel_quantity'];
			$fuel_balance_cuurent_month_use = $data['data']['fuel'];

			$data['data']['fuel_balance'] = $fuel_balance_cuurent_month_expenses - $fuel_balance_cuurent_month_use;

			$data_last_month = $this->analytic_service->getAnalytics($request, [AnalyticsType::DRIVER, AnalyticsType::DRIVER_UPDATE]);

			$last_trip = $this->analytic_service->getLastDriverTrip(null, [AnalyticsType::DRIVER]);

			$data['last_month'] = $data_last_month;
			$data['last_month']['date_from'] = $request['date_from'];
			$data['last_month']['date_to'] = $request['date_to'];

			if($last_trip){

				$date_now = Carbon::now();
				$date_last_trip = Carbon::parse($last_trip->created_at);

				$data['last_trip_date'] = $last_trip->created_at;
				$data['last_trip_days'] = $date_last_trip->diffInDays($date_now);
			}

			$data['fuel_balance_start_current_month'] = $data_last_month['expenses']['fuel_quantity'] - $data_last_month['fuel'];
		}

		return response()->json($data);
	}

	/**
	 * @OA\Post(
	 *      path="/api/v2/report/detail",
	 *      operationId="getDriverExpensesDetail",
	 *      tags={"Driver report"},
	 *      summary="Get report detail",
	 *      description="Returns Json array",
	 *      @OA\Parameter(
	 *          name="date_from",
	 *          description="date_from",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="date_to",
	 *          description="date_to",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Json array",
	 *       ),
	 *     )
	 */
	public function getDriverExpenses(Request $request, AnalyticService $analytic_service){
		$this->analytic_service = $analytic_service;
		$this->user = auth()->user(); // transport id

		$driver = TransportDriver::whereTransportId($this->user->id)->first();

		$data = [];
		$data_fuel_consumption = [];

		if($driver){
			$data = $this->analytic_service->getAnalyticsByExpensesId($request, [AnalyticsType::DRIVER, AnalyticsType::DRIVER_UPDATE]);

			if(!empty($data)){
				foreach ($data as $key => $items){
					if($items !== null){
						$data[$key] = $items->map(function ($item) {
							return collect($item->toArray())
								->only(['id', 'order_id', 'fuel', 'expenses_amount', 'created_at'])
								->all();
						});
					}
				}
			}

			$data_fuel_consumption_obj = $this->analytic_service->getFuelConsumption($request);

			if($data_fuel_consumption_obj){
						$data_fuel_consumption = $data_fuel_consumption_obj->map(function ($item) {
							return collect($item->toArray())
								->only(['id', 'order_id', 'fuel', 'created_at'])
								->all();
						});
			}
		}

		return response()->json(['expenses' => $data, 'fuel_consumption' => $data_fuel_consumption]);
	}

	/**
	 * @OA\Post(
	 *      path="/api/v2/report-update",
	 *      operationId="reportUpdate",
	 *      tags={"Driver report"},
	 *      summary="Update",
	 *      description="Update",
	 *      @OA\Parameter(
	 *          name="fuel",
	 *          description="fuel (costs) Expenses!",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="fuel_liters",
	 *          description="fuel (liters) Expenses!",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="parking",
	 *          description="parking costs",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="parts",
	 *          description="parts costs",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="other",
	 *          description="other costs",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="fuel_tank",
	 *          description="fuel tank (Balance)",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=5000,
	 *          description="error",
	 *      )
	 *     )
	 */
	public function update(Request $request, AnalyticService $analytic_service, DriverReportService $driver_report_service){

		$data = [];

		$transport = auth()->user();
		$transport->load('drivers');
		$driver = $transport->drivers->first();

		$report = $driver_report_service->checkreport($driver, $transport);

		$data['report_id'] = $report->id;

		if($request->fuel_expense !== null && $request->fuel_liters !== null){
			// buy fuel
			$data['expenses'][ExpensesTypes::FUEL] = $request->fuel_expense;
			$data['fuel_liters'] = $request->fuel_liters;
		}

		if($request->fuel_expense === null && $request->fuel_liters !== null){
			// insert fuel expenses
			$data['expenses'][ExpensesTypes::FUEL] = 0;
			$data['fuel_liters'] = $request->fuel_liters;
		}

		if($request->fuel_expense !== null && $request->fuel_liters === null){
			// insert fuel expenses
			$data['expenses'][ExpensesTypes::FUEL] = $request->fuel_expense;
			$data['fuel_liters'] = 0;
		}

		if($request->parking !== null){
			$data['expenses'][ExpensesTypes::PARKING] = $request->parking;
		}

		if($request->parts !== null){
			$data['expenses'][ExpensesTypes::PARTS] = $request->parts;
		}

		if($request->other !== null){
			$data['expenses'][ExpensesTypes::OTHER] = $request->other;
		}

		if($request->fuel_tank){
			$data['fuel_tank'] = $request->fuel_tank;
		}

		$data['comment'] = $request->comment;

		if(count($data) == 1 && $data['comment'] !== null){
			return response()->json(['result' => false, 'msg' => 'no data (fuel_consumption | expenses)']);
		}

		$result = $analytic_service->updateStatByDriver($data);

		return response()->json(['result' => $result , 'msg' => $msg ?? ''], ($result) ? 200 : 500);
	}

	/**
	 * @OA\Get(
	 *      path="/api/v2/report/expenses",
	 *      operationId="reportExpensesList",
	 *      tags={"Driver report"},
	 *      summary="List",
	 *      description="Driver Expenses List",
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       )
	 *     )
	 */
	public function getExpenses(){
		return response()->json(['result' => Analytics\Expenses::all()]);
	}
}
