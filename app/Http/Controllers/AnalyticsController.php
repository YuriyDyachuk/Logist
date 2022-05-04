<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticsCompaniesExport;
use App\Exports\AnalyticsDealsExport;
use App\Exports\AnalyticsLogisticsExport;

use App\Models\Status;
use App\Models\User;
use App\Models\Order\Order;
use App\Models\Transport\Transport;

use App\Search\Order\OrderSearch;

use App\Services\AnalyticService;
use App\Services\LogisticService;
use App\Services\TransportService;

use Carbon\Carbon;

use App\Enums\OrderStatus;
use App\Enums\AnalyticsType;



class AnalyticsController extends Controller
{
    public function index(Request $request){

    }

    public function companies(Request $request, AnalyticService $analyticService) {

	    $users = LogisticService::getLogistsArray();

	    $data = [];

        // Adds filters
        $this->filters                  = $request->get('filters');
        $this->filters['relationships'] = true; //Eager Loading

        $filters = $this->filters;
        $user    = \Auth::user();

//        $users = [$user->id];
//        $logists = $user->getCompanyStaffByRoleName(\App\Enums\UserRoleEnums::LOGIST);
//
//        $data = [];
//
//        if($logists->isNotEmpty()){
//            $users = array_merge($users, $logists->pluck('id')->toArray());
//        }

        $status_active = Status::getId(OrderStatus::ACTIVE);
        $status_planning = Status::getId(OrderStatus::PLANNING);
        $status_completed = Status::getId(OrderStatus::COMPLETED);
        $status_canceled = Status::getId(OrderStatus::CANCELED);
        $status_search = Status::getId(OrderStatus::SEARCH);

        $statuses = [$status_active, $status_planning, $status_completed, $status_canceled];

        $orders_completed_sum_old = 0;
        $orders_not_cancel_old = 0;
	    $orders_all_sum_old = 0;
	    $orders_all_old = 0;

        if (!isset($filters['dates_period'])) { //Default, 30 days
            $date_from = Carbon::now()->subDays(30)->startOfDay();
            $date_to   = Carbon::now();

            // previously period
            $diffInDays = $date_to->diffInDays($date_from);
            $date_from_old = Carbon::now()->subDays(30+$diffInDays)->startOfDay();
            $date_to_old = Carbon::now()->subDays($diffInDays)->startOfDay();

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
        }
        elseif (isset($filters['dates_period']) && $filters['dates_period'] != 0) { // Setting date
            $date_from = substr($filters['dates_period'], 0, strrpos($filters['dates_period'], "-"));
            $date_to = substr($filters['dates_period'], strrpos($filters['dates_period'], "-") + 1);
            $date_from = str_replace("/", "-", $date_from);
            $date_to = str_replace("/", "-", $date_to);

            $date_from = Carbon::parse($date_from);
            $date_to = Carbon::parse($date_to)->endOfDay();

            // previously period
            $diffInDays = $date_to->diffInDays($date_from);
            $date_from_old = Carbon::now()->subDays($diffInDays*2+1)->startOfDay();
            $date_to_old = Carbon::now()->subDays($diffInDays+1)->startOfDay();

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
        }
        else {  //All data - isset($filters['dates']) && $filters['dates'] == 0
            $date_from = false;
            $date_to = false;
        }

	    $orders_all_query = Order::query()->performerExecutor($users);
        $orders_active_query = Order::query()->performerExecutor($users)->where('current_status_id', $status_active);
        $orders_planning_query = Order::query()->performerExecutor($users)->where('current_status_id', $status_planning);
        $orders_completed_query = Order::query()->performerExecutor($users)->where('current_status_id', $status_completed);
        $orders_canceled_query = Order::query()->performerExecutor($users)->where('current_status_id', $status_canceled);
        $orders_search_query = Order::query()->performerExecutor($users)->where('current_status_id', $status_search);
        $orders_not_cancel_query = Order::query()->performerExecutor($users)->where('current_status_id', '!=' , $status_canceled);

        $countries_query = Order::query()
                ->select('addresses.country')
                ->leftJoin('order_addresses', 'orders.id', '=', 'order_addresses.order_id')
                ->leftJoin('addresses', 'addresses.id', '=', 'order_addresses.address_id')
	            ->performerExecutor($users)
                ->where('addresses.country', '<>', '')
                ->where('order_addresses.type', 'unloading')
//                ->groupBy('addresses.country')
                ->orderBy('country', 'desc');

        $orders_completed_during_query = Order::query()
            ->select('orders.id')
            ->leftJoin('order_addresses', 'orders.id', '=', 'order_addresses.order_id')
	        ->performerExecutor($users)
            ->where('order_addresses.type', 'unloading')
            ->where('order_addresses.date_at', function($query){
                $query->select(\DB::raw('max(date_at) from order_addresses as oa1 where oa1.order_id=orders.id'));
            })
            ->where('orders.current_status_id', $status_completed)
            ->whereColumn('orders.completed_at', '<=', 'order_addresses.date_at');


        if($date_from && $date_to){ // if date_from & date_to !== false

	        $orders_all_old_query = clone $orders_all_query;
	        $orders_not_cancel_old_query = clone $orders_not_cancel_query;

	        $orders_all_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_active_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_planning_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_completed_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_canceled_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_search_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_not_cancel_query->whereBetween('created_at', [$date_from, $date_to]);

	        $orders_all_old_query->whereBetween('created_at', [$date_from_old, $date_to_old]);
	        $orders_not_cancel_old_query->whereBetween('created_at', [$date_from_old, $date_to_old]);

            $countries_query->whereBetween('orders.created_at', [$date_from, $date_to]);
            $orders_completed_during_query->whereBetween('orders.created_at', [$date_from, $date_to]);
//            $addresses_query->whereBetween('created_at', [$date_from, $date_to]);

	        $orders_all_old_result = $orders_all_old_query->get();

	        $orders_all_sum_old = 0;
	        foreach($orders_all_old_result as $item){
		        if($item->performers->isNotEmpty()){
			        $orders_all_sum_old += $item->performers->first()->amount_plan;
		        }
	        }

	        $orders_all_old = $orders_all_old_result->count();
        }

	    $orders_all = $orders_all_query->count();
        $orders_active = $orders_active_query->count();
        $orders_planning = $orders_planning_query->count();
        $orders_completed = $orders_completed_query->count();
        $orders_canceled = $orders_canceled_query->count();
        $orders_search = $orders_search_query->count();

        $orders_not_cancel = $orders_not_cancel_query->count();

	    $orders_all_sum_result = $orders_all_query->get();

        $orders_all_sum = 0;
        foreach($orders_all_sum_result as $item){
            if($item->performers->isNotEmpty()){
	            $orders_all_sum += $item->performers->first()->amount_plan;
            }
        }

        $stat_distance = $analyticService->getAnalytics($data, [\App\Enums\AnalyticsType::DRIVER, \App\Enums\AnalyticsType::DRIVER_UPDATE, AnalyticsType::ORDER, AnalyticsType::ORDER_UPDATE]);

        $stat['distance_full'] = $stat_distance['distance'];
        $stat['distance_empty'] = $stat_distance['distance_empty'];
        $stat['duration'] = gmdate('H:i:s', $stat_distance['duration']);

        $countries = $countries_query->get();

        if ($countries->count()>0) {

            $cities_query = Order::query()
                    ->select('addresses.city')
                    ->leftJoin('order_addresses', 'orders.id', '=', 'order_addresses.order_id')
                    ->leftJoin('addresses', 'addresses.id', '=', 'order_addresses.address_id')
	                ->where('order_addresses.type', 'unloading');

            if($date_from && $date_to){ // if date_from & date_to !== false
                $cities_query->whereBetween('orders.created_at', [$date_from, $date_to]);
            }

            $cities = $cities_query->whereIn('orders.user_id', $users)
                    ->where('addresses.country', '=', $filters['country'] ?? $countries->first()->country)
                    ->where('addresses.city', '<>', '')
                    ->orderBy('city')
                    ->get();
        }
        else {
            $cities         = [];
        }

        $country_filter = [];

        $orders_completed_during = $orders_completed_during_query->get();

//        $addresses = $addresses_query->get();

        // Аналитика по странам

        $country = [];

        foreach ($countries as $address) {
            $country[] = $address['country'];
        }

        $total_country = count($country);

        if($total_country > 0){
            $country_filter  = array_unique($country);
        }

        $country_count = [];

        foreach ($countries as $country_item) {

            $country_count[$country_item['country']] = count(array_keys($country, $country_item['country'])) / $total_country * 100;
        }

        arsort($country_count);

        $i           = 1;
        $sum         = 0;
        $out_country = [];

        foreach ($country_count as $item => $reit) {

            if ($i <= 5) {
                $out_country[$item] = $reit;
                $sum               += $reit;
            } else {
                break;
            }

            $i++;
        }
            // Нулевой Other не выводим
            if ($sum !== 100) {
                $out_city[trans('all.other_all')] = 100 - $sum;
            }

        $country_count = $out_country;

        $orders_chart[] = $orders_active;
        $orders_chart[] = $orders_planning;
        $orders_chart[] = $orders_completed;
        $orders_chart[] = $orders_canceled;

//        $total_new[] = $orders_not_cancel;
//        $total_new[] = ($orders_not_cancel >= $orders_not_cancel_old) ? 1 : 0;
//        $total_new[] = (int) ceil((($orders_not_cancel - $orders_not_cancel_old) / ($orders_not_cancel_old ? $orders_not_cancel_old : 1)) * 100);

	    $total_new[] = $orders_all;
	    $total_new[] = ($orders_all >= $orders_all_old) ? 1 : 0;
	    $total_new[] = (int) ceil((($orders_not_cancel - $orders_not_cancel_old) / ($orders_all_old ? $orders_all_old : 1)) * 100);

        $total_sum[] = $orders_all_sum;
        $total_sum[] = ($orders_all_sum >= $orders_all_sum_old) ? 1 : 0;
        $total_sum[] = (int) ceil((($orders_all_sum - $orders_all_sum_old) / ($orders_all_sum_old ? $orders_all_sum_old : 1)) * 100);

        // Аналитика по транспорту
        $counts = \DB::select(\DB::raw("SELECT count(*) as count FROM transports WHERE user_id=$user->id AND status_id <> 8 AND deleted_at IS NULL AND type_id = 2"));
        foreach ($counts as $count) {
            $transport_count[] = $count->count; // Всего
        }

        $counts = \DB::select(\DB::raw("SELECT count(*) as count FROM transports WHERE user_id=$user->id AND status_id = 6 AND deleted_at IS NULL AND type_id = 2"));
//        dd($counts);
        foreach ($counts as $count) {
            $transport_count[] = $count->count; // Всего
        }

        $counts = \DB::select(\DB::raw("SELECT count(*) as count FROM transports WHERE user_id=$user->id AND status_id = 13 AND deleted_at IS NULL AND type_id = 2"));
        foreach ($counts as $count) {
            $transport_count[] = $count->count; // Всего
        }
        $counts = \DB::select(\DB::raw("SELECT count(*) as count FROM transports WHERE user_id=$user->id AND status_id = 7 AND deleted_at IS NULL AND type_id = 2"));
        foreach ($counts as $count) {
            $transport_count[] = $count->count; // Всего
        }

        // Аналитика по городам внутри страны

        $cities_country = [];

        if (!empty($cities)) {
            foreach ($cities as $city) {

                if ($city['city'] === '')
                    continue;
                $cities_country[] = $city['city'];
            }

            $total_cities = count($cities_country);

            $cities_list  = array_unique($cities_country);
            $cities_count = [];

            foreach ($cities_list as $city_item) {

                $cities_count[$city_item] = (int) ceil(count(array_keys($cities_country, $city_item)) / $total_cities * 100);
            }

            arsort($cities_count);

            $i        = 1;
            $sum      = 0;
            $out_city = [];

            foreach ($cities_count as $item => $reit) {

                if ($i <= 5) {
                    $out_city[$item] = $reit;
                    $sum             += (int) $reit;
                } else {
                    break;
                }

                $i++;
            }

            // Нулевой Other не выводим
            if ($sum !== 100) {
                $out_city[trans('all.other_all')] = 100 - $sum;
            }

            $city_count = $out_city;
        } else {
            $city_count = [];
        }

        // [--- import PDF ---]
        if ($request->get('download') !== null && $request->get('download') == 'pdf') {

	        $pdf = \App::make('dompdf.wrapper');
	        $pdf->loadHTML(view('analytics.partials._companies', compact('city_count', 'user', 'country_filter', 'orders_completed_during', 'transport_count', 'filters', 'total_new', 'total_sum', 'orders_chart', 'country_count', 'stat'))->render());
	        return $pdf->stream();

//            $pdf = \PDF::loadView('analytics.partials._companies',compact('city_count', 'user', 'country_filter', 'orders_completed_during', 'transport_count', 'filters', 'total_new', 'total_sum', 'orders_chart', 'country_count', 'stat'));
//            return $pdf->stream();
        }

        // [--- import EXCEL ---]
        if ($request->get('download') !== null && $request->get('download') == 'excel') {
            return Excel::download(new AnalyticsCompaniesExport($analyticService), 'analytics_companies.xlsx');
        }

        return view('analytics.companies', compact('city_count', 'user', 'country_filter', 'orders_completed_during', 'transport_count', 'filters', 'total_new', 'total_sum', 'orders_chart', 'country_count', 'stat'));
    }

