<?php

namespace App\Exports;

use App\Enums\AnalyticsType;
use App\Enums\OrderStatus;
use App\Models\Order\Order;
use App\Models\Status;
use App\Services\AnalyticService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnalyticsCompaniesExport implements FromView
{
    /**
     * @var AnalyticService
     */
    private $analyticService;

    public function __construct(AnalyticService $analyticService)
    {
        $this->analyticService = $analyticService;
    }

    public function view(): View
    {
        // Adds filters
        $this->filters                  = request()->get('filters');
        $this->filters['relationships'] = true; //Eager Loading

        $filters = $this->filters;
        $user    = \Auth::user();

        $users = [$user->id];
        $logists = $user->getCompanyStaffByRoleName(\App\Enums\UserRoleEnums::LOGIST);

        $data = [];

        if($logists->isNotEmpty()){
            $users = array_merge($users, $logists->pluck('id')->toArray());
        }

        $status_active = Status::getId(OrderStatus::ACTIVE);
        $status_planning = Status::getId(OrderStatus::PLANNING);
        $status_completed = Status::getId(OrderStatus::COMPLETED);
        $status_canceled = Status::getId(OrderStatus::CANCELED);
        $status_search = Status::getId(OrderStatus::SEARCH);

        $statuses = [$status_active, $status_planning, $status_completed, $status_canceled];

        $orders_completed_sum_old = 0;
        $orders_not_cancel_old = 0;

        if (!isset($filters['dates'])) { //Default, 30 days
            $date_from = Carbon::now()->subDays(30)->startOfDay();
            $date_to   = Carbon::now();

            // previously period
            $diffInDays = $date_to->diffInDays($date_from);
            $date_from_old = Carbon::now()->subDays(30+$diffInDays)->startOfDay();
            $date_to_old = Carbon::now()->subDays($diffInDays)->startOfDay();

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
        }
        elseif (isset($filters['dates']) && $filters['dates'] != 0) { // Setting date
            $date_from = substr($filters['dates'], 0, strrpos($filters['dates'], "-"));
            $date_to = substr($filters['dates'], strrpos($filters['dates'], "-") + 1);
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

        $user_id_owner = ($user->parent_id == 0) ? $user->id : $user->parent_id;
//        $stat_distance_full_query = Analytics::where('user_id', $user_id_owner)->whereIn('type', [AnalyticsType::ORDER, AnalyticsType::ORDER_UPDATE]);
//        $stat_distance_empty_query = Analytics::where('user_id', $user_id_owner)->whereIn('type', [AnalyticsType::ORDER, AnalyticsType::ORDER_UPDATE]);

//        $addresses_query = Address::query()->orderBy('id');

        if($date_from && $date_to){ // if date_from & date_to !== false
            $orders_active_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_planning_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_completed_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_canceled_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_search_query->whereBetween('created_at', [$date_from, $date_to]);
            $orders_not_cancel_query->whereBetween('created_at', [$date_from, $date_to]);

            $countries_query->whereBetween('orders.created_at', [$date_from, $date_to]);
            $orders_completed_during_query->whereBetween('orders.created_at', [$date_from, $date_to]);
//            $addresses_query->whereBetween('created_at', [$date_from, $date_to]);

//            $stat_distance_full_query->whereBetween('time', [$date_from, $date_to]);
//            $stat_distance_empty_query->whereBetween('time', [$date_from, $date_to]);

            $orders_completed_sum_old = Order::query()
//                ->whereIn('user_id', $users)
                ->performerExecutor($users)
                ->whereBetween('created_at', [$date_from_old, $date_to_old])
                ->sum('amount_plan');

            $orders_not_cancel_old = Order::query()
//                ->whereIn('user_id', $users)
                ->performerExecutor($users)
                ->where('current_status_id', '!=', $status_canceled)
                ->whereBetween('created_at', [$date_from_old, $date_to_old])
                ->count();
        }

        $orders_active = $orders_active_query->count();
        $orders_planning = $orders_planning_query->count();
        $orders_completed = $orders_completed_query->count();
        $orders_canceled = $orders_canceled_query->count();
        $orders_search = $orders_search_query->count();

        $orders_not_cancel = $orders_not_cancel_query->count();

        $order_completed_sum_result = $orders_completed_query->with(['performers' => function($query) use ($users){
            $query->whereIn('user_id', $users)->limit(1);
        }])->get();

        $order_completed_sum = 0;
        foreach($order_completed_sum_result as $item){
            if($item->performers->isNotEmpty()){
                $order_completed_sum += $item->performers->first()->amount_plan;
            }
        }

//        $order_completed_sum = $orders_completed_query->sum('amount_plan');
        $stat_distance = $this->analyticService->getAnalytics($data, [\App\Enums\AnalyticsType::DRIVER, \App\Enums\AnalyticsType::DRIVER_UPDATE, AnalyticsType::ORDER, AnalyticsType::ORDER_UPDATE]);

//        $stat['distance_full'] = $stat_distance_full_query->sum('distance');
        $stat['distance_full'] = $stat_distance['distance'];
//        $stat['distance_empty'] = $stat_distance_empty_query->sum('distance_empty');
        $stat['distance_empty'] = $stat_distance['distance_empty'];
//        $stat['duration'] = gmdate('H:i:s', $stat_distance_empty_query->sum('duration'));
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
            $out_city['Other'] = 100 - $sum;
        }

        $country_count = $out_country;

        $orders_chart[] = $orders_active;
        $orders_chart[] = $orders_planning;
        $orders_chart[] = $orders_completed;
        $orders_chart[] = $orders_canceled;

        $total_new[] = $orders_not_cancel;
        $total_new[] = ($orders_not_cancel >= $orders_not_cancel) ? 1 : 0;
        $total_new[] = (int) ceil((($orders_not_cancel - $orders_not_cancel_old) / ($orders_not_cancel_old ? $orders_not_cancel_old : 1)) * 100);

        $total_sum[] = $order_completed_sum;
        $total_sum[] = ($order_completed_sum >= $orders_completed_sum_old) ? 1 : 0;
        $total_sum[] = (int) ceil((($order_completed_sum - $orders_completed_sum_old) / ($orders_completed_sum_old ? $orders_completed_sum_old : 1)) * 100);

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
                $out_city['Other'] = 100 - $sum;
            }

            $city_count = $out_city;
        } else {
            $city_count = [];
        }

        return view('exports.companies', compact('city_count', 'user', 'country_filter', 'orders_completed_during', 'transport_count', 'filters', 'total_new', 'total_sum', 'orders_chart', 'country_count', 'stat'));
    }
}
