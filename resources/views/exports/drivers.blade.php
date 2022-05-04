@extends('layouts.pdf')
@section('content')
    <div class="content-box analytics-page">

        <div class="container-fluid analytics-driver-page">
            <div class="row">
                <div class="col-xs-12 col-sm-6" id="col-1">
                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.drivers_work_measurements') }}</h2></div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km') }}</div>
                                <div class="col-sm-4 value-col"><span class="value distance"><span
                                                id="parameter_distance">{{$stat['distance']}}</span> {{trans('all.km')}}</span>
                                    <span class="plus"><button type="button" class="btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_distance"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km_empty') }}</div>
                                <div class="col-sm-4 value-col"><span class="value distance"><span
                                                id="parameter_distance_empty">{{$stat['distance_empty']}}</span> {{trans('all.km')}}</span>
                                    <span class="plus"><button type="button" class=" btn-append" data-toggle="modal"
                                                               data-target="#innlogist-modal"
                                                               data-type="parameter_distance_empty"><span
                                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_spent_fuel') }}</div>
                                <div class="col-sm-4 value-col"><span class="value liter"><span
                                                id="parameter_fuel">{{$stat['fuel']}}</span> {{trans('all.liter')}}</span>
                                    <span class="plus"><button type="button" class="btn-append" data-toggle="modal"
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
                                <div class="col-sm-4 value-col"><span class="value">{{$count_orders}}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.work_efficiency') }}</h2>
                                </div>
                            </div>
                            <div class="row workstat-graph">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    {{--                                    <canvas id="chart1"></canvas>--}}
                                </div>
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
                {{--                <div class="col-xs-12 col-sm-6 testimonail" id="col-2">--}}
                {{--                    <div class="row">--}}
                {{--                        <div class="col-sm-7">--}}
                {{--                            <h2 class="title-block">{{ trans('all.testimonials') }}</h2>--}}
                {{--                        </div>--}}
                {{--                        <div class="col-sm-4 testimonail-rating">--}}
                {{--                            @if($testimonials->count() != 0)--}}
                {{--                                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 1) checked @endif" aria-hidden="true"></span>--}}
                {{--                                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 2) checked @endif" aria-hidden="true"></span>--}}
                {{--                                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 3) checked @endif" aria-hidden="true"></span>--}}
                {{--                                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 4) checked @endif" aria-hidden="true"></span>--}}
                {{--                                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 5) checked @endif" aria-hidden="true"></span>--}}
                {{--                            @endif--}}
                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                    <div class="row" id="testimonial_wrapper">--}}
                {{--                        @include('analytics.includes.testimonial-comments')--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>


            <div class="modal fade" id="innlogist-modal" tabindex="-1" role="dialog"
                 aria-labelledby="innlogist-modalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-group">
                            <input type="hidden" id="parameter_type" name="type" value="">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="var">{{ trans('all.value') }}</label>
                                    <input type="text" class="form-control" id="parameter_value" placeholder="">
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label for="comment">{{ trans('all.comment') }}</label>
                                    <input type="text" class="form-control" id="comment" placeholder="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="content-box__filter" id="content-box__forms">--}}
        {{--<form method="POST" action="" id="formFilters">--}}
        {{-- HIDDEN --}}
        {{--<input type="hidden" name="filters[type]" value="orders">--}}

        {{--<div class="content-box__filter-date pull-right">--}}
        {{--<label for="date" class="h5 title-grey">{{ trans('all.date') }}:</label>--}}
        {{--<input type="text" name="filters[dates]" class="inputDaterangepicker" value="" onblur="">--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--<div class="clearfix"></div>--}}
        {{--</div>--}}

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
                                        <th><b>{{ trans('all.driver') }}</b></th>
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
                                                <div class="name_status"><span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                                                </div>
                                            </td>
                                            <td>
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