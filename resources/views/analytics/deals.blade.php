@extends('layouts.app')
@section('content')
    <div class="content-box analytics-page">

        <!-- Page filters -->
        @include('analytics.partials.nav')

        @if(checkPaymentAccess('analytics_deal'))

            <div class="content-box__filters filter-align__right">
                {{--  import pdf-excel  --}}
                <form id="contactForm" class="form-group hidden" method="POST" style="display: block">
                    @csrf
                    <!-- Bootstrap 4 -->
                        <div class="btn-group col-xs-2 flex-box-form wrap-import">
                            <!-- Кнопка -->
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                {{ trans('all.analytics_import_all') }}
                            </button>
                            <!-- Меню -->
                            <div class="dropdown-menu">
                                <?php $pdf = request()->url();?>
                                <a class="dropdown-item col-xs-12" href="{!! url($pdf . '?download=pdf') !!}"
                                   style="margin-bottom: 5px">{{ trans('all.analytics_pdf') }}</a>
                                <a class="dropdown-item col-xs-12"
                                   href="{!! url($pdf . '?download=excel') !!}">{{ trans('all.analytics_excel') }}</a>
                            </div>
                        </div>
                    </form>
                {{--  Filters  --}}
                <form method="GET" action="" id="formFilters" class="form-inline">
                    <div class="/*form-group */ /*content-box__filter-status*/ content-box__filter content-box__filter-specialization">
                        <label for="order_category" class="label-filter">{{ trans('all.category') }}</label>
                        <select name="filters[specialization]" class="form-control selectpicker" item-filter>
                            <option value="" selected>{{ trans('all.all') }}</option>
                        </select>
                    </div>
                    <div class="/*form-group*/ content-box__filter-status content-box__filter /*form-group__filters_status*/ filter-ml-2">
                        <label for="order_status" class="label-filter">{{ trans('all.status') }}</label>
                        <select name="filters[status]" class="form-control selectpicker" item-filter>
                            <option value="" selected>{{ trans('all.all') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}"
                                        @if(isset($filters['status']) && $filters['status'] == $status->id) selected @endif>{{ trans('all.status_' . $status->name ) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="/*form-group*/ content-box__filter content-box__filter-period filter-ml-2">
                        <label for="date" class="label-filter">{{ trans('all.period') }}</label>
                        <input type="text" name="filters[dates]" class="inputDaterangepicker" value="" onblur="">
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>


            {{--<div class="page-order-filter-nav page-analytics-filter-nav" id="content-box__forms">--}}
            {{--<form method="POST" action="" id="formFilters1" class="clearfix">--}}
            {{-- HIDDEN --}}
            {{--<input type="hidden" name="filters[type]" value="orders">--}}

            {{--<div class="content-box__filter-input content-box__filter-category">--}}
            {{--<label for="order_category" class="h5 title-grey">{{ trans('all.category') }}:</label>--}}
            {{--<select name="filters[specialization]" class="form-control selectpicker" item-filter>--}}
            {{--<option value="" selected>{{ trans('all.all') }}</option>--}}
            {{--</select>--}}
            {{--</div>--}}

            {{--<div id="orderFilter" class="content-box__filter-input content-box__filter-status">--}}
            {{--<label for="order_status" class="h5 title-grey">{{ trans('all.status') }}:</label>--}}
            {{--<select name="filters[status]" class="form-control selectpicker" item-filter>--}}
            {{--<option value="" selected>{{ trans('all.all') }}</option>--}}
            {{--@foreach($statuses as $status)--}}
            {{--<option value="{{$status->id}}" @if(isset($filters['status']) && $filters['status'] == $status->id) selected @endif>{{ trans('all.status_' . $status->name ) }}</option>--}}
            {{--@endforeach--}}
            {{--</select>--}}
            {{--</div>--}}

            {{--<div class="content-box__filter-input content-box__filter-date">--}}
            {{--<label for="date" class="h5 title-grey">{{ trans('all.period') }}:</label>--}}
            {{--<input type="text" name="filters[dates]" class="inputDaterangepicker" value="" onblur="">--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--<div class="clearfix"></div>--}}
            {{--</div>--}}




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
                                            {{--                                        <span class="analytics_status analytics_status__{{ $status->name }}">--}}
                                            {{--                                                    {{ trans('all.status_' . $status->name ) }}--}}
                                            {{--                                        </span>--}}
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
                                                        <span class="small-size bold">#</span>&nbsp; <span
                                                                class="small-size bold">{{ $order->id }}</span>
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
                                                                <span class="marker-{{ $status->name }} marker-status transition"
                                                                      id="drivers">
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

                <!-- {{  $orders->fragment('deal')->render() }} -->

                </div>
            </div>
        @else
            @include('includes.plan_change')
        @endif
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script>
        $(document).ready(function () {

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

            <?php if(isset($start) & isset($end)  ){?>
            $('input[name="filters[dates]"]').data('daterangepicker').setStartDate(<?php echo $start;?>);
            $('input[name="filters[dates]"]').data('daterangepicker').setEndDate(<?php echo $end;?>);
            $('input[name="filters[dates]"]').val('<?php echo $start;?>-<?php echo $end;?>')
            <?php } ?>


            $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $('input[name="filters[dates]"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
                form_submit();
            });

            $('select[name="filters[status]"]').on('change', function () {
                form_submit();
            });

            $('input[name="filters[dates]"]').on('cancel.daterangepicker', function (ev, picker) {
                $('input[name="filters[dates]"]').val('');
                form_submit();
            });

            function form_submit() {
                var data = $('#formFilters').serialize();
                console.log(data);
                window.location.href = "?" + data;
            }
        });
    </script>
@endpush