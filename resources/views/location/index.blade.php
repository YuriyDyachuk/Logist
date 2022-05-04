@extends('layouts.app')

@section("content")
    <div class="content-box locations">
        <div class="content-box__header">
            <div class="content-box__title">
                <h1 class="title-blue">{{trans('all.location')}}</h1>
            </div>
        </div>

        <div class="content-box__filters locations">
            <form id="formFilters" action="" class="/*form-inline*/">
                    <div id="search-box" class="content-box__filter-username_search content-box__filter">
                        <input name="filters[number]" type="hidden" value="0" id="search-trans-val">
                        <input type="text" id="search-trans" class="form-control filter-search search-number input-autocomplete"
                               placeholder="{{trans('all.placeholder_number')}}.." value="@if(isset($filters['number'])){{$filters['number']}}@endif" autocomplete="off">
                        <span id="searchclear" class="searchclear">×</span>
                        <div id="search-result" class="list-group"></div>
                    </div>
                    <div class="content-box__filter content-box__filter-status filter-ml-2">
                        <label for="filters[status]" class="label-filter">{{ trans('all.status') }}:</label>
                        <select name="filters[status]" class="form-control selectpicker">
                            <option value="0" selected>{{trans('all.all')}}</option>
                            <option value="6">{{trans('all.location_in_road')}}</option>
                            <option value="7">{{trans('all.free')}}</option>
                            <option value="13">{{trans('all.on_repair')}}</option>
                        </select>
                    </div>
                @if(!auth()->user()->isClient())
                    <div class="content-box__filter content-box__filter-status filter-ml-2">
                        <label for="filters[location]" class="label-filter">{{trans('all.system')}}:</label>
                        <select name="filters[location]" class="form-control selectpicker">
                            <option value="0" selected>{{trans('all.all')}}</option>
                            <option value="1">GPS</option>
                            <option value="2">APP</option>
                        </select>
                    </div>
                @endif

                <div class="content-box__filter content-box__filter-status filter-ml-2">
                    <div class="refresh-locations" id="button-refresh-locations" data-status="active"></div>
                </div>

                {{-- START OLD LEGEND --}}
                {{--
                <div class="legend content-box__filter content-box__filter-legend">
                    <span class="dot dot-blue">{{ trans('all.free') }}</span>
                    <span class="dot dot-green">{{ trans('all.location_in_road') }}</span>
                    <span class="dot dot-yellow">{{ trans('all.on_repair') }}</span>
                </div>
                --}}
                {{-- END OLD LEGEND --}}

