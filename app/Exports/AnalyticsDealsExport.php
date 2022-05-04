<?php

namespace App\Exports;

use App\Models\Status;
use App\Search\Order\OrderSearch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalyticsDealsExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        $user = \Auth::user();

        $this->filters = \request('filters');
        $this->filters['orders']       = true;
        $this->filters['relationships'] = true;//Eager Loading
        $filters = $this->filters;

        // Get orders
        $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);
        $statuses = Status::getOrders();

        return view('exports.deals', compact('user', 'orders', 'type', 'filters', 'statuses', 'specializations'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 100,
            'B' => 100,
        ];
    }
}