    public function deals(Request $request){
        $user = \Auth::user();

        $this->filters = $request->filters;
        $this->filters['orders']       = true;
        $this->filters['relationships'] = true;//Eager Loading
        $filters = $this->filters;

        // Get orders
        $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);
        $statuses = Status::getOrders();

        // [--- import PDF ---]
        if ($request->get('download') !== null && $request->get('download') == 'pdf' && checkPaymentAccess('analytics_deal')) {
            $pdf = \PDF::loadView('analytics.partials._deals', compact('user', 'orders', 'type', 'filters', 'statuses', 'specializations'));
            return $pdf->stream();
        }

        // [--- import EXCEL ---]
        if ($request->get('download') !== null && $request->get('download') == 'excel' && checkPaymentAccess('analytics_deal')) {
            return Excel::download(new AnalyticsDealsExport(), 'analytics_deals.xlsx');
        }

        return view('analytics.deals', compact('user', 'orders', 'filters', 'statuses'));

    }

    public function logistics(Request $request) {

	    $user = auth()->user();

	    // search users
        if ($request->ajax()) {

            $name = $request->get('filters');

			$role_id = \App\Models\Role::getRoleIdByName(\App\Enums\UserRoleEnums::LOGIST);

            $logists = User::query()->select('id', 'name')
                    ->where('name', 'like', '%' . ($name['name'] ? $name['name'] : '') . '%')
	                ->where('parent_id', $user->isAdmin() ? $user->parent_id : $user->id)
		            ->whereHas('role', function($q) use($role_id) {
			            $q->where('role_id', $role_id);
		            })
                    ->get();

	        $logists_list = $logists->mapWithKeys(function ($item) {
		        return [$item['id'] => $item['name']];
	        });

	        return response()->json($logists_list);
        }

        $user_logist = null;

        if ($request->filters['userid']) {

			$role_id = \App\Models\Role::getRoleIdByName(\App\Enums\UserRoleEnums::LOGIST);

			$user_logist = User::query()->where('id', $request->filters['userid'])
                ->where('parent_id', $user->isAdmin() ? $user->parent_id : $user->id)
				->whereHas('role', function($q) use($role_id) {
					$q->where('role_id', $role_id);
})
                ->first();
        }

        // Adds filters
        $this->filters                  = $request->get('filters');
        $this->filters['orders']        = $user_logist ? $user_logist->id : true;
        $this->filters['relationships'] = true;//Eager Loading

	    $filters = $this->filters;

	    $user_query = $user_logist ? $user_logist->id : $user->id;

	    $status_active = Status::getId(OrderStatus::ACTIVE);
	    $status_planning = Status::getId(OrderStatus::PLANNING);
	    $status_completed = Status::getId(OrderStatus::COMPLETED);
	    $status_canceled = Status::getId(OrderStatus::CANCELED);
	    $status_search = Status::getId(OrderStatus::SEARCH);

	    $statuses = [$status_active, $status_planning, $status_completed, $status_canceled];

	    $orders_completed_sum_old = 0;
	    $orders_not_cancel_old = 0;
	    $orders_all_sum_old = 0;
	    $orders_all_old = 0;

	    if (!isset($filters['dates_period'])) { //Default, 30 days
		    $date_from = Carbon::now()->subDays(30)->startOfDay();
		    $date_to   = Carbon::now();

		    // previously period
		    $diffInDays = $date_to->diffInDays($date_from);
		    $date_from_old = Carbon::now()->subDays(30+$diffInDays)->startOfDay();
		    $date_to_old = Carbon::now()->subDays($diffInDays)->startOfDay();

		    $data['date_from'] = $date_from;
		    $data['date_to'] = $date_to;
	    }
	    elseif (isset($filters['dates_period']) && $filters['dates_period'] != 0) { // Setting date
		    $date_from = substr($filters['dates_period'], 0, strrpos($filters['dates_period'], "-"));
		    $date_to = substr($filters['dates_period'], strrpos($filters['dates_period'], "-") + 1);
		    $date_from = str_replace("/", "-", $date_from);
		    $date_to = str_replace("/", "-", $date_to);

		    $date_from = Carbon::parse($date_from);
		    $date_to = Carbon::parse($date_to)->endOfDay();

		    // previously period
		    $diffInDays = $date_to->diffInDays($date_from);
		    $date_from_old = Carbon::now()->subDays($diffInDays*2+1)->startOfDay();
		    $date_to_old = Carbon::now()->subDays($diffInDays+1)->startOfDay();

		    $data['date_from'] = $date_from;
		    $data['date_to'] = $date_to;
	    }
	    else {  //All data - isset($filters['dates']) && $filters['dates'] == 0
		    $date_from = false;
		    $date_to = false;
	    }

	    $orders_all_query = Order::query()->performerExecutor([$user_query]);
	    $orders_active_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', $status_active);
	    $orders_planning_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', $status_planning);
	    $orders_completed_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', $status_completed);
	    $orders_canceled_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', $status_canceled);
	    $orders_search_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', $status_search);
	    $orders_not_cancel_query = Order::query()->performerExecutor([$user_query])->where('current_status_id', '!=' , $status_canceled);

	    if($date_from && $date_to){ // if date_from & date_to !== false

		    $orders_all_old_query = clone $orders_all_query;
		    $orders_not_cancel_old_query = clone $orders_not_cancel_query;

		    $orders_all_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_active_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_planning_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_completed_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_canceled_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_search_query->whereBetween('created_at', [$date_from, $date_to]);
		    $orders_not_cancel_query->whereBetween('created_at', [$date_from, $date_to]);

		    $orders_all_old_query->whereBetween('created_at', [$date_from_old, $date_to_old]);
		    $orders_not_cancel_old_query->whereBetween('created_at', [$date_from_old, $date_to_old]);


		    $orders_all_old_result = $orders_all_old_query->get();

		    $orders_all_sum_old = 0;
		    foreach($orders_all_old_result as $item){
			    if($item->performers->isNotEmpty()){
				    $orders_all_sum_old += $item->performers->first()->amount_plan;
			    }
		    }

		    $orders_all_old = $orders_all_old_result->count();
	    }

	    $orders_all = $orders_all_query->count();
	    $orders_active = $orders_active_query->count();
	    $orders_planning = $orders_planning_query->count();
	    $orders_completed = $orders_completed_query->count();
	    $orders_canceled = $orders_canceled_query->count();
	    $orders_search = $orders_search_query->count();

	    $orders_not_cancel = $orders_not_cancel_query->count();

	    $orders_all_sum_query = clone $orders_all_query;
	    $orders_all_sum_result = $orders_all_sum_query->get();

	    $orders_all_sum = 0;
	    foreach($orders_all_sum_result as $item){
		    if($item->performers->isNotEmpty()){
			    $orders_all_sum += $item->performers->first()->amount_plan;
		    }
	    }

	    $orders_chart[] = $orders_active;
	    $orders_chart[] = $orders_planning;
	    $orders_chart[] = $orders_completed;
	    $orders_chart[] = $orders_canceled;

	    $total_new[] = $orders_all;
	    $total_new[] = ($orders_all >= $orders_all_old) ? 1 : 0;
	    $total_new[] = (int) ceil((($orders_not_cancel - $orders_not_cancel_old) / ($orders_all_old ? $orders_all_old : 1)) * 100);

	    $total_sum[] = $orders_all_sum;
	    $total_sum[] = ($orders_all_sum >= $orders_all_sum_old) ? 1 : 0;
	    $total_sum[] = (int) ceil((($orders_all_sum - $orders_all_sum_old) / ($orders_all_sum_old ? $orders_all_sum_old : 1)) * 100);

        // Get orders
//        $orders  = OrderSearch::apply($this->filters)->latest()->paginate(10);
        $orders  = $orders_all_query->latest()->paginate(10);
        $transport_count = TransportService::getTransports()->count();

        // [--- import PDF ---]
        if ($request->get('download') !== null && $request->get('download') == 'pdf' && checkPaymentAccess('analytics_logist')) {
            $pdf = \PDF::loadView('analytics.partials._logistics',compact('transport_count','filters', 'user','total_new', 'total_sum', 'orders_chart', 'orders'));
            return $pdf->stream();
        }

        // [--- import EXCEL ---]
        if ($request->get('download') !== null && $request->get('download') == 'excel' && checkPaymentAccess('analytics_logist')) {
            return Excel::download(new AnalyticsLogisticsExport(), 'analytics_logist.xlsx');
        }

        return view('analytics.logistics', compact('transport_count','filters', 'user','total_new', 'total_sum', 'orders_chart', 'orders'));
    }

    public function clients(Request $request) {
        return view('analytics.clients');
    }

    public function finances(Request $request){
	    return view('analytics.finances');
    }

