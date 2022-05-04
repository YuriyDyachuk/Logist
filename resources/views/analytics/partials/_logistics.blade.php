@extends('layouts.pdf')
@section('content')
    <div class="content-box analytics-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4 col-sm-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-green">
                                <div class="value">{{$total_new[0]}}</div>
                                <div class="title-col">{{ trans('all.quantity_of_new_deals') }}</div>
                                @if($total_new[1] == 1)
                                    <div class="value-trend value-trend-green"><span
                                                class="glyphicon glyphicon-arrow-up"
                                                aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}
                                        %
                                    </div>
                                @else
                                    <div class="value-trend value-trend-red"><span
                                                class="glyphicon glyphicon-arrow-down"
                                                aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}
                                        %
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-red border-grey">
                                <div class="value grey">0</div>
                                <div class="title-col">{{ trans('all.quantity_agreed_contracts') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span
                                            class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                            class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-green">
                                <div class="value">&#8372; {{$total_sum[0]}}</div>
                                <div class="title-col">{{ trans('all.cost_of_all_transactions') }}</div>
                                @if($total_sum[1] == 1)
                                    <div class="value-trend value-trend-green"><span
                                                class="glyphicon glyphicon-arrow-up"
                                                aria-hidden="true"></span> {{($total_sum[2] < 100) ? $total_sum[2] : 100 }}
                                        %
                                    </div>
                                @else
                                    <div class="value-trend value-trend-red"><span
                                                class="glyphicon glyphicon-arrow-down"
                                                aria-hidden="true"></span> {{($total_sum[2] < 100) ? $total_sum[2] : 100 }}
                                        %
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.expenses_for_all_transactions') }}</div>
                                <div class="value-trend value-trend-green value-grey"><span
                                            class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> <span
                                            class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.profitability_of_the_transaction') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span
                                            class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                            class="grey">0</span></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.manager_commission') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span
                                            class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                            class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="workstat_block">
                        <div class="row workstat-row">
                            <div class="col-xs-9 col-sm-9 title-col">{{ trans('all.quantity_of_own_transport') }}</div>
                            <div class="col-xs-3 col-sm-2 value-col text-center">{{$transport_count}}</div>
                            <div class="hidden-xs col-sm-1"></div>
                        </div>
                        <div class="row workstat-row">
                            <div class="col-xs-9 col-sm-9 title-col">{{ trans('all.quantity_of_partner_transport') }}</div>
                            <div class="col-xs-3 col-sm-2 value-col text-center"><span class="grey">0</span></div>
                            <div class="hidden-xs col-sm-1"></div>
                        </div>
                        <div class="row workstat-row">
                            <div class="col-xs-9 col-sm-9 title-col">{{ trans('all.total_number_of_transport') }}</div>
                            <div class="col-xs-3 col-sm-2 value-col text-center">{{$transport_count}}</div>
                            <div class="hidden-xs col-sm-1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">

                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.transaction_measurement') }}</h2></div>
                            </div>
                            <div class="row workstat-graph">
                                <div class="col-sm-12">
{{--                                    <img src="https://quickchart.io/chart?width=530&height=200&c={type: 'doughnut',data: {labels: ['{{ trans('all.active') }}', '{{ trans('all.planned') }}', '{{ trans('all.completed') }}', '{{ trans('all.canceled') }}'],datasets: [{ data: [2,5,9,1] },]}}">--}}
                                    <img src="https://quickchart.io/chart?width=400&height=130&c={type: 'horizontalBar',data: {labels: ['{{ trans('all.active') }}', '{{ trans('all.planned') }}', '{{ trans('all.completed') }}', '{{ trans('all.canceled') }}'],datasets: [{data: [<?php echo implode(",",$orders_chart);?>] }]}}">
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.total_quantity_of_deals') }}</div>
                                <div class="col-sm-4 value-col"><span
                                            class="value value-grey">{{array_sum($orders_chart)}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <th>#</th>
                                        <th>{{ trans('all.date_of_deal') }}</th>
                                        <th>{{ trans('all.name_and_status') }}</th>
                                        <th>{{ trans('all.customer') }}</th>
                                        <th>{{ trans('all.transport') }}</th>
                                        <th>{{ trans('all.logist') }}</th>
                                        <th>{{ trans('all.sum') }}</th>
                                        <th>{{ trans('all.profitability') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
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
