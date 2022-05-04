{{--{{ var_dump($stat) }}--}}
<div class="container-fluid" id="report_details" data-report="{{ $report->id }}">
    <div class="row details_head">
        <div class="col-xs-12 col-sm-3 driver_name">
            {{ $report->driver->name }}
        </div>
        <div class="col-xs-12 col-sm-3 transport_number">
            {{ $report->transport->number }}
        </div>
        <div class="col-xs-12 col-sm-3 period">
            {{ $report->start_report }} - {{ $report->end_report }}
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="row workstat_block">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="title-block">Показатели работы</h2>
                        </div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Выполнено заказов
                        </div>
                        <div class="col-xs-4 value-col">
                            {{ $stat['orders'] }}
                        </div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Пройдено Км
                        </div>
                        <div class="col-xs-4 value-col">
                            {{ $stat['distance'] }}
                        </div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Пройдено Км без груза
                        </div>
                        <div class="col-xs-4 value-col">
                            {{ $stat['distance_empty'] }}
                        </div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Потрачено топлива
                        </div>
                        <div class="col-xs-4 value-col">
                            {{ $stat['fuel'] }}
                        </div>
                    </div>
                    {{--
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Остаток топлива на начало месяца
                        </div>
                        <div class="col-xs-4 value-col">
                            15
                        </div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Остаток топлива на конец месяца
                        </div>
                        <div class="col-xs-4 value-col">
                            15
                        </div>
                    </div>
                    --}}
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">
                            Дополнительные затраты
                        </div>
                        <div class="col-xs-4 value-col">
                            {{ $stat['amount_fact'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--{{ var_dump($expenses) }}--}}
        <div class="col-xs-12 col-sm-6">
            <div class="row workstat_block">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="title-block">Топливо</h2>
                        </div>
                    </div>
                    @if(isset($expenses['fuel']))
                        @foreach  ($expenses['fuel'] as $fuel)
                            {{--{{ var_dump($fuel) }}--}}
                            <div class="row workstat-row">
                                <div class="col-xs-4 title-col">{{ Carbon\Carbon::parse($fuel->created_at)->format('d.m.Y') }}</div>
                                <div class="col-xs-4 title-col">{{ $fuel->id }}</div>
                                <div class="col-xs-4 title-col">{{ $fuel->expenses_amount }} л</div>
                            </div>

                        @endforeach
                    @endif
{{--
                    <div class="row workstat-row">
                        <div class="col-xs-4 title-col">04.05.2020</div>
                        <div class="col-xs-4 title-col">15</div>
                        <div class="col-xs-4 title-col">159 л</div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-4 title-col">04.05.2020</div>
                        <div class="col-xs-4 title-col">15</div>
                        <div class="col-xs-4 title-col">159 л</div>
                    </div>
--}}
                </div>
            </div>
            <div class="row workstat_block">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="title-block">Расходы</h2>
                        </div>
                    </div>
                    @php
                        $full = 0;
                    @endphp

                    <div class="row workstat-row">
                        @php
                            $parking_full = 0;
                        @endphp

                        @if(isset($expenses['parking']))
                            @foreach  ($expenses['parking'] as $parking)
                                @php
                                    $parking_full = $parking_full + $parking->expenses_amount;
                                    $full += $parking->expenses_amount;
                                @endphp
                            @endforeach
                        @endif
                        <div class="col-xs-8 title-col">Стоянка</div>
                        <div class="col-xs-4 title-value">{{ $parking_full }} {{ trans('all.UAH') }}</div>

                    </div>

                    <div class="row workstat-row">
                        @php
                            $parts_full = 0;
                        @endphp

                        @if(isset($expenses['parts']))
                            @foreach  ($expenses['parts'] as $parts)
                                @php
                                    $parts_full = $parts_full + $parts->expenses_amount;
                                    $full += $parts->expenses_amount;
                                @endphp
                            @endforeach
                        @endif
                        <div class="col-xs-8 title-col">Запчасти</div>
                        <div class="col-xs-4 title-value">{{ $parts_full }} {{ trans('all.UAH') }}</div>
                    </div>
                    <div class="row workstat-row">
                        @php
                            $other_full = 0;
                        @endphp

                        @if(isset($expenses['other']))
                            @foreach  ($expenses['other'] as $other)
                                @php
                                    $other_full = $other_full + $other->expenses_amount;
                                    $full += $other->expenses_amount;
                                @endphp
                            @endforeach
                        @endif
                        <div class="col-xs-8 title-col">Другое</div>
                        <div class="col-xs-4 title-value">{{ $other_full }} {{ trans('all.UAH') }}</div>
                    </div>
                    <div class="row workstat-row">
                        @php
                            $fuel_full = 0;
                        @endphp

                        @if(isset($expenses['fuel']))
                            @foreach  ($expenses['fuel'] as $fuel)
                                @php
                                    $fuel_full = $fuel_full + $fuel->expenses_amount;
                                    $full += $fuel->expenses_amount;
                                @endphp
                            @endforeach
                        @endif
                        <div class="col-xs-8 title-col">Топливо</div>
                        <div class="col-xs-4 title-value">{{ $fuel_full }} {{ trans('all.UAH') }}</div>
                    </div>
                    <div class="row workstat-row">
                        <div class="col-xs-8 title-col">Итого: {{ $full }} {{ trans('all.UAH') }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row workstat_block">
        <div class="col-xs-12 col-sm-12">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title-block">Заказы</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="report_orders">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>{{ trans('all.date') }}</td>
                                <td>{{ trans('all.address') }}</td>
                                <td>Топливо</td>
                                <td>Затраты</td>
                            </tr>
                        </thead>
                    @if(!empty($order_data))
                        <tbody>
                        @foreach($order_data as $order)
                            @php
                                $addresses = $order['order']->addresses;
                            @endphp
                            <tr>
                                <td>{{ $order['order']->id }}</td>
                                <td>{{ $order['address']}}</td>
                                <td>{{ \Carbon\Carbon::parse($order['date'])->toDateString()}}</td>
                                <td>{{ $order['fuel_litres'] }}</td>
                                <td>{{ $order['expenses_amount'] }}</td>
                            </tr>

                            {{--{{ var_dump($order) }}--}}
                        @endforeach
                        </tbody>
                    @else
                        <tr>
                            <td colspan="5">{{ trans('all.empty') }}</td>
                        </tr>
                    @endif
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <a href="" class="btn button-cancel">Отклонить<i class="symbol-close">×</i></a>
            <a href="" class="btn button-style1" id="report_agree">Утвердить</a>
        </div>
    </div>
</div>


    <script>
        $(function() {

            var report = $('#report_details');
            var report_id = report.data('report');

            $('#report_agree').on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: '{{route('analytics.drivers.report')}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data:{
                        report : report_id,
                        agree : 1
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    },
                    success: function (data) {
                        console.log(data);
                        //window.location.href = "{{route('analytics.drivers')}}";
                    },
                    error: function (data) {
                    }
                });
            });
        })
    </script>