//    public function analytics(Request $request){
////        if(!app_has_access('orders.all'))
////            return redirect()->to('/profile');
//
//        $user = \Auth::user();
//        $type = $request->input('filters.type') == 'requests'
//            ? 'requests'
//            : $request->get('role');
//        // Adds filters
//        $this->filters                  = $request->get('filters');
//        $this->filters[$type]           = true;
//        $this->filters['relationships'] = true;//Eager Loading
//        if ($type == 'requests') {
//            $this->filters['delay'] = true;
//        }
//        $filters = $this->filters;
//        // Get orders
//        $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);
//        // Get unread notifications
//        $notifications = $user->unreadNotifications->reduce(function ($carry, $item) {
//                if ($item->type == 'App\Notifications\NewRequest')
//                    $carry['order_' . $item->data['order_id']] = $item->id;
//
//                return $carry;
//            }) ?? array();
//        $statuses        = Status::getOrders();
//        $specializations = SpecializationController::get();
//
//
////            $view = view('analytics.index', compact('user', 'orders', 'type', 'filters', 'notifications', 'statuses', 'specializations'))->render();
////            return response()->json(['status' => 'ok', 'html' => $view]);
//
//        return view('analytics.companies', compact('user', 'orders', 'type', 'filters', 'notifications', 'statuses', 'specializations'));
//
//    }
}
