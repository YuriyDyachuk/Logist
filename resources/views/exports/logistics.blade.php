@extends('layouts.pdf')
@section('content')
    <div class="content-box analytics-page">
        <div class="container-fluid">
            <div class="content-box__row box-wrap">
                <table class="table table-orders">
                    <thead>
                    <tr>
                        <th><b>{{ trans('all.quantity_of_new_deals') }}</b></th>&nbsp;<td>{{$total_new[0]}}</td>
                        <th><b>{{ trans('all.quantity_agreed_contracts') }}</b></th>&nbsp;<td>0</td>
                        <th><b>{{ trans('all.quantity_of_own_transport') }}</b></th>&nbsp;<td>{{$transport_count}}</td>
                    </tr>
                    <tr>
                        <th><b>{{ trans('all.cost_of_all_transactions') }}</b></th>&nbsp;<td>{{$total_sum[0]}}</td>
                        <th><b>{{ trans('all.expenses_for_all_transactions') }}</b></th>&nbsp;<td>0</td>
                        <th><b>{{ trans('all.quantity_of_partner_transport') }}</b></th>&nbsp;<td>0</td>
                    </tr>
                    <tr>
                        <th><b>{{ trans('all.profitability_of_the_transaction') }}</b></th>&nbsp;<td>0</td>
                        <th><b>{{ trans('all.manager_commission') }}</b></th>&nbsp;<td>0</td>
                        <th><b>{{ trans('all.total_number_of_transport') }}</b></th>&nbsp;<td>{{$transport_count}}</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="container-fluid table-analytics__wrapper">
            <div class="row">
                <!-- Mobile desktop -->
                <div class="tab-content content-wrap">
                    <div class="tab-pane-active">
                        <div class="ordersBox">
                            <div class="content-box__row box-wrap">
                                <table class="table table-orders">
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
                                                <div class="name_status">
                                                    <span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="analytics_status_wrapper">
                                                    {{--                                    <span class="analytics_status analytics_status__{{ $status->name }}">--}}
                                                    {{--                                                {{ trans('all.status_' . $status->name ) }}--}}
                                                    {{--                                    </span>--}}
                                                    <span class="marker-{{ $status->name }} marker-status transition">
                                                            {{ trans('all.status_' . $status->name ) }}
                                                        </span>
                                                </div>
                                            </td>
                                            <td> {{$user->name}} </td>
                                            <td>{{ trans('handbook.' . $order->getCategoryName()) }}</td>
                                            <td> {{ $user->name}} </td>
                                            <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
                                            <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
