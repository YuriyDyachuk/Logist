<?php

namespace App\Exports;

use App\Models\Order\Order;
use App\Models\Order\OrderPerformer;
use App\Models\Transport\Testimonial;
use App\Services\AnalyticService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnalyticsDriversExport implements FromView
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
        $user = \Auth::user();

        $users = [$user->id];

        $logists = $user->getCompanyStaffByRoleName(\App\Enums\UserRoleEnums::LOGIST);

        if($logists->isNotEmpty()){
            $users = array_merge($users, $logists->pluck('id')->toArray());
        }

        if (request()->ajax() && !request()->has('action')) {

            $name = request()->get('filters');

            $drivers_list = [];

            $drivers = OrderPerformer::query()
                ->select('users.id', 'users.name')
                ->distinct()
                ->leftJoin('transports_drivers', 'transports_drivers.transport_id', '=', 'order_performers.transport_id')
                ->leftJoin('users', 'users.id', '=', 'transports_drivers.user_id')
                ->whereIn('order_performers.user_id', $users)
                ->where('users.name', 'like', '%' . ($name['name'] ? $name['name'] : '') . '%')
                ->where('users.name', '<>', '')
                ->orderBy('users.name')
                ->get();

            if ($drivers) {
                foreach ($drivers as $driver) {
                    $drivers_list[$driver['id']] = $driver['name'];
                }
            }

            return response()->json($drivers_list);
        }

        // Adds filters
        $this->filters = request()->get('filters');
        $this->filters['relationships'] = true; //Eager Loading

        $data = [];

        if(isset($filters['userid']) && $filters['userid'] != '') {
            $data['driver_id'] = $filters['userid'];
        };

        $filters = $this->filters;

        $testimonials_all_query = Testimonial::whereIn('company_id', $users)->whereNotNull('rating')->with('driver');
        $testimonials_query = Testimonial::whereIn('company_id', $users)->whereNotNull('comment')->with('driver');

        if (isset($filters['userid']) && $filters['userid'] != ''){
            $testimonials_all_query->where('driver_id', $filters['userid']);
            $testimonials_query->where('driver_id', $filters['userid']);
        }

        $testimonials_all = $testimonials_all_query->get();
        $testimonials = $testimonials_query->paginate(10);

        $testimonials_rating_count = $testimonials_all->count();
        $testimonials_rating_sum = $testimonials_all->sum('rating');

        if($testimonials_rating_count > 0){
            $testimonials_rating = (int)round($testimonials_rating_sum / $testimonials_rating_count);
        }
        else {
            $testimonials_rating = 0;
        }

        if (request()->ajax() && request()->has('action') && request()->action == 'testimonials') {
            $view = view('analytics.includes.testimonial-comments', compact('filters', 'testimonials'))->render();
            return response()->json(['status' => 'ok', 'html' => $view]);
        }

        $query = Order::query()
            ->with(['addresses', 'performers'])
            ->select('orders.*', 'users.id as usersid', 'users.name as usersname')
            ->leftJoin('order_performers', 'orders.id', '=', 'order_performers.order_id')
            ->leftJoin('transports_drivers', 'transports_drivers.transport_id', '=', 'order_performers.transport_id')
            ->leftJoin('users', 'users.id', '=', 'transports_drivers.user_id')
            ->whereIn('order_performers.user_id', $users);

        if (!isset($filters['dates_period'])) { //Default, 30 days
            $date_from = Carbon::now()->subDays(30)->startOfDay();
            $date_to = Carbon::now();

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
        }
        elseif(isset($filters['dates_period']) && $filters['dates_period'] != 0) { // Setting date
            $date_from = substr($filters['dates_period'], 0, strrpos($filters['dates_period'], "-"));
            $date_to = substr($filters['dates_period'], strrpos($filters['dates_period'], "-") + 1);

            $date_from = str_replace("/", "-", $date_from);
            $date_to = str_replace("/", "-", $date_to);

            $date_from = Carbon::parse($date_from)->startOfDay();
            $date_to = Carbon::parse($date_to)->endOfDay();

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
        }
        else {  //All data
            $date_from = false;
            $date_to = false;
        }

        // filter date
        if($date_from && $date_to){
            $query = $query->whereBetween('orders.created_at', [$date_from, $date_to]);
        }

        // filter driver
        if (isset($filters['userid']) && $filters['userid'] != ''){
            $query = $query->where('users.id', '=', $filters['userid']);
            $data['driver_id'] = $filters['userid'];
        }

        $count_orders = $query->count();

        $orders = $query->latest()->paginate(10);

        $stat = $this->analyticService->getAnalytics($data, [\App\Enums\AnalyticsType::DRIVER, \App\Enums\AnalyticsType::DRIVER_UPDATE]);

        return view('exports.drivers', compact('count_orders', 'filters', 'user', 'orders', 'stat', 'testimonials', 'testimonials_rating'));
    }
}
