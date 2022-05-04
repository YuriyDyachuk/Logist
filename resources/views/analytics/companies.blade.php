@extends('layouts.app')
@section('content')
<div class="content-box analytics-page">

  <!-- Page filters -->
  @include('analytics.partials.nav')

  <div class="content-box__filters filter-align__right filter-align__fxright">
    {{--  import pdf-excel  --}}
    <form id="contactForm" class="form-group" method="POST" style="display: block">
      @csrf
      <!-- Bootstrap 4 -->
      <div class="btn-group col-xs-2 flex-box-form">
        <!-- Кнопка -->
        <button type="button" class="btn p-0 btn-success fill-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 25V19H13L20 12L27 19H23V25H17ZM13 29V27H27V29H13Z" fill="#fff"/>
          </svg>
          <!-- {{ trans('all.analytics_import_all') }} -->
        </button>
        <!-- Меню -->
        <div class="dropdown-menu">
          <?php $pdf = request()->url();?>
          <a class="dropdown-item col-xs-12 hidden" href="{!! url($pdf . '?download=pdf') !!}" style="margin-bottom: 5px">{{ trans('all.analytics_pdf') }}</a>
          <a class="dropdown-item col-xs-12" href="{!! url($pdf . '?download=excel') !!}">{{ trans('all.analytics_excel') }}</a>
        </div>
      </div>
    </form>

    {{--  Filters  --}}
    <form method="GET" action="" id="formAnalyticsFilters" class="form-inline">
      {{--<div class="form-group">--}}
        <div class="content-box__filter content-box__filter-period filter-float__right ">
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

      </form>
      <div class="clearfix"></div>
    </div>

    <div class="container-fluid analytics-companies-page">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="row">
            <div class="col-sm-6">
              <div class="workstat_block_sm @if($total_new[1] == 1)workstat-green @else workstat-red @endif">
                <div class="value">{{$total_new[0]}}</div>
                <div class="title-col ">{{ trans('all.quantity_of_new_deals') }}</div>
                @if($total_new[1] == 1)
                <div class="value-trend value-trend-green"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}%</div>
                @else
                <div class="value-trend value-trend-red"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{($total_new[2] < 100) ? $total_new[2] : 100}}%</div>
                @endif
              </div>
            </div>
            <div class="col-sm-6 grey">
              <div class="workstat_block_sm workstat-red grey border-grey">
                <div class="value">0</div>
                <div class="title-col">{{ trans('all.quantity_agreed_contracts') }}</div>
                <div class="value-trend /*value-trend-red*/"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="workstat_block_sm @if($total_sum[1] == 1)workstat-green @else workstat-red @endif">
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
              <div class="workstat_block_sm workstat-green grey border-grey">
                <div class="value grey">&#8372; 0</div>
                <div class="title-col">{{ trans('all.expenses_for_all_transactions') }}</div>
                <div class="value-trend /*value-trend-green*/"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> <span class="grey">0</span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="workstat_block_sm workstat-green grey border-grey">
                <div class="value grey">&#8372; 0</div>
                <div class="title-col">{{ trans('all.profitability_of_the_transaction') }}</div>
                <div class="value-trend /*value-trend-red*/"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="workstat_block_sm workstat-green grey border-grey">
                <div class="value grey">&#8372; 0</div>
                <div class="title-col">{{ trans('all.manager_commission') }}</div>
                <div class="value-trend /*value-trend-red*/"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <span class="grey">0</span></div>
              </div>
            </div>
          </div>
          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.drivers_work_measurements') }}</h2></div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col /*control-label*/">{{ trans('all.time_of_driving') }}</div>
                <div class="col-sm-4 value-col"><span class="value /*value-green*/">{{$stat['duration']}}</span></div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col /*control-label*/">{{ trans('all.quantity_of_passed_km') }}</div>
                <div class="col-sm-4 value-col"><span class="value /*value-red*/">{{$stat['distance_full']}} {{ trans('all.km') }}</span></div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col /*control-label*/">{{trans('all.quantity_of_passed_km_empty')}}</div>
                <div class="col-sm-4 value-col"><span class="value /*value-red*/">{{$stat['distance_empty']}} {{ trans('all.km') }}</span></div>
              </div>
            </div>
          </div>
          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-8"><h2 class="title-block">{{ trans('all.work_efficiency') }}</h2></div>
                <div class="col-sm-4"></div>
              </div>
              <div class="row workstat-graph">
                <div class="col-sm-7">
                  <canvas id="chart1"></canvas>
                </div>
                <div class="col-sm-5">
                  <table class="table table__legend">
                    <tbody>
                      <tr>
                        <td class="grey">{{ trans('all.on_time') }}</td>
                        <td><span class="grey">{{count($orders_completed_during)}}</span></td>
                      </tr>
                      <tr>
                        <td class="grey">{{ trans('all.out_of_time') }}</td>
                        <td><span class="grey">{{$orders_chart[2] - (count($orders_completed_during))}}</span></td>
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
          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.delivary_by_country') }}</h2></div>
              </div>
              <div class="row workstat-graph">
                @if(count($country_count) == 1 && isset($country_count['Other']) && $country_count['Other'] == 100)
                <div class="col-xs-12 text-center">
                  <p style="margin-top: 50px; padding-bottom: 60px;">{{ trans('all.no_data') }}</p>
                </div>
                @else
                <div class="col-sm-7">
                  <canvas id="chart2"></canvas>
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
                        <td><span class="" style="color: {{$country_colors[$index]}}">{{round($percent, 2)}}%</span></td>
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
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.transaction_measurement') }}</h2></div>
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
                  <canvas id="bar-chart-horizontal"></canvas>
                </div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col">{{ trans('all.total_quantity_of_deals') }}</div>
                <div class="col-sm-4 value-col"><span class="value">{{array_sum($orders_chart)}}</span></div>
              </div>
              @endif
            </div>
          </div>

          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12"><h2 class="title-block">{{ trans('all.transport_efficiency') }}</h2></div>
              </div>
              <div class="row workstat-graph">
                <div class="col-sm-7">
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
                  <canvas id="chart3" data-efficiency="{{$efficiency}}"></canvas>
                </div>
                <div class="col-sm-5">
                  <table class="table table__legend">
                    <tbody>
                      <tr>
                        <td><span style="color: {{$efficiency_colors[0]}};">{{$transport_count[1]}}</span></td>
                        <td>{{ trans('all.on_the_road') }}</td>
                      </tr>
                      <tr>
                        <td><span style="color: {{$efficiency_colors[1]}};">{{$transport_count[2]}}</span></td>
                        <td>{{ trans('all.under_maintenance') }}</td>
                      </tr>
                      <tr>
                        <td><span style="color: {{$efficiency_colors[2]}}" class="value">{{$transport_count[3]}}</span></td>
                        <td>{{ trans('all.waiting_for_order') }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_own_transport') }}</div>
                <div class="col-sm-4 value-col"><span class="value value-green">{{$transport_count[0]}}</span></div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col">{{ trans('all.quantity_of_partner_transport') }}</div>
                <div class="col-sm-4 value-col"><span class="value value-blue value-grey">0</span></div>
              </div>
              <div class="row workstat-row">
                <div class="col-sm-8 title-col">{{ trans('all.total_number_of_transport') }}</div>
                <div class="col-sm-4 value-col"><span class="value value-grey">{{$transport_count[0]}}</span></div>
              </div>
            </div>
          </div>
          @php
          $city_colors = ['#00cf3e', '#ff4748', '#ffcc00', '#007cff', '#e206f0', '#d4d4d4'];
          @endphp
          <div class="row workstat_block">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-8"><h2 class="title-block">{{ trans('all.delivary_by_city') }}</h2></div>
                @if(!empty($country_filter))
                <div class="col-sm-4">
                  <form method="POST" action="" id="formAnalyticsFiltersCountry">

                    {{-- HIDDEN --}}
                    <input type="hidden" name="filters[type]" value="orders">
                    <select id="countryselect" name="filters[country]" class="form-control selectpicker" required>
                      @foreach($country_filter as $key=>$country)
                      <option value="{{$country}}" @if(isset($filters['country']) && $filters['country'] == $country) selected @endif>{{$country}}</option>
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
                  <canvas id="chart5"></canvas>
                </div>
                <div class="col-sm-5">
                  <table class="table table__legend">
                    <tbody>
                      @php
                      $index = 0;
                      @endphp
                      @foreach ($city_count as $city=>$count)
                      <tr>
                        <td><span style="color: {{$city_colors[$index]}}">{{$count}}%</span></td>
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


    <div style="width: auto;height: auto">
      <canvas id="chart"></canvas>
    </div>
    @endsection

    @push('scripts')
    @include('analytics.includes.graph')
    <script>
    $(document).ready(function () {

      var ctx = $('#chart');




      $('#daterange').on('change', function() {
        form_submit();
      });

      $('#countryselect').on('change', function() {
        form_submit();
      });


      function form_submit() {
        var data = $('#formAnalyticsFilters, #formAnalyticsFiltersCountry').serialize();
        console.log(data);
        window.location.href = "?"+data;
      }

      Chart.plugins.register({
        beforeDraw: function (chart) {
          if (chart.config.options.elements.center) {
            //Get ctx from string
            var ctx = chart.chart.ctx;

            //Get options from the center object in options
            var centerConfig = chart.config.options.elements.center;
            var fontStyle = centerConfig.fontStyle || 'Arial';
            var txt = centerConfig.text;
            var color = centerConfig.color || '#000';
            var sidePadding = centerConfig.sidePadding || 20;
            var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2);
            //Start with a base font of 30px
            ctx.font = "30px " + fontStyle;

            //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
            var stringWidth = ctx.measureText(txt).width;
            var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

            // Find out how much the font can grow in width.
            var widthRatio = elementWidth / stringWidth;
            var newFontSize = Math.floor(30 * widthRatio);
            var elementHeight = (chart.innerRadius * 2);

            // Pick a new font size so it will not be larger than the height of label.
            var fontSizeToUse = Math.min(newFontSize, elementHeight);

            //Set font settings to draw it correctly.
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
            var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
            ctx.font = fontSizeToUse+"px " + fontStyle;
            ctx.fillStyle = color;

            //Draw text in center
            ctx.fillText(txt, centerX, centerY);
          }
        }
      });

      var chart1 = $('#chart1');

      var options1 = {
        tooltips: {enabled: false},
        hover: {mode: null},
        cutoutPercentage: 70,
        rotation: 1.5,
        elements: {
          center: {
            text: '{{round($efficiency_chart1, 2)}}% {{ trans('all.on_time') }}',
            color: '#00cf3e', // Default is #000000
            fontStyle: 'Arial', // Default is Arial
            sidePadding: 20 // Defualt is 20 (as a percentage)
          }
        },
        plugins: {
          datalabels: {
            // hide datalabels for all datasets
            display: false
          }
        }
      };

      data1 = {
        datasets: [{
          data: [{{100-$efficiency_chart1}},{{$efficiency_chart1}}],
          backgroundColor: ['#ffffff', '#00cf3e']
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: {}
      };

      var chart1output = new Chart(chart1, {
        type: 'doughnut',
        data: data1,
        options: options1,
      });

      var chart2 = $('#chart2');

      var options2 = {
        responsive: true,
        maintainAspectRatio: true,
        tooltips: {enabled: false},
        hover: {mode: null},
        cutoutPercentage: 70,
        rotation: 1.5,
        plugins: {
          datalabels: {
            // hide datalabels for all datasets
            display: false
          }
        }
      };

      data2 = {
        datasets: [{
          data: [<?php echo implode(",",$country_count);?>],
          backgroundColor: ['#00cf3e', '#ff4748', '#ffcc00', '#007cff', '#e206f0', '#d4d4d4']
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: {}
      };

      if (chart2.length != 0){
        var chart2output = new Chart(chart2, {
          type: 'doughnut',
          data: data2,
          options: options2
        });
      }


      var chart3 = $('#chart3');
      var chart3_efficiency = $('#chart3').attr('data-efficiency');

      var options3 = {
        tooltips: {enabled: false},
        hover: {mode: null},
        cutoutPercentage: 70,
        rotation: 2,
        circumference: 5.4,

        elements: {
          center: {
            text: chart3_efficiency +'%',
            color: '#00cf3e', // Default is #000000
            fontStyle: 'Arial', // Default is Arial
            sidePadding: 20 // Defualt is 20 (as a percentage)
          }
        },
        plugins: {
          datalabels: {
            // hide datalabels for all datasets
            display: false
          }
        }
      };

      @php
      unset($transport_count[0]);
      @endphp

      data3 = {
        datasets: [{
          data: [<?php echo implode(",",array_reverse($transport_count));?>], /**/
          /*backgroundColor: ['#00cf3e', '#ff4748' , '#ffcc00', '#007cff']$efficiency_colors*/
          backgroundColor: ['<?php echo implode("','",array_reverse($efficiency_colors));?>']
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: {},

      };

      if (chart3.length != 0) {
        var chart3output = new Chart(chart3, {
          type: 'doughnut',
          data: data3,
          options: options3
        });
      }

      var numberWithCommas = function(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      };


      var chart4 = $('#bar-chart-horizontal');

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

      var options4 = {
        tooltips: {enabled: false},
        hover: {mode: null},
        legend: {
          display: false
        },
        scaleOverride: true,
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
              stepSize: <?php echo $step;?>,
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
              borderDashOffset: 2,
              /*lineWidth: 12,
              color: "rgba(242,247,250,0.8)",*/
              /*zeroLineBorderDashOffset: 10,
              zeroLineWidth: 0,*/
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

      data4 = {
        datasets: [{
          label: false,
          backgroundColor: ["#00e374", "#ffcc00","#007cff","#ff4748"],
          data: [<?php echo implode(",",$orders_chart);?>]
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ["{{ trans('all.active') }}", "{{ trans('all.planned') }}", "{{ trans('all.completed') }}", "{{ trans('all.canceled') }}"],
      };

      if (chart4.length != 0) {
        var chart4output = new Chart(chart4, {
          type: 'horizontalBar',
          data: data4,
          options: options4,
        });
      }

      var chart5 = $('#chart5');

      var options5 = {
        tooltips: {enabled: false},
        hover: {mode: null},
        cutoutPercentage: 70,
        rotation: -0.5*Math.PI,
        plugins: {
          datalabels: {
            // hide datalabels for all datasets
            display: false
          }
        }
      };

      data5 = {
        datasets: [{
          data: [<?php echo implode(",",array_values($city_count));?>],
          /*backgroundColor: ['#00cf3e', '#ff4748', '#ffcc00', '#007cff', '#e206f0', '#d4d4d4'],*/
          backgroundColor: ['<?php echo implode("','",$city_colors);?>']
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: {}
      };

      if (chart5.length != 0) {
        var chart5output = new Chart(chart5, {
          type: 'doughnut',
          data: data5,
          options: options5
        });
      }
    });
    </script>
    @endpush
