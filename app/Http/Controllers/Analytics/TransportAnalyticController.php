<?php

namespace App\Http\Controllers\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Search\Transport\TransportSearch;

use App\Models\Transport\GpsParameterLast;
use App\Models\Transport\GpsParameterList;
use App\Models\Transport\GpsParameterHistory;
use App\Models\Transport\Transport;

use App\Services\LogisticService;
use App\Services\UserDataService;

class TransportAnalyticController extends Controller
{
	public function index(Request $request, UserDataService $user_data_service){

		$user = auth()->user();
		$companyId = $user->company->id;
		$userDataName = 'transport_analytics_blocks';

		if ($request->ajax() && $request->has('position')) {

//			dd($request->position);
			// for block sorting
			$user_data_service->set($user->id, $userDataName, $request->position, true);
			return response()->json();
		}

		$filters = $request->get('filters', []);

		if ($request->ajax() && $filters['search']) {
			$result = $this->search($filters['search']);
			return response()->json($result);
		}

		$search['user'] = $companyId;
		$search['type'] = 'auto';
		$search['transport_relationships'] = 'gps_parameters';

//		$search['gps_parameters'] = true;

		if (!isset($filters['dates_period'])) { //Default, 30 days
			$date_from = Carbon::now()->subDays(30)->startOfDay();
			$date_to   = Carbon::now();
		}
		elseif (isset($filters['dates_period']) && $filters['dates_period'] != 0) { // Setting date
			$date_from = substr($filters['dates_period'], 0, strrpos($filters['dates_period'], "-"));
			$date_to = substr($filters['dates_period'], strrpos($filters['dates_period'], "-") + 1);
			$date_from = str_replace("/", "-", $date_from);
			$date_to = str_replace("/", "-", $date_to);

			$date_from = Carbon::parse($date_from);
			$date_to = Carbon::parse($date_to)->endOfDay();

		}
		else {  //All data - isset($filters['dates']) && $filters['dates'] == 0
			$date_from = false;
			$date_to = false;
		}

		$transports = TransportSearch::apply($search)->latest()->get();
		$transports = $transports->sortByDesc('gps_parameters');

//		$parameters = GpsParameterList::all();
		$parameters = GpsParameterList::where('id', '!=', 4)->get(); // TODO tmp

		$parameters = $parameters->mapWithKeys(function ($item) {
			return [$item['id'] => $item];
		});

		$params_array = [];
		$params_array_last = [];

		if(isset($filters['transport'])){

			$transport = Transport::findOrFail($filters['transport']);

			foreach ($parameters as $parameter){

				if(isset($filters['parameter']) && $filters['parameter'] != $parameter->id)
					continue;

				if($parameter->id == 4)  // TODO tmp
					continue;

				$parameter_last = GpsParameterLast::whereTransportId($transport->id)->whereIoparamId($parameter->id)->first();

				// hasnt gps
				if(!$parameter_last){
					continue;
				}

				if($parameter_last){
					$params_array_last[$parameter->id] = $parameter_last;
				}

				$param_model = new GpsParameterHistory();
				$check = $param_model->setParamTable($companyId, $transport->id, $parameter->id);

				if(!$check)
					continue;

				if($date_from && $date_to) { // if date_from & date_to !== false
					$param_model->whereBetween('ioparam_datetime', [$date_from, $date_to]);
				} else {
					$param_model->limit(10);
				}

				$result = $param_model->get();

				$ioparam_value = $result->map(function ($item, $key) { return $item->ioparam_value;});

				if(isset($filters['parameter'])){
					$ioparam_datetime = $result->map(function ($item, $key) { return '"'.$item->ioparam_datetime.'"';});
				} else {
					$ioparam_datetime = $result->map(function ($item, $key) { return '""';});
				}

//				$ioparam_datetime = $result->map(function ($item, $key) { return '"'.$item->ioparam_datetime.'"';});

				$params_array[$parameter->id] = [
					'value' => implode(",",$ioparam_value->toArray()),
					'datetime' => implode(",",$ioparam_datetime->toArray()),
				];
			}
		}

		if(!empty($params_array) && $userDataPostion = $user_data_service->get($user->id, $userDataName, true)){
			$params_array_new = [];
			foreach ($userDataPostion as $position){
				$params_array_new[$position] = $params_array[$position];
			}
			$params_array = $params_array_new;
		}


//		dd($transports->toArray());
//		dd($params_array);
//		dd($filters);

		return view('analytics.transport_gps', compact('parameters', 'transports', 'params_array_last', 'params_array', 'filters'));
	}

	private function search($search){

		//$data_search['transport'] - using in JS when search
		//$data_search['parameter'] - using in JS when search

		$data_search = [];

		/* STEP 1*/

		$gps_parameters = GpsParameterList::all();

		foreach ($gps_parameters as $parameter){

			if($parameter->id == 4)  // TODO tmp
				continue;

			$lang_name = __('gps.'.$parameter->slug);
			$res = strpos(mb_strtolower($lang_name), mb_strtolower($search));

			if($res !== false){
				$data_search['parameter_'.$parameter->id] = $lang_name;
			}
		}

		if(!empty($data_search))
			return $data_search;

		/* STEP 2*/

		$filter['user'] = auth()->user()->company->id;
		$filter['type'] = 'auto';
		$filter['gps_parameters'] = true;

		$transports = TransportSearch::apply($filter)->latest()->where('number', 'like', '%' . $search. '%')->get();

		if($transports->isNotEmpty()){

			$data_search = $transports->mapWithKeys(function ($item) {
				return ['transport_'.$item['id'] => $item['number']];
			});
		}

//		dd($transports->toArray());
//		dd($transports->count());

		return $data_search;
	}
}
