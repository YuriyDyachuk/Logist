<?php

namespace App\Exports;

use App\Models\Order\Order;
use App\Models\Transport\Transport;
use App\Search\Order\OrderSearch;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;

class AnalyticsLogisticsExport implements FromView, WithEvents
{
    public function view(): View
    {
        $user = \Auth::user();

        $user_logistic = null;
        if (request()->filters['username']) {
            $user_logistic = $user/*->logistics()*/ ->hasRole(\App\Enums\UserRoleEnums::LOGIST)->where('name', 'like', '%' . (request()->filters['username'] ? request()->filters['username'] : '') . '%')
                ->first();
        }

        $type = request()->input('filters.type') == 'requests'
            ? 'requests'
            : request()->get('role');
        // Adds filters
        $this->filters = request()->get('filters');
        $this->filters[$type] = true;
        $this->filters['relationships'] = true;//Eager Loading

        if ($user_logistic) {
            $this->filters['userid'] = $user_logistic;
        } else {
            $this->filters['userid'] = $this->filters['userid'] ?? $user->id;
        }

        if ($type == 'requests') {
            $this->filters['delay'] = true;
        }
        $filters = $this->filters;

        if (isset($filters['dates']) && $filters['dates'] == '') {
            unset($filters['dates']);
        }

        $user_query = isset($filters['userid']) ? $filters['userid'] : $user->id;

        if (isset($filters['dates_period']) && $filters['dates_period'] == 0) { //All data

            $orders_active = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', 1)
                ->count();


            $orders_planning = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', 5)
                ->count();

            $orders_completed = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', 2)
                ->count();

            $orders_canceled = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', 3)
                ->count();

            $total_sum_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->sum('amount_plan');

            $total_new_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->count();

            $total_sum_old = 1;
            $total_new_old = 1;

        }

        if (isset($filters['dates_period']) && $filters['dates_period'] != 0) { // Setting date

            $date_from = substr($filters['dates_period'], 0, strrpos($filters['dates_period'], "-"));
            $date_to = substr($filters['dates_period'], strrpos($filters['dates_period'], "-") + 1);
            $date_from = str_replace("/", "-", $date_from);
            $date_to = str_replace("/", "-", $date_to);

            $date_from_main = Carbon::createFromFormat('d-m-Y', $date_from)->format('Y-m-d');

            $date_from = Carbon::parse($date_from)->startOfDay();
            $date_to = Carbon::parse($date_to);

            //dd($date_to);

            $orders_active = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->where('current_status_id', 1)
                ->count();


            $orders_planning = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->where('current_status_id', 5)
                ->count();

            $orders_completed = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->where('current_status_id', 2)
                ->count();

            $orders_canceled = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->where('current_status_id', 3)
                ->count();

            $total_sum_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->sum('amount_plan');

            $total_new_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->count();

            $old = $date_from->subDays($date_to->diffInDays($date_from));

            $total_sum_old = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [$old, $date_from_main])
                ->sum('amount_plan');

            $total_new_old = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', '!=', 3)
                ->whereBetween('created_at', [$old, $date_from_main])
                ->count();

        }

        if (!isset($filters['dates_period'])) { //Default, 30 days

            $orders_active = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->where('current_status_id', 1)
                ->count();


            $orders_planning = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->where('current_status_id', 5)
                ->count();

            $orders_completed = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->where('current_status_id', 2)
                ->count();

            $orders_canceled = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->where('current_status_id', 3)
                ->count();

            $total_sum_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->sum('amount_plan');

            $total_new_val = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()])
                ->count();

            $total_sum_old = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(60)->startOfDay(), Carbon::now()->subDays(30)->startOfDay()])
                ->sum('amount_plan');

            $total_new_old = Order::query()
                ->performerExecutor([$user_query])
//                    ->where('user_id', $filters['userid'] ?? $user->id)
                ->where('current_status_id', '!=', 3)
                ->whereBetween('created_at', [Carbon::now()->subDays(60)->startOfDay(), Carbon::now()->subDays(30)->startOfDay()])
                ->count();

        }

        $orders_chart[] = $orders_active;
        $orders_chart[] = $orders_planning;
        $orders_chart[] = $orders_completed;
        $orders_chart[] = $orders_canceled;

        $total_new[] = $total_new_val;
        $total_new[] = ($total_new_val > $total_new_old) ? 1 : 0;
        $total_new[] = (int)ceil((($total_new_val - $total_new_old) / ($total_new_old ? $total_new_old : 1)) * 100);

        $total_sum[] = $total_sum_val;
        $total_sum[] = ($total_sum_val > $total_sum_old) ? 1 : 0;
        $total_sum[] = (int)ceil((($total_sum_val - $total_sum_old) / ($total_sum_old ? $total_sum_old : 1)) * 100);

        // Get orders
        $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);

        $transport_count = Transport::query()
            ->where('user_id', $user->id)
            ->count();

        return view('exports.logistics', compact('transport_count', 'filters', 'user', 'total_new', 'total_sum', 'orders_chart', 'orders'));
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $columns = 'A';
                $columns2 = 'C';
                $columns1 = 'E';
                $event->sheet->getDelegate()->getColumnDimension($columns)->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension($columns2)->setWidth(27);
                $event->sheet->getDelegate()->getColumnDimension($columns1)->setWidth(37);

                // All headers - set font size to 13
                $cellRange = 'A1:D1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);

                // Apply array of styles to A1:F3 cell range
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ]
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A1:F3')->applyFromArray($styleArray);

            },
        ];
    }
}
