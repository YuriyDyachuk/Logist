<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/main_layout/css/pdf.css')}}">
@include('layouts.includes.css_files_new')

<!-- Script -->
    <script type="text/javascript" src="{{ url('js/app.js') }}"></script>
</head>
<body>
<div class="content-box analytics-page">
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
                                                {{--                                                                                                <span class="analytics_status analytics_status__{{ $status->name }}">--}}
                                                {{--                                                                                                            {{ trans('all.status_' . $status->name ) }}--}}
                                                {{--                                                                                                </span>--}}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>