{{--                <div style="display: flex;" class="dot dot-press"></div>--}}
                <div class="clearfix"></div>

                <div class="legend content-box__filter content-box__filter-legend">
                    <span class="icon icon-transport-free">{{ trans('all.free') }}</span>
                    <span class="icon icon-transport-on_flight">{{ trans('all.location_in_road') }}</span>
                    <span class="icon icon-transport-on_repair">{{ trans('all.on_repair') }}</span>
                </div>

                <div class="legend content-box__filter content-box__filter-legend">
                    <span class="circle circle-gps-not-installed">Нет GPS</span>
                    <span class="circle circle-engine-on">{{ trans('all.ignition_on') }}</span>
                    <span class="circle circle-engine-off">{{ trans('all.ignition_off') }}</span>
                    <span class="circle circle-lost-signal">Нет данных</span>
                </div>

                <div class="clearfix"></div>

            </form>

        </div>
        <div class="progress app-progress-bar">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                 style="width: 0%;"></div>
        </div>
        <div class="" id="map-container">

            @if(!auth()->user()->isClient())
            <div class="padding-right-0" id="locations-filters-list">
                @include('location.includes.lists')
            </div>
            @endif
            <div class="padding-left-0" id="locations-map" @if(auth()->user()->isClient()) style="margin-left: 0;" @endif>
                <div class="map-wrapper"  style="background: #fff; position: relative;">

                    <div class="map-modal"  id="mapModalCurrent" data-car="" data-status="">
                        <div id="modal-close-wrap">
                            <a href="" id="modal-close" class="pull-right modal-close"></a>
                        </div>

                        <div class="title modal-info-block-separated">
                            <h3 class="title-cargo-info-order modal-with-order">
                                {{trans('all.order')}}
                                <span id="order_id"></span>
                            </h3>
                            <h3 class="title-cargo-info-no-order modal-no-order" style="display: none;">
                                {{trans('all.no_order_right_now')}}
                            </h3>
                        </div>
                        @php
                            if($position === false){
                                $blocks_array = ['1', '2', '3', '4'];
                            } else {
                                $blocks_array = $position;
                            }
                        @endphp

                        @foreach($blocks_array as $block)
                            @includeIf('location.includes.block_pos_'.$block)
                        @endforeach
                    </div>

                    <div class="map-modal"  id="mapModalRoute" data-car="" data-status="">
                        <div id="modal-close-wrap">
                            <a href="" id="modal-close" class="pull-right modal-close"></a>
                        </div>
                        <div class="title">
                            <h3 class="title-cargo-info-order">
                                Запросить маршрут
                            </h3>
                        </div>

                        <div class="">
                            <div class="sub-title">

                            </div>
                        </div>

                        <div class="title-cargo-info modal-info-block modal-info-block-separated">
                            <div class="mb-1 modal-with-order">
                                <div class="info-row" style="width: 95%">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            от
                                            <input name="fromRouteDate" id="fromRouteDate" class="datetimepicker form-control" autocomplete="off">
                                        </div>
                                        <div class="col-xs-6">
                                            до
                                            <input name="toRouteDate" id="toRouteDate" class="datetimepicker form-control" autocomplete="off" data-date-orientation="auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-info-block modal-info-block-separated">
                            <div class="">
                                <div class="sub-title">

                                </div>
                            </div>

                            <div class="mb-1 modal-with-order text-center">
                                <button id="getRoute" class="btn button-style2">{{ trans('all.apply') }}</button>
                            </div>
                        </div>
                    </div>

                    <div id="menu-show" style="display: none;"></div>
                    <div id="map" style="height: 609px" class="map-locations"></div>
                    <div class="clearfix"></div>

                    <!-- Legend box for mobile device -->
                    <div class="legend-box">
                        <div class="legend mobile hidden">
                            <span class="dot dot-blue">{{ trans('all.free') }}</span>
                            <span class="dot dot-green">{{ trans('all.location_in_road') }}</span>
                            <span class="dot dot-yellow">{{ trans('all.on_repair') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trip details -->
        {{--<div id="trip_details" class="clearfix hidden">--}}

            {{--<div id="cargo_details">--}}
                {{--<div class="tab-pane_col-left">--}}
                    {{--<h2 class="h2 title-black">Информация о рейсе</h2>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>ГРУЗ:</label>--}}
                    {{--<span>Молоко</span>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>ТРАНСПОРТ:</label>--}}
                    {{--<span>RENO AE1523AE</span>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>ВОДИТЕЛЬ:</label>--}}
                    {{--<span>Шевченко Михаил <i>+380684949653</i></span>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div id="address_details" class="">--}}

                {{--<div class="tab-pane_col-left">--}}
                    {{--<h2 class="h2 title-black">Местонахождение</h2>--}}
                {{--</div>--}}

                {{--<div class="tab-pane_col-right">--}}
                    {{--<div class="address-point address-point__first">--}}
                        {{--<span id="address-point__date">23/01/2019 19:30</span>--}}
                        {{--<br>--}}
                        {{--<span id="address-point__address">вул. Наукова, Дніпро, Дніпровська область, Украина, 52071</span>--}}
                    {{--</div>--}}

                    {{--<div class="address-point address-point__middle">--}}
                        {{--<span id="address-point__date">22/01/2019 19:31</span>--}}
                        {{--<br>--}}
                        {{--<span id="address-point__address">вул. Шинна, Дніпро, Дніпровська область, Украина, 49000</span>--}}
                    {{--</div>--}}

                    {{--<div class="address-point address-point__middle">--}}
                        {{--<span id="address-point__date">20/01/2019 19:31</span>--}}
                        {{--<br>--}}
                        {{--<span id="address-point__address">просп. Олександра Поля, Дніпро, Дніпровська область, Украина, 49000</span>--}}
                    {{--</div>--}}

                    {{--<div class="address-point address-point__last">--}}
                        {{--<span id="address-point__date">19/01/2019 19:31</span>--}}
                        {{--<br>--}}
                        {{--<span id="address-point__address">просп. Пушкіна, Дніпро, Дніпровська область, Украина, 49000</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}

            {{--<div id="payment_details" class="">--}}
                {{--<div class="tab-pane_col-left">--}}
                    {{--<h2 class="h2 title-black">Информация об оплате</h2>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>СУММА ОПЛАТЫ:</label>--}}
                    {{--<span>15.000 грн</span>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>ТИП ОПЛАТЫ:</label>--}}
                    {{--<span>Банковский счет</span>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>УСЛОВИЯ ОПЛАТЫ:</label>--}}
                    {{--<span>По оригиналам</span>--}}
                {{--</div>--}}
                {{--<div class="tab-pane_col-row">--}}
                    {{--<label>КЛИЕНТ:</label>--}}
                    {{--<span>Trattfort</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}


        {{-- TEMPLATE BLOCK BEGIN --}}
        <div id="address_default" class="hidden">
            <div id="address_default__first">

            </div>
            <div class="address-point address-point__first address-point__loading">
                <div class="address-point__first"></div>
                <span id="address-point__date"></span><br>
                <span id="address-point__address"></span>
            </div>
            <div class="address-point address-point__middle">
                <span id="address-point__date"></span><br>
                <span id="address-point__address"></span>
            </div>
            <div class="address-point address-point__last address-point__uploading">
                <span id="address-point__date"></span><br>
                <span id="address-point__address"></span>
            </div>
        </div>
        {{-- TEMPLATE BLOCK END --}}

        <div id="progress_default" class="hidden">
            <div class="mb-1 progress_item">
                <span class="progress_item-as as"></span>
                <div class="progress-info">
                    <span class="progress-name"></span><br/>
                    <span class="progress-date"></span><br/>
                    <span class="progress-address"></span><br/>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="{{ url('main_layout/js/location_map.js') }}"></script>
    <script src="{{ url('main_layout/js/location_modal.js') }}"></script>
    <script>

        $(function() {

            if ($("#mapModalCurrent").length) {
                var sortable = new Sortable(mapModalCurrent, {
                    draggable: ".draggable",
                    onEnd: function (evt) {
                    console.log(evt);
                        updSortEl();
                    },
                });
            }
        });


        function updSortEl(){

            let elements_sorted = {};

            $('.draggable').each(function(index){
                let el_id = $(this).attr('id').split('__');
                elements_sorted[index] = el_id[1];
            });

            $.ajax({
                url     : '{{ route('location.position') }}',
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

        let Transports   = $.parseJSON(JSON.stringify({!! $transports !!}));
        let Errors       = $.parseJSON(JSON.stringify({!! $errors !!}));

        if ('globus' in Errors) {
            console.warn('Warning: ', Errors.globus);
        }

        function initMap() {
            location_map.initMap();
        }

        function getInfoWindowHtml(el) {
            return `
            <div id="info-${el.id}" class="info-map-window">
                <div class="title">ID ${el.id} ${el.lng}, ${el.lat}</div>
                <div><i class="fa fa-truck"></i>${el.name}</div>
                {{--<div><span class="speed-meter"></span>${el.speed} {{trans('all.km_h')}}</div>--}}
                <div><i class="fa fa-user"></i>${el.driver || '-'}</div>
                <div><i class="cargo-icon"></i>${el.order ? '#' + el.order + ' - ' + el.cargo : '-'}</div>
            </div>`;
        }

        function modalUpdate(el) {
            let html = '';
            $('.progress-block').html('');
            $('.address-block ').empty();

            if(el.gps_params.length !== 0 && el.gps_params !== null ) {

                $('.params-app-gps-no').hide();

                if(el.monitoring = 'gps'){
                    $('.params-gps').find('#value_full_all').text(Math.trunc(el.gps_params[0].ioparam_value* 100) /100 + ' ' + el.gps_params[0].ioparam_unit);
                    $('.params-gps').find('#value_oil').text(Math.trunc(el.gps_params[1].ioparam_value* 100) /100 + ' ' + el.gps_params[1].ioparam_unit);
                    $('.params-gps').find('#value_engine').text(Math.trunc(el.gps_params[2].ioparam_value* 100) /100 + ' ' + el.gps_params[2].ioparam_unit);
                    $('.params-gps').find('#сabin_temperature').text(Math.trunc(el.gps_params[3].ioparam_value* 100) /100 + ' ' + el.gps_params[3].ioparam_unit);
                    $('.params-gps').find('#engine_speed').text(Math.trunc(el.gps_params[4].ioparam_value* 100) /100 + ' ' + el.gps_params[4].ioparam_unit);
                    $('.params-gps').find('#value_mileage').text(Math.trunc(el.gps_params[5].ioparam_value* 100) /100 + ' ' + el.gps_params[5].ioparam_unit);
                    $('.params-gps').find('#value_weight_ts').text(Math.trunc(el.gps_params[6].ioparam_value* 100) /100 + ' ' + el.gps_params[6].ioparam_unit);
                    $('.params-gps').find('#value_tachograph').text(Math.trunc(el.gps_params[7].ioparam_value* 100) /100 + ' ' + el.gps_params[7].ioparam_unit);
                    $('.params-gps').find('#value_sum_fuel').text(Math.trunc(el.gps_params[8].ioparam_value* 100) /100 + ' ' + el.gps_params[8].ioparam_unit);

                    $('.params-app').hide();
                    $('.params-gps').show();
                } else {
                    // if GPS APP
                }

            }else{
                $('.params-gps .value_primary').text('');

                // GPS
                $('.params-app-gps-no').show();
                $('.params-app').hide();
                $('.params-gps').hide();
            }

            if(el.order !== null && el.order_full !== null) {

                let d;
                let date_format_at;

                addresses_amount = el.order_full.addresses.length;
                $.each(el.order_full.addresses, function (key, value) {

                    if (key == 0) {
                        // first loading point
                        $('#address_default').find('.address-point__first').find('#address-point__address').html(value.address);

                        d = new Date(value.pivot.date_at);
                        date_format_at =
                            (d.getDate() < 10 ? '0' : '') + d.getDate() + '/' +
                            ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1) + '/' +
                            d.getFullYear() + ' ' +
                            (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' +
                            (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();

                        $('#address_default').find('.address-point__first').find('#address-point__date').html(date_format_at);

                        html = $('#address_default').find('.address-point__first').clone();
                        $('.address-block').append(html);
                    } else if (key == (addresses_amount - 1)) {

                        // last uploading point
                        $('#address_default').find('.address-point__last').find('#address-point__address').html(value.address);
                        d = new Date(value.pivot.date_at);
                        date_format_at =
                            (d.getDate() < 10 ? '0' : '') + d.getDate() + '/' +
                            ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1) + '/' +
                            d.getFullYear() + ' ' +
                            (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' +
                            (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();


                        $('#address_default').find('.address-point__last').find('#address-point__date').html(date_format_at);

                        html = $('#address_default').find('.address-point__last').clone();
                        $('.address-block').append(html);
                    } else {
                        // middle loading/uploading point
                        $('#address_default').find('.address-point__middle').find('#address-point__address').html(value.address);
                        d = new Date(value.pivot.date_at);
                        date_format_at =
                            (d.getDate() < 10 ? '0' : '') + d.getDate() + '/' +
                            ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1) + '/' +
                            d.getFullYear() + ' ' +
                            (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' +
                            (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();

                        $('#address_default').find('.address-point__middle').find('#address-point__date').html(date_format_at);

                        $('#address_default').find('.address-point__middle').removeClass('address-point__middle__loading address-point__middle__uploading');

                        if (value.pivot.type == 'unloading') {
                            $('#address_default').find('.address-point__middle').addClass('address-point__middle__uploading');
                        }

                        if (value.pivot.type == 'loading') {
                            $('#address_default').find('.address-point__middle').addClass('address-point__middle__loading');
                        }

                        html = $('#address_default').find('.address-point__middle').clone();
                        $('.address-block').append(html);
                    }

                });

                if (el.order_full.progress !== null && el.order_full.progress !== undefined) {
                    $.each(el.order_full.progress, function (key, value) {
                        if (value.completed === '0') {
                            $('#progress_default').find('.progress_item-as').addClass('as-' + value.type);
                        } else {
                            $('#progress_default').find('.progress_item-as').removeClass('as');
                            $('#progress_default').find('.progress_item-as').addClass('checked-item');
                        }

                        d = new Date(value.date_at);
                        if (value.date_at === '__/__/____' || value.date_at === null || value.date_at === undefined) {
                            date_format_at = '__/__/____';
                        } else {
                            date_format_at =
                                (d.getDate() < 10 ? '0' : '') + d.getDate() + '/' +
                                ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1) + '/' +
                                d.getFullYear() + ' ' +
                                (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' +
                                (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
                        }

                        $('#progress_default').find('.progress-date').html(date_format_at);

                        if (value.name === '' || value.name === null) {
                            $('#progress_default').find('.progress-name').html('-');
                        } else {
                            $('#progress_default').find('.progress-name').html(value.name);
                        }
                        if (value.address === '' || value.address === null) {
                            $('#progress_default').find('.progress-address').html('-');
                        } else {
                            $('#progress_default').find('.progress-address').html(value.address);
                        }

                        html = $('#progress_default').find('.progress_item').clone();
                        $('.progress-block').append(html);
                        if (value.completed === '0') {
                            $('#progress_default').find('.progress_item-as').removeClass('as-' + value.type);
                        } else {
                            $('#progress_default').find('.progress_item-as').addClass('as');
                            $('#progress_default').find('.progress_item-as').removeClass('checked-item');
                        }
                    });
                }

                $('#order_id').text('#'+el.order);
                $('#value_cargo').text(el.cargo);
                $('#value_amount_plan span.value').text(el.amount_plan);
                $('#value_payment_type').text(el.payment_type);
                $('#value_payment_term').text(el.payment_term);
                $('#value_client').text(el.client);
                $('.modal-with-order').show();
                $('.modal-no-order').hide();
//                $('.row-address').show();
//                $(".map-modal").css("height", "");
            } else {
                $('#order_id').text('');
                $('#value_cargo').text('{{trans('all.free_cargo')}}');
                $('#value_amount_plan span.value').text('-');
                $('#value_payment_type').text('-');
                $('#value_payment_term').text('-');
                $('#value_client').text('-');
                $('.modal-with-order').hide();
                $('.modal-no-order').show();
//                $('.row-address').hide();
//                $('.map-modal').height('480');
            }

            $('#value_transport').text(el.name);
            $('#value_transport_id').text(el.id);
            $('#value_driver').text(el.driver);

            let block_2_location_coordinates = $('.block-2-location #value_location_coordinates');

            block_2_location_coordinates.hide();

            let location = getLocation(el.lat, el.lng, el.id);
            console.log(location);

            if (location) {
                $('#value_location_current').text(location);

                if (el.lat !== null && el.lng !== null) {
                    block_2_location_coordinates.show().text(el.lat + ' , ' + el.lng);
                }

            } else {
                if (el.lat !== null && el.lng !== null) {
                    $('#value_location_current').text(el.lat + ' , ' + el.lng);
                } else {
                    $('#value_location_current').text('-');
                }
            }
            $('#value_speed').text(el.speed);

            $('#value_odometer').text('-');
            $('#value_fuel').text('-');
            $('#value_ignition').text('-');

            if(el.data === null){
                $('.gps').hide();
                $('.no-gps').show();
            }
            else {

                if(el.odometer !== ''){
                    $('#value_odometer').text(el.odometer);
                }
                else {
                    $('#value_odometer').text('-');
                }

                if(el.fuel !== ''){
                    $('#value_fuel').text(el.fuel);
                }
                else {
                    $('#value_fuel').text('-');
                }

                var data = JSON.parse(el.data);

                $.each(data, function(index, value) {

                    if(value.num === '0'){
                        //Бортсеть
                        $('#value_boardvoltage').text(value.scaledValue);
                    }

                    if(value.num === '10'){
                        // t° ДВС
                        $('#value_engine_temperature').text(value.scaledValue);
                    }

                    if(value.num === '11'){
                        // Обороты ДВС
                        $('#value_engine_speed').text(value.scaledValue);
                    }

                    if(value.num === '2'){
                        // t° G7
                        $('#value_tg7').text(value.scaledValue);
                    }

                    if(value.num === '5'){
                        // Спутники
                        $('#value_satellites').text(value.scaledValue);
                    }

                });


                if(el.ignition == 1){
                    $('#value_ignition').text('{{trans('all.ignition_on')}}');
                }
                else {
                    $('#value_ignition').text('{{trans('all.ignition_off')}}');
                }
                $('.gps').show();
                $('.no-gps').hide();
            }

            $('#mapModalCurrent').attr('data-car', el.id);

            $('#mapModalCurrent').show();
        }


        function getLocation(lat, lng, transport_id)
        {
            let address;

            $.ajax({
                url: '{{route('location.ajax')}}',
                type: 'POST',
                dataType: 'JSON',
                async: false,
                data:{
                    action : 'getAddressByCoordinat',
                    lat : lat,
                    lng : lng,
                    transport_id : transport_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                },
                success: function (response) {
                    address = response.data;
                    console.log(address);
                },
                error: function (data) {
                }
            });

            console.log(address);

            return address;
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&callback=initMap"></script>
@endpush