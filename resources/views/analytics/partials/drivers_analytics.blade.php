<div class="content-box__filters filter-align__right">
    {{--  import pdf-excel  --}}
    <div class="form-analytics-import">
        <!-- Bootstrap 4 -->
        <div class="btn-group col-xs-2 flex-box-form wrap-import">
            <!-- Кнопка -->
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('all.analytics_import_all') }}
            </button>
            <!-- Меню -->
            <div class="dropdown-menu">
                <a class="dropdown-item col-xs-12 hidden" href="{!! url()->current().'?download=pdf' !!}" >{{ trans('all.analytics_pdf') }}</a>
                <a class="dropdown-item col-xs-12" href="{!! url()->current().'?download=excel' !!}">{{ trans('all.analytics_excel') }}</a>
            </div>
        </div>
    </div>

    {{--  Filters  --}}
    <form method="GET" action="" id="formFilters" class="/*form-inline*/">
        {{--<div class="form-group">--}}
        <div class="content-box__filter content-box__filter-period filter-float__right">
            <select id="daterange" name="filters[dates_period]" class="form-control selectpicker" required>
				<?php $now = Carbon\Carbon::now()->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$now}}" @if(isset($filters['dates_period']) && $filters['dates_period'] == $now) selected @endif>{{ trans('all.today') }}</option>
				<?php $days7 = Carbon\Carbon::now()->subDays(7)->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$days7}}" @if(isset($filters['dates_period']) && $filters['dates_period'] == $days7) selected @endif>{{ trans('all.7_days') }}</option>
				<?php $days30 = Carbon\Carbon::now()->subDays(30)->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$days30}}" @if((isset($filters['dates_period']) && $filters['dates_period'] == $days30) || !isset($filters['dates_period'])) selected @endif>{{ trans('all.30_days') }}</option>
				<?php $months3 = Carbon\Carbon::now()->subMonths(3)->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$months3}}" @if((isset($filters['dates_period']) && $filters['dates_period'] == $months3)) selected @endif>{{ trans('all.3_months') }}</option>
				<?php $months6 = Carbon\Carbon::now()->subMonths(6)->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$months6}}" @if(isset($filters['dates_period']) && $filters['dates_period'] == $months6) selected @endif>{{ trans('all.half_a_year') }}</option>
				<?php $months12 = Carbon\Carbon::now()->subMonths(12)->format('d/m/Y').'-'.Carbon\Carbon::now()->format('d/m/Y');?>
                <option value="{{$months12}}" @if(isset($filters['dates_period']) && $filters['dates_period'] == $months12) selected @endif>{{ trans('all.year') }}</option>
                <option value="0" @if((isset($filters['dates_period']) && $filters['dates_period'] == 0)) selected @endif>{{ trans('all.whole_time') }}</option>
            </select>
        </div>
        {{--</div>--}}
        {{--<div class="form-group">--}}
        <div class="content-box__filter content-box__filter-username_search filter-float__right filter-mr-2">
            <input name="filters[username]" id="username" class="form-control input-autocomplete" placeholder="{{ trans('all.enter_your_name') }}" value="@if(isset($filters['username'])){{$filters['username']}}@endif" autocomplete="off">
            {{--<span id="searchclear">×</span>--}}
            {{--<span id="searchclear" class="glyphicon glyphicon-remove" aria-hidden="true"></span>--}}
            <span id="searchclear">×</span>
        </div>
        <input name="filters[userid]" id="userid" type="hidden" value="@if(isset($filters['userid'])){{$filters['userid']}}@endif">
        {{--</div>--}}
    </form>
    <div class="clearfix"></div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-6" id="col-1">
            <div class="row workstat_block">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12"><h2 class="title-block">{{ trans('all.drivers_work_measurements') }}</h2></div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km') }}</div>
                        <div class="col-sm-4 value-col"><span class="value distance"><span id="parameter_distance">{{$stat['distance']}}</span> {{trans('all.km')}}</span> <span class="plus"><button type="button" class="btn-append" data-toggle="modal" data-target="#innlogist-modal" data-type="parameter_distance"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span></div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-sm-8 title-col">{{ trans('all.quantity_of_passed_km_empty') }}</div>
                        <div class="col-sm-4 value-col"><span class="value distance"><span id="parameter_distance_empty">{{$stat['distance_empty']}}</span> {{trans('all.km')}}</span> <span class="plus"><button type="button" class=" btn-append" data-toggle="modal" data-target="#innlogist-modal" data-type="parameter_distance_empty"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span></div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-sm-8 title-col">{{ trans('all.quantity_of_spent_fuel') }}</div>
                        <div class="col-sm-4 value-col"><span class="value liter"><span id="parameter_fuel">{{$stat['fuel']}}</span> {{trans('all.liter')}}</span> <span class="plus"><button type="button" class="btn-append" data-toggle="modal" data-target="#innlogist-modal" data-type="parameter_fuel"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span></div>
                    </div>
                    <div class="row workstat-row" style="display: none;">
                        <div class="col-sm-8 title-col">{{ trans('all.total_expenses_on_the_way') }}</div>
                        <div class="col-sm-4 value-col"><span class="value money_value"><span id="parameter_amount">{{$stat['amount']}}</span> {{trans('all.UAH')}}</span> <span class="plus"><button type="button" class="btn-append" data-toggle="modal" data-target="#innlogist-modal" data-type="parameter_amount"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></span></div>
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
                        <div class="col-sm-12"><h2 class="title-block">{{ trans('all.work_efficiency') }}</h2></div>
                    </div>
                    <div class="row workstat-graph">
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <canvas id="chart1"></canvas>
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
        <div class="col-xs-12 col-sm-6 testimonail" id="col-2">
            <div class="row">
                <div class="col-sm-7">
                    <h2 class="title-block">{{ trans('all.testimonials') }}</h2>
                </div>
                <div class="col-sm-4 testimonail-rating">
                    @if($testimonials->count() != 0)
                        <span class="glyphicon glyphicon-star @if($testimonials_rating >= 1) checked @endif" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-star @if($testimonials_rating >= 2) checked @endif" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-star @if($testimonials_rating >= 3) checked @endif" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-star @if($testimonials_rating >= 4) checked @endif" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-star @if($testimonials_rating >= 5) checked @endif" aria-hidden="true"></span>
                    @endif
                </div>
            </div>

            <div class="row" id="testimonial_wrapper">
                @include('analytics.includes.testimonial-comments')
            </div>
        </div>
    </div>
    <div class="modal fade" id="innlogist-modal" tabindex="-1" role="dialog" aria-labelledby="innlogist-modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="innlogist-modalLabel">{{ trans('all.add') }}</h4>
                </div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                        <button type="submit" id="updVar" class="btn button-style1">{{ trans('all.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid table-analytics__wrapper">
    <div class="row">
        <div class="col-xs-12 table-wrap">
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
                            <div class="name_status"><span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span></div>
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

        <!-- Mobile desktop -->
        <div class="tab-content content-wrap">
            <div class="tab-pane-active">
                <div class="ordersBox">
                    @foreach ($orders as $order)
                        @php
                            $status = $order->getStatus();
                        @endphp
                        <div class="content-box__row box-wrap">
                            <div class="card-order">
                                <div class="row flex">
                                    <div class="col-xs-1 /*br-2*/ flex align-content-between wrap-id">
                                        <div class="container">
                                            <span class="small-size bold">#</span>&nbsp; <span class="small-size bold">{{ $order->id }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 wrap-date /*br-2*/ flex align-content-between wrap-id">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="">
                                                    <span class="small-size bold">{{ trans('all.date_of_deal') }}</span>
                                                </div>
                                                <div class="">
                                                    <span class="">{{ \Carbon\Carbon::parse($order->addresses->first()->pivot->date_at)->format('d/m/y') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="analytics_status_wrapper">
                                                    {{--<span class="analytics_status analytics_status__{{ $status->name }}">--}}
                                                    {{--    {{ trans('all.status_' . $status->name ) }}--}}
                                                    {{--</span>--}}
                                                    <span class="marker-{{ $status->name }} marker-status transition" id="drivers">
                                                                {{ trans('all.status_' . $status->name ) }}
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 /*br-2*/ flex align-content-between wrap-id">
                                        <div class="container">
                                            <span class="small-size bold">{{ trans('all.name_and_status') }}</span>
                                        </div>
                                        <div class="container">
                                            <div class="name_status">
                                                <span>{{ $order->addresses->first()->address }} - <br> {{ $order->addresses->last()->address }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xs-2 /*br-2*/ flex align-content-between wrap-id">

                                        <!-- [Client] -->
                                        <div class="container" id="header">
                                            <span class="small-size bold">{{ trans('all.customer') }}</span>&nbsp;
                                        </div>

                                        <div class="container">
                                                        <span class="wrap-left">
                                                            @if($order->getPerformer())
                                                                {{$order->getPerformer()->creator->name}}
                                                            @endif
                                                        </span>
                                        </div>
                                        <!-- [end Client] -->

                                        <!-- [Transport] -->
                                        <div class="container">
                                            <span class="small-size bold">{{ trans('all.transport') }}</span>
                                        </div>

                                        <div class="container">
                                            <span class="wrap-left">{{ trans('handbook.' . $order->getCategoryName()) }}</span>
                                        </div>
                                        <!-- [end Transport] -->

                                        <!-- [Logist] -->
                                        <div class="container">
                                            <span class="small-size bold">{{ trans('all.logist') }}</span>
                                        </div>
                                        <div class="container">
                                                        <span class="wrap-left">
                                                            @if($order->getPerformer())
                                                                {{$order->getPerformer()->executor->name}}
                                                            @endif
                                                        </span>
                                        </div>
                                        <!-- [end Logist] -->

                                    </div>
                                    <div class="col-xs-1 /*br-2*/ flex align-content-between wrap-id">
                                        <div class="container">
                                            <span class="small-size bold">{{ trans('all.sum') }}</span>
                                        </div>

                                        <div class="container">
                                            <span class="sum">{{ number_format($order->amount_plan, 2, '.', '') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 /*br-2*/ flex align-content-between wrap-id">
                                        <div class="container">
                                            <span class="small-size bold">{{ trans('all.profitability') }}</span>
                                        </div>

                                        <div class="container">
                                            <span class="sum">{{ number_format($order->amount_plan, 2, '.', '') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination -->
        {{ $orders->appends( ['filters' => $filters])->links() }}
    </div>
</div>