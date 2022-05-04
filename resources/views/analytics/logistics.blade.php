@extends('layouts.app')
@section('content')
    <div class="content-box analytics-page">

        <!-- Page filters -->
        @include('analytics.partials.nav')

        @if(checkPaymentAccess('analytics_logist'))

        <div class="content-box__filters filter-align__right">
            {{--  import pdf-excel  --}}
            <form id="contactForm" class="form-group" method="POST" style="display: block">
            @csrf
            <!-- Bootstrap 4 -->
                <div class="btn-group col-xs-4 flex-box-form">
                    <!-- Кнопка -->
                    <button type="button" class="btn btn-success dropdown-toggle wrap-size hidden" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('all.analytics_import_all') }}
                    </button>
                    <!-- Меню -->
                    <div class="dropdown-menu">
                        <?php $pdf = request()->url();?>
                        <a class="dropdown-item col-xs-8 hidden" id="import-pdf" href="{!! url($pdf . '?download=pdf') !!}" style="margin-bottom: 5px">{{ trans('all.analytics_pdf') }}</a>
                        <a class="dropdown-item col-xs-8" href="{!! url($pdf . '?download=excel') !!}">{{ trans('all.analytics_excel') }}</a>
                    </div>
                </div>
            </form>

            {{--  Filters  --}}
            <form method="GET" action="" id="formFilters" class="form-inline">
                {{--<div class="form-group">--}}
                    <div class="content-box__filter  content-box__filter-period filter-float__right">
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
                        <span id="searchclear">×</span>
                        {{--<span id="searchclear" class="glyphicon glyphicon-remove" aria-hidden="true"></span>--}}
                    </div>
                    <input name="filters[userid]" id="userid" type="hidden" value="@if(isset($filters['userid'])){{$filters['userid']}}@endif">
                {{--</div>--}}
            </form>
            <div class="clearfix"></div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-green">
                                <div class="value">{{$total_new[0]}}</div>
                                <div class="title-col">{{ trans('all.quantity_of_new_deals') }}</div>
                                @if($total_new[1] == 1)
                                    <div class="value-trend value-trend-green"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}%</div>
                                @else
                                    <div class="value-trend value-trend-red"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-red border-grey">
                                <div class="value grey">0</div>
                                <div class="title-col">{{ trans('all.quantity_agreed_contracts') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-green">
                                <div class="value">&#8372; {{$total_sum[0]}}</div>
                                <div class="title-col">{{ trans('all.cost_of_all_transactions') }}</div>
                                @if($total_sum[1] == 1)
                                    <div class="value-trend value-trend-green"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> {{($total_sum[2] < 100) ? $total_sum[2] : 100 }}%</div>
                                @else
                                    <div class="value-trend value-trend-red"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{($total_sum[2] < 100) ? $total_sum[2] : 100 }}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.expenses_for_all_transactions') }}</div>
                                <div class="value-trend value-trend-green value-grey"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> <span class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.profitability_of_the_transaction') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="workstat_block_sm workstat-green border-grey">
                                <div class="value grey">&#8372; 0</div>
                                <div class="title-col">{{ trans('all.manager_commission') }}</div>
                                <div class="value-trend value-trend-red value-grey"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
                            </div>
                        </div>
                    </div>
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
                                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.transaction_measurement') }}</h2></div>
                            </div>
                            <div class="row workstat-graph">
                                <div class="col-sm-12">
                                    <canvas id="bar-chart-horizontal"></canvas>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col">{{ trans('all.total_quantity_of_deals') }}</div>
                                <div class="col-sm-4 value-col"><span class="value value-grey">{{array_sum($orders_chart)}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-box__filters filter-align__right">
        {{--<div class="content-box__filter" id="content-box__forms">--}}
            <form method="POST" action="" id="formFilters" class="clearfix">
                {{-- HIDDEN --}}
                <input type="hidden" name="filters[type]" value="orders">

                <div class="content-box__filter content-box__filter-period pull-right">
                    {{--<label for="date" class="label-filter">{{ trans('all.date') }}</label>--}}
                    <input type="text" name="filters[dates]" class="inputDaterangepicker" value="" onblur="">
                </div>
            </form>
            <div class="clearfix"></div>
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
                                            <div class="col-xs-1 /*br-2*/ flex align-content-between">
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
        @else
            @include('includes.plan_change')
        @endif
    </div>
@endsection

@push('scripts')
@include('analytics.includes.graph')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
$(document).ready(function () {

    $('#daterange').on('change', function() {
        form_submit();
    });


    $('#username').on('input',function(e){
        var name = $(this).val();
        if(name.length > 2){
            console.log(name);

            var url = '?filters[name]='+name;
            $.ajax({
                url     : url,
                type    : 'GET',
                dataType: 'json',
                success : function (data) {
                    console.log(data);
                    let list = '<div class="list-group autocomplete-result">';
                    $.each(data, function(key, value) {
                        console.log(key);
                        console.log(value);
                        list += '<a href="javascript://" class="list-group-item" data-user="'+key+'">'+value+'</a>';
                    });
                    list +=  '</div>';
                    $('#username').parent().append(list + '</div>');

                    $('.autocomplete-result a').bind('click', function () {
                        $('#userid').val($(this).attr('data-user'));
                        $('#username').val($(this).text());
                        form_submit();
                    })
                },
                error   : function (data) {
                    console.log(data)
                }
            });
        }
    });

    $('body').on('blur', '.input-autocomplete', function () {
                deleteAutocompleteResult();
    });
    $('body').on('change', '.input-autocomplete', function () {
                deleteAutocompleteResult();
    });

    function deleteAutocompleteResult() {
        $('body').find('.autocomplete-result').fadeOut(200, function () {
            $(this).detach();
        });
    }

    $("#searchclear").click(function(){
        $("#username").val('');
        $("#userid").val('');
        form_submit();
    });


    moment.locale('{{ app()->getLocale() }}');

    $('input[name="filters[dates]"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            "format": "DD/MM/YYYY",
            "separator": "-",
            "applyLabel": "{{ trans('all.select') }}",
            "cancelLabel": "{{ trans('all.clean') }}",
            "firstDay": 1
        },
    });

    @php
        if(isset($filters['dates']) && $filters['dates'] != ''){
            $dates = explode('-', $filters['dates']);
            $start = $dates[0];
            $end = $dates[1];
        }
    @endphp

	<?php if(isset($start) &isset($end)  ){?>
        $('input[name="filters[dates]"]').data('daterangepicker').setStartDate(<?php echo $start;?>);
        $('input[name="filters[dates]"]').data('daterangepicker').setEndDate(<?php echo $end;?>);
        $('input[name="filters[dates]"]').val('<?php echo $start;?>-<?php echo $end;?>');
	<?php } ?>

    $('input[name="filters[dates]"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
        form_submit();
    });

    $('input[name="filters[dates]"]').on('cancel.daterangepicker', function(ev, picker) {
        $('input[name="filters[dates]"]').val('');
        form_submit();
    });

    function form_submit() {
        var data = $('#formFilters,#formAnalyticsFilters').serialize();
        console.log(data);
        window.location.href = "?"+data;
    }

            @php

                $max = max($orders_chart);

                if($max <= 10){
                    $step = 1;
                }
                elseif(10 < $max && $max <= 50) {
                    $step = 5;
                }
                else {
                $step = 10;
                }


            @endphp


    var options = {
        tooltips: {enabled: false},
        hover: {mode: null},
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                minBarLength: 2,
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    display: true,
                    beginAtZero: true,
                    min: 0,
                    stepSize: <?php echo $step;?>
                }

            }],
            yAxes: [{
                barPercentage: 0.5,
                barThickness: 12,
                minBarLength: 2,
                gridLines: {
                    display: true,
                    drawBorder: false,
                    offsetGridLines: true,
                    tickMarkLength: 0,
                    drawTicks:false,
                    top: 5,

                },
                ticks: {
                    display: true,
                    mirror: true,
                    fontSize: 14,
                    padding:0 ,
                    labelOffset: -18,
                    fontStyle: "bold"
                }

            }]
        }, // scales
        layout: {
            padding: {
                left: 0,
                right: 35,
                top: 0,
                bottom: 0
            }
        },
        plugins: {
            datalabels: {
                align: 'right',
                anchor: 'end',
                font: {
                    size: '14',
                    weight: 'bold'
                },
                formatter: function(value) {
                    return ""+value;
                }
            }
        }
    };

    var ctx = $('#bar-chart-horizontal');

    data = {
        datasets: [{
            label: false,
            backgroundColor: ["#00e374", "#ffcc00","#007cff","#ff4748"],
            /*data: [82,70,46,3]*/
            data: [<?php echo implode(",",$orders_chart);?>]
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ["{{ trans('all.active') }}", "{{ trans('all.planned') }}", "{{ trans('all.completed') }}", "{{ trans('all.canceled') }}"],
    };


    var myBarChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: options
    });

});
</script>

@endpush