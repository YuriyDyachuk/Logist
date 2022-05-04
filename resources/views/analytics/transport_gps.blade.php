@extends('layouts.app')
@section('content')
<div class="content-box analytics-page">

    <!-- Page filters -->
    @include('analytics.partials.nav')

    <div class="content-box__filters">

        {{--  Filters  --}}
        <form method="GET" action="" id="formFilters" class="form-inline">
            <div class="content-box__filter content-box__filter-dropdown2">
                <label for="transport" class="label-filter">{{ trans('all.transport') }}</label>
                <select id="filters_transport" name="filters[transport]" class="form-control selectpicker" item-filter>
                    <option value="" selected>{{ trans('all.all') }}</option>
                    @foreach($transports as $transport)
                        <option value="{{$transport->id}}" @if(isset($filters['transport']) && $filters['transport'] == $transport->id) selected @endif @if($transport->gps_parameters->isEmpty()) disabled @endif>{{$transport->number}} @if($transport->gps_parameters->isEmpty()) ({{ __('gps.no_gps') }}) @endif</option>
                    @endforeach
                </select>
            </div>
            <div class="content-box__filter content-box__filter-dropdown2 filter-ml-2">
                <label for="params" class="label-filter">Показатель</label>
                <select id="filters_parameter" name="filters[parameter]" class="form-control selectpicker" item-filter>
                    <option value="" selected>{{ trans('all.all') }}</option>
                    @foreach($parameters as $parameter)
                        <option value="{{$parameter->id}}" @if(isset($filters['parameter']) && $filters['parameter'] == $parameter->id) selected @endif>{{ __('gps.'.$parameter->slug) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="content-box__filter content-box__filter-period filter-ml-2">
                <label for="date" class="label-filter">{{ trans('all.period') }}</label>
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
            <div class="content-box__filter content-box__filter-username_search filter-ml-2">
                <input name="filters[search]" id="search" class="form-control input-autocomplete" placeholder="{{ trans('all.search') }}" value="@if(isset($filters['search'])){{$filters['search']}}@endif" autocomplete="off">
                <span id="searchclear">×</span>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>


    <div class="container-fluid analytics-gps-page">
        @if(empty($params_array))
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    @if($transports->count() == 0)
                        <h2>Нет подхоядщих автомобилей для выбора</h2>
                    @else
                        <h2>Необходимо выбрать авто</h2>
                    @endif
                </div>
            </div>
        @else
        <div class="row" id="gps">
            @foreach($params_array as $parameterId => $parameter)

                @if(count($params_array) == 1)
                    <div class="col-xs-12 col-sm-12 gps_block" id="gps_block_{{$parameterId}}">
                @else
                    <div class="col-xs-12 col-sm-6 gps_block" id="gps_block_{{$parameterId}}">
                @endif
                <a href="#" class="gps_block_move drag_block_move"></a>
                <a href="#" class="gps_block_open"></a>
                <div class="gps_block_inner">
                    @if(isset($params_array_last[$parameterId]))
                    <div class="gps_title">{{ __('gps.'.$params_array_last[$parameterId]->ioparam_slug) }} <small style="display: none;">id {{ $parameterId}}</small>
                        <span class="gps_title_value">{{ round($params_array_last[$parameterId]->ioparam_value, 2) }} {{$params_array_last[$parameterId]->ioparam_unit}}</span>
                    </div>
                    @endif
                    <canvas id="chart_{{$parameterId}}"></canvas>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

@endsection


@push('scripts')

@include('analytics.includes.graph')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $(function() {

        if ( $( "#gps" ).length ){
            var sortable = new Sortable(gps, {
                filter: ".gps_block_inner",
                onEnd: function (evt) {
//                    console.log(evt);
                    updSortEl();
                },
            });
        }

        function updSortEl(){

            let elements_sorted = {};

            $('.gps_block').each(function(index){
//                console.log($(this).attr('id'));
                let el_id = $(this).attr('id').split('_');
                elements_sorted[index] = el_id[2];
            });

            $.ajax({
                url     : '{{ route('analytics.transport') }}',
                type    : 'post',
                data    : {'position' : elements_sorted},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
                .done(function (data) {

                })
                .fail(function (data) {
                    console.warn(data);
                });
        }

        $('.gps_block_open').on('click', function(e){
            e.preventDefault();
            let parentEl = $(this).parent();
            let parentElId = parentEl.attr('id');

            if(parentEl.hasClass( 'col-sm-12' )){
                parentEl.removeClass('col-sm-12');
                parentEl.addClass('col-sm-6');
                return;
            }

            if(parentEl.hasClass( 'col-sm-6' )){
                parentEl.removeClass('col-sm-6');
                parentEl.addClass('col-sm-12');
                return;
            }
        });

        $('#daterange').on('change', function() {
            form_submit();
        });

        $('#filters_transport').on('change', function() {
            form_submit();
        });

        $('#filters_parameter').on('change', function() {
            form_submit();
        });

        $('#search').on('input',function(e){
            var name = $(this).val();
            if(name.length > 2){
                var url = '?filters[search]='+name;
                $.ajax({
                    url     : url,
                    type    : 'GET',
                    dataType: 'json',
                    headers: {
                        "cache-control": "no-cache, no-store"
                    },
                    success : function (data) {

                        console.log(data);

                        let list = '<div class="list-group autocomplete-result">';
                        $.each(data, function(key, value) {
//                            console.log(key);
//                            console.log(value);
                            list += '<a href="javascript://" class="list-group-item" data-type="'+key+'" data-name="'+key+'">'+value+'</a>';
                        });
                        list +=  '</div>';
                        $('#search').parent().append(list + '</div>');

                        $('.autocomplete-result a').bind('click', function () {

                            let type = $(this).attr('data-type');
                            type = type.split('_');
                            let typeKey = type[0];
                            let typeId = type[1];
                            let select = $('#filters_' + typeKey);
                            select.selectpicker('val', typeId);

//                            form_submit();
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
            $("#search").val('');
//            form_submit();
        });

        function form_submit() {
            var data = $('#formFilters').serialize();
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

        @foreach($params_array as $parameterId => $parameter)

        var chart_{{$parameterId}} = $('#chart_{{$parameterId}}');

        options = {
            tooltips: {enabled: false},
            hover: {mode: null},
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        offsetGridLines: true
                    }
                }]
            },
            plugins: {
                datalabels: {
                    // hide datalabels for all datasets
                    display: false
                }
            }
        };

        data = {
            labels: [{!! $parameter['datetime'] !!}],
            datasets: [{
                label: '',
                data: [{{$parameter['value']}}],
                backgroundColor: "#868686"
            }]
        };

        var barChart_{{$parameterId}} = new Chart(chart_{{$parameterId}}, {
            type: 'bar',
            data: data,
            options: options
        });

        @endforeach



    });
    </script>
@endpush