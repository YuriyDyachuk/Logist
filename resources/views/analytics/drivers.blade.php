@extends('layouts.app')
@section('content')
    <div class="content-box analytics-page">

        <!-- Page filters -->
        @include('analytics.partials.nav')

        @if(checkPaymentAccess('analytics_driver'))

        <div class="content-box__body-tabs page-request-filter-nav" style="">
            <!-- Tab navigation: BEGIN -->
            <ul class="nav nav-tabs tablist transition tablist-driver" role="tablist" id="rowTab2">
                <li role="presentation" class="transition active">
                    <a href="#driver_analytics" role="tab" data-toggle="tab">{{ trans('all.analytics') }}</a>
                </li>
                <li role="presentation" class="transition">
                    <a href="#driver_reports" role="tab" data-toggle="tab">{{ trans('all.reports') }}</a>
                </li>
                <!-- -->
            </ul>
            <!-- Tab navigation: END -->
        </div>

        {{--<div class="app-progress-group">--}}

            <!-- Tab panes -->
            <div class="tab-content analytics-driver-page" style="margin-top: 6px">
                <div class="progress app-progress-bar">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                         aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div role="tabpanel" class="tab-pane active" id="driver_analytics">
                    <div id="driver_analytics_box" class="">
                        @include('analytics.partials.drivers_analytics')
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="driver_reports">

                    <div id="driver_reports_box" class="">
                        @include('analytics.partials.drivers_report')
                    </div>
                </div>
            </div>

        {{--</div>--}}






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
        $(function() {

            $('.tablist-driver a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab

                let url = $(e.target).attr('href');

                if (window.completedAjax) {
                    if (typeof window.progressBar === "function") {
                        window.progressBar(70);
                    }

                    if (typeof window.progressBar === "function") {
                        window.progressBar(100);
                    }
                }

            });



            $('#testimonial_wrapper').on('click', '.page-item a',function (e) {
                e.preventDefault();
                var url = $(e.target).attr('href');

                $.get(url)
                    .done(function (data) {
                        if (data.status === 'ok') {
                            $('#testimonial_wrapper').html(data.html);
                        }
                    })
                    .fail(function (data) {
                        console.log(data);
                    })
                    .always(function () {

                    });
            });


            var w = $('body').width();

            if(w >= 650) {

                var col_1 = 0;
                $('#col-1 .workstat_block').each(function (index) {
                    console.log($(this).outerHeight());
                    col_1 = col_1 + $(this).outerHeight();
                });

                var col_2 = $('#col-2').outerHeight();

                if (col_1 > col_2) {
                    $('#col-2').outerHeight(col_1-8);
                }
            }

            $('#updVar').on('click',function(e){
                e.preventDefault();

                let type = $('#parameter_type').val();
                let parameter_value = $('#parameter_value').val();
                let driver_id = $('#userid').val();
                let daterange = $('#daterange').val();

                console.log('d'+driver_id);

                $.ajax({
                    url     : '{{route('analytics.drivers.upd')}}',
                    type    : 'post',
                    data    : {'parameter' : type, 'value' : parameter_value, 'driver_id' : driver_id, 'daterange' : daterange},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (data) {
                        console.log(data.result);

                        if(data.result !== false){
                            $.each(data.result, function( index, value ) {
                                $('#parameter_'+index).text(value)
                            });
                        }
                    },
                    error   : function (data) {
                        console.log(data)
                    }
                });

                $('#innlogist-modal').modal('hide');
            });


            $('#innlogist-modal').on('show.bs.modal', function (e) {
                var type= $(e.relatedTarget).attr('data-type');

                var re = /parameter_/gi;
                type = type.replace(re, '');

                $('#parameter_value').val('');
                $('#parameter_type').val(type);
            });

            $('#daterange').on('change', function() {
                form_submit();
            });

            $('#username').on('input',function(e){
                var name = $(this).val();
                if(name.length > 2){
                    var url = '?filters[name]='+name;
                    $.ajax({
                        url     : url,
                        type    : 'GET',
                        dataType: 'json',
                        success : function (data) {
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
            $('input[name="filters[dates]"]').val('<?php echo $start;?>-<?php echo $end;?>')
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
                var data = $('#formAnalyticsFilters, #formFilters').serialize();
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
                        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
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

            var options = {
                responsive: true,
                tooltips: {enabled: false},
                hover: {mode: null},
                cutoutPercentage: 70,
                rotation: 1.5,
                elements: {
                    center: {
                        text: '99% {{ trans('all.on_time') }}',
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

            var ctx = $('#chart1');

            data1 = {
                datasets: [{
                    data: [1,99],
                    backgroundColor: ['#ffffff', '#00cf3e'],
                }],
                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: {}
            };

            var chart1 = new Chart(ctx, {
                type: 'doughnut',
                data: data1,
                options: options,
            });
        });
    </script>
@endpush