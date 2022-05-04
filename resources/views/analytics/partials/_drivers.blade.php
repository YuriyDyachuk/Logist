{{--@extends('layouts.pdf')--}}
@extends('pdf.layouts.pdf')
@section('content')
<div class="analytics-pdf">
    <table>
        <tbody>
        <tr>
            <td style="width: 60%;">
                <div class="title-block">{{ trans('all.drivers_work_measurements') }}</div>
                <table>
                    <tbody>
                    <tr>
                        <td>{{ trans('all.quantity_of_passed_km') }}</td>
                        <td>{{$stat['distance']}} {{trans('all.km')}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.quantity_of_passed_km_empty') }}</td>
                        <td>{{$stat['distance_empty']}} {{trans('all.km')}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.quantity_of_spent_fuel') }}</td>
                        <td>{{$stat['fuel']}} {{trans('all.liter')}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.total_expenses_on_the_way') }}</td>
                        <td>{{$stat['amount']}} {{trans('all.UAH')}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.quantity_of_orders') }}</td>
                        <td>{{$count_orders}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.on_time') }}</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.out_of_time') }}</td>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 40%;">
                <div class="title-block" style="margin-bottom: 140px;">{{ trans('all.work_efficiency') }}</div>
                <img src="https://quickchart.io/chart?width=350&height=350&c={type:'doughnut',data:{datasets:[{data: [1,99]}]},options:{elements: {center: {text: '99% {{ trans('all.on_time') }}'}}}}">
                {{--
                <table class="table table__legend">
                    <tbody>
                    <tr>
                        <td>{{ trans('all.on_time') }}</td>
                        <td><span class="grey">0</span></td>
                    </tr>
                    <tr>
                        <td>{{ trans('all.out_of_time') }}</td>
                        <td><span class="grey">0</span></td>
                    </tr>
                    </tbody>
                </table>
                --}}
            </td>
        </tr>
        </tbody>
    </table>
</div>



    <div class="content-box analytics-page">

        <div class="container-fluid analytics-driver-page">
            <div class="row">
                {{--
                <div class="col-xs-6">
                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.drivers_work_measurements') }}</h2></div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km') }}</div>
                                <div class="col-sm-4 value-col"><span class="value distance" style="margin-top: -21px"><span
                                                id="parameter_distance">{{$stat['distance']}}</span> {{trans('all.km')}}</span>
                                    <span class="plus" style="margin-top: -21px"><button type="button" class="btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_distance"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km_empty') }}</div>
                                <div class="col-sm-4 value-col"><span class="value distance" style="margin-top: -21px"><span
                                                id="parameter_distance_empty">{{$stat['distance_empty']}}</span> {{trans('all.km')}}</span>
                                    <span class="plus" style="margin-top: -21px"><button type="button" class=" btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_distance_empty"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_spent_fuel') }}</div>
                                <div class="col-sm-4 value-col"><span class="value liter" style="margin-top: -21px"><span
                                                id="parameter_fuel">{{$stat['fuel']}}</span> {{trans('all.liter')}}</span>
                                    <span class="plus" style="margin-top: -21px"><button type="button" class="btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_fuel"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row" style="display: none;">
                                <div class="col-sm-8 title-col">{{ trans('all.total_expenses_on_the_way') }}</div>
                                <div class="col-sm-4 value-col"><span class="value money_value"><span
                                                id="parameter_amount">{{$stat['amount']}}</span> {{trans('all.UAH')}}</span>
                                    <span class="plus"><button type="button" class="btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_amount"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row" style="display: none;">
                                <div class="col-sm-8 title-col">{{ trans('all.time_of_search_drivers') }}</div>
                                <div class="col-sm-4 value-col"><span class="value hours grey">0 H</span></div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_orders') }}</div>
                                <div class="col-sm-4 value-col"><span class="value" style="margin-top: -21px">{{$count_orders}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.work_efficiency') }}</h2>
                                </div>
                            </div>
                            <div class="row workstat-graph">
                                <div class="col-xs-6 col-sm-12 col-md-8">

                                </div>
                                <div class="col-xs-6" style="margin-top: 45px">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <table class="table table__legend">
                                            <tbody>
                                            <tr>
                                                <td>{{ trans('all.on_time') }}</td>
                                                <td><span class="grey">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('all.out_of_time') }}</td>
                                                <td><span class="grey">0</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                --}}
            </div>
        </div>


        <table class="table table-orders">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('all.date_of_deal') }}</th>
                <th>{{ trans('all.name_and_status') }}</th>
                <th>{{ trans('all.customer') }}</th>
                <th>{{ trans('all.transport') }}</th>
                <th>{{ trans('all.driver') }}</th>
                <th>{{ trans('all.sum') }}</th>
                <th>{{ trans('all.profitability') }}</th>
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
                        <div class="name_status"><span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                        </div>
                        <div class="analytics_status_wrapper">
                            {{--                                    <span class="analytics_status analytics_status__{{ $status->name }}">--}}
                            {{--                                        {{ trans('all.status_' . $status->name ) }}--}}
                            {{--                                    </span>--}}
                            <span class="marker-{{ $status->name }} marker-status transition">
                                    {{ trans('all.status_' . $status->name ) }}
                                </span>
                        </div>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ trans('handbook.' . $order->getCategoryName()) }}</td>
                    <td>{{ $order->usersname ?? ''}}</td>
                    <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
                    <td>{{ number_format($order->amount_plan, 2, '.', '') }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
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
                                        <th>{{ trans('all.driver') }}</th>
                                        <th>{{ trans('all.sum') }}</th>
                                        <th>{{ trans('all.profitability') }}</th>
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
                                                <div class="name_status"><span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                                                </div>
                                                <div class="analytics_status_wrapper">
                                                    {{--                                    <span class="analytics_status analytics_status__{{ $status->name }}">--}}
                                                    {{--                                        {{ trans('all.status_' . $status->name ) }}--}}
                                                    {{--                                    </span>--}}
                                                    <span class="marker-{{ $status->name }} marker-status transition">
                                    {{ trans('all.status_' . $status->name ) }}
                                </span>
                                                </div>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ trans('handbook.' . $order->getCategoryName()) }}</td>
                                            <td>{{ $order->usersname ?? ''}}</td>
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