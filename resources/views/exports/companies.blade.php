@extends('layouts.pdf')
@section('content')
    <div class="content-box analytics-page ">
        <div class="container-fluid analytics-companies-page">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-xs-3 col-sm-4">
                            <div class="col-sm-2 m">
                                <div class="main-title workstat_block_sm @if($total_new[1] == 1)workstat-green @else workstat-red @endif">
                                    <div class="value">{{$total_new[0]}}</div>
                                    <div class="title-col ">{{ trans('all.quantity_of_new_deals') }}</div>
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
                            <div class="col-sm-2 m">
                                <div class="main-title workstat_block_sm @if($total_sum[1] == 1)workstat-green @else workstat-red @endif">
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
                            <div class="col-sm-2 m">
                                <div class="main-title workstat_block_sm workstat-green grey border-grey">
                                    <div class="value grey">&#8372; 0</div>
                                    <div class="title-col">{{ trans('all.profitability_of_the_transaction') }}</div>
                                    <div class="value-trend /*value-trend-red*/"><span
                                                class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                                class="grey">0</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-4">
                            <div class="col-sm-2 grey left-main">
                                <div class="main-title workstat_block_sm workstat-red grey border-grey">
                                    <div class="value">0</div>
                                    <div class="title-col">{{ trans('all.quantity_agreed_contracts') }}</div>
                                    <div class="value-trend /*value-trend-red*/"><span
                                                class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                                class="grey">0</span></div>
                                </div>
                            </div>
                            <div class="col-sm-2 left-main">
                                <div class="main-title workstat_block_sm workstat-green grey border-grey">
                                    <div class="value grey">&#8372; 0</div>
                                    <div class="title-col">{{ trans('all.expenses_for_all_transactions') }}</div>
                                    <div class="value-trend /*value-trend-green*/"><span
                                                class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> <span
                                                class="grey">0</span></div>
                                </div>
                            </div>
                            <div class="col-sm-2 left-main">
                                <div class="main-title workstat_block_sm workstat-green grey border-grey">
                                    <div class="value grey">&#8372; 0</div>
                                    <div class="title-col">{{ trans('all.manager_commission') }}</div>
                                    <div class="value-trend /*value-trend-red*/"><span
                                                class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span
                                                class="grey">0</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 right-main">
                            <div class="row workstat_block">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12"><h2
                                                    class="title-block">{{ trans('all.transport_efficiency') }}</h2></div>
                                    </div>
                                    <div class="row main-canvas">
                                        <div class="col canvas">
                                            @php
                                                $transport_count_sum = $transport_count[1] + $transport_count[2] + $transport_count[3];

                                                if($transport_count_sum != 0){
                                                    $efficiency = round(($transport_count[1]/($transport_count[1] + $transport_count[2] + $transport_count[3])*100), 2);
                                                }
                                                else {
                                                    $efficiency = 0;
                                                }

                                                $efficiency_colors = ['#00cf3e', '#007cff', '#ffcc00'];

                                            @endphp
{{--                                            <canvas id="chart3" data-efficiency="{{$efficiency}}"></canvas>--}}
                                        </div>
                                        <div class="col desc-canvas">
                                            <table class="table table__legend">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <span style="color: {{$efficiency_colors[0]}};">{{$transport_count[1]}}</span>
                                                    </td>
                                                    <td>{{ trans('all.on_the_road') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span style="color: {{$efficiency_colors[1]}};">{{$transport_count[2]}}</span>
                                                    </td>
                                                    <td>{{ trans('all.under_maintenance') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span style="color: {{$efficiency_colors[2]}}"
                                                              class="value">{{$transport_count[3]}}</span></td>
                                                    <td>{{ trans('all.waiting_for_order') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row workstat-row">
                                        <div class="col-sm-8 title-col">{{ trans('all.quantity_of_own_transport') }}</div>
                                        <div class="col-sm-4 value-col"><span
                                                    class="value value-green">{{$transport_count[0]}}</span></div>
                                    </div>
                                    <div class="row workstat-row">
                                        <div class="col-sm-8 title-col">{{ trans('all.quantity_of_partner_transport') }}</div>
                                        <div class="col-sm-4 value-col"><span class="value value-blue value-grey">0</span></div>
                                    </div>
                                    <div class="row workstat-row">
                                        <div class="col-sm-8 title-col">{{ trans('all.total_number_of_transport') }}</div>
                                        <div class="col-sm-4 value-col"><span
                                                    class="value value-grey">{{$transport_count[0]}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 container-drivers">
                    <div class="row workstat_block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.drivers_work_measurements') }}</h2></div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col /*control-label*/">{{ trans('all.time_of_driving') }}</div>
                                <div class="col-sm-4 value-col"><span
                                            class="value /*value-green*/">{{$stat['duration']}}</span></div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col /*control-label*/">{{ trans('all.quantity_of_passed_km') }}</div>
                                <div class="col-sm-4 value-col"><span
                                            class="value /*value-red*/">{{$stat['distance_full']}} {{ trans('all.km') }}</span>
                                </div>
                            </div>
                            <div class="row workstat-row">
                                <div class="col-sm-8 title-col /*control-label*/">{{trans('all.quantity_of_passed_km_empty')}}</div>
                                <div class="col-sm-4 value-col"><span
                                            class="value /*value-red*/">{{$stat['distance_empty']}} {{ trans('all.km') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row workstat_block container-works">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-8"><h2 class="title-block">{{ trans('all.work_efficiency') }}</h2>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row workstat-graphs">
                                <div class="col-xs-7">
{{--                                    <canvas id="chart1"></canvas>--}}
                                </div>
                                <div class="col-xs-5">
                                    <table class="table table__legend">
                                        <tbody>
                                        <tr>
                                            <td class="grey">{{ trans('all.on_time') }}</td>
                                            <td><span class="grey">{{count($orders_completed_during)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="grey">{{ trans('all.out_of_time') }}</td>
                                            <td>
                                                <span class="grey">{{$orders_chart[2] - (count($orders_completed_during))}}</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                        @php
                                            $efficiency_chart1 = 0;
                                            if($orders_chart[2] != 0){
                                                $efficiency_chart1 = count($orders_completed_during)/($orders_chart[2])*100;
                                            }
                                        @endphp
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $country_colors = ['#00cf3e', '#ff4748', '#ffcc00', '#007cff', '#e206f0', '#d4d4d4'];
                    @endphp
                    <div class="row workstat_block container-works">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.delivary_by_country') }}</h2></div>
                            </div>
                            <div class="row workstat-graph">
                                @if(count($country_count) == 1 && isset($country_count['Other']) && $country_count['Other'] == 100)
                                    <div class="col-xs-12 text-center">
                                        <p style="margin-top: 50px; padding-bottom: 60px;">{{ trans('all.no_data') }}</p>
                                    </div>
                                @else
                                    <div class="col-sm-7">
{{--                                        <canvas id="chart2"></canvas>--}}
                                    </div>
                                    <div class="col-sm-5">
                                        <table class="table table__legend">
                                            <tbody>
                                            @php
                                                $index = 0;
                                            @endphp
                                            @foreach($country_count as $country=>$percent)
                                                @if($percent != 0)
                                                    <tr>
                                                        <td><span class="" style="color: {{$country_colors[$index]}}">{{round($percent, 2)}}%</span>
                                                        </td>
                                                        <td>{{$country}}</td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $index++;
                                                @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-12 col-md-6">
                    <div class="row workstat_block container-city">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12"><h2
                                            class="title-block">{{ trans('all.transaction_measurement') }}</h2></div>
                            </div>
                            @if(max($orders_chart) == 0)
                                <div class="row workstat-row">
                                    <div class="col-xs-12 text-center">
                                        <p style="margin-top: 50px; padding-bottom: 60px;">{{ trans('all.no_data') }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="row workstat-graph">
                                    <div class="col-sm-12">
{{--                                        <canvas id="bar-chart-horizontal"></canvas>--}}
                                    </div>
                                </div>
                                <div class="row workstat-row">
                                    <div class="col-sm-8 title-col">{{ trans('all.total_quantity_of_deals') }}</div>
                                    <div class="col-sm-4 value-col"><span
                                                class="value">{{array_sum($orders_chart)}}</span></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @php
                        $city_colors = ['#00cf3e', '#ff4748', '#ffcc00', '#007cff', '#e206f0', '#d4d4d4'];
                    @endphp
                    <div class="row workstat_block container-city">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-8"><h2 class="title-block">{{ trans('all.delivary_by_city') }}</h2>
                                </div>
                                @if(!empty($country_filter))
                                    <div class="col-sm-4">
                                        <form method="POST" action="" id="formAnalyticsFiltersCountry">

                                            {{-- HIDDEN --}}
                                            <input type="hidden" name="filters[type]" value="orders">
                                            <select id="countryselect" name="filters[country]"
                                                    class="form-control selectpicker" required>
                                                @foreach($country_filter as $key=>$country)
                                                    <option value="{{$country}}"
                                                            @if(isset($filters['country']) && $filters['country'] == $country) selected @endif>{{$country}}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="row workstat-graph">
                                @if(empty($city_count))
                                    <div class="col-xs-12 text-center">
                                        <p style="margin-top: 50px; padding-bottom: 60px;">{{ trans('all.no_data') }}</p>
                                    </div>
                                @else
                                    <div class="col-sm-7">
{{--                                        <canvas id="chart5"></canvas>--}}
                                    </div>
                                    <div class="col-sm-5">
                                        <table class="table table__legend">
                                            <tbody>
                                            @php
                                                $index = 0;
                                            @endphp
                                            @foreach ($city_count as $city=>$count)
                                                <tr>
                                                    <td><span style="color: {{$city_colors[$index]}}">{{$count}}%</span>
                                                    </td>
                                                    <td>{{$city}}</td>
                                                </tr>
                                                @php
                                                    $index++;
                                                @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection