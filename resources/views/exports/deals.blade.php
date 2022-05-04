<table>
    <thead>
    <tr>
        <th><b>№</b></th>
        <th><b>{{ trans('all.date_of_deal') }}</b></th>
        <th><b>{{ trans('all.name_pdf') }}</b></th>
        <th><b>{{ trans('all.name_status_pdf') }}</b></th>
        <th><b>{{ trans('all.customer') }}</b></th>
        <th><b>{{ trans('all.transport') }}</b></th>
        <th><b>{{ trans('all.logist') }}</b></th>
        <th><b>{{ trans('all.sum') }}</b></th>
        <th><b>{{ trans('all.profitability') }}</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        @php
            $status = $order->getStatus();
        @endphp
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ \Carbon\Carbon::parse($order->addresses->first()->pivot->date_at)->format('d/m/y') }}</td>
            <td>
                <div>
                    <span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                </div>
            </td>
            <td>
                <div>
                    <span class="marker-{{ $status->name }} marker-status transition">
                        {{ trans('all.status_' . $status->name ) }}
                    </span>
                </div>
            </td>
            <td>
                @if($order->getPerformer())
                    {{$order->getPerformer()->creator->name}}
                @endif
            </td>
            <td>{{ trans('handbook.' . $order->getCategoryName()) }}</td>
            <td>
                @if($order->getPerformer())
                    {{$order->getPerformer()->executor->name}}
                @endif
            </td>
            <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
            <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
        </tr>
    @endforeach
    </tbody>

</table>