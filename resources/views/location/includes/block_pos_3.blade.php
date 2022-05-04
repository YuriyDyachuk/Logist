<div class="draggable" id="pos__3">
    <a href="#" class="drag_block_move" draggable="false"></a>

    <div class="mb-1 modal-no-gps-params">
        <div class="sub-title">
            {{ trans('all.gps_data') }} :
        </div>
    </div>

    <div class="title-route-info modal-info-block params-app">
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.speed')}}:</span>
                <span id="value_speed" class="value primary"></span>
                {{trans('all.km_h')}}
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.ignition')}}:</span>
                <span id="value_ignition" class="value primary"></span>
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_odometer')}}:</span>
                <span id="value_odometer" class="value primary"></span>
                {{trans('all.km')}}
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_fuel')}}:</span>
                <span id="value_fuel"  class="value primary"></span>
                {{trans('all.liter')}}
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_boardvoltage')}}:</span>
                <span id="value_boardvoltage" class="value primary"></span>
                {{trans('all.gps_boardvoltage_volt')}}
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_engine_temperature')}}:</span>
                <span id="value_engine_temperature" class="value primary"></span>
                {{trans('all.gps_temperature')}}
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_engine_speed')}}:</span>
                <span id="value_engine_speed" class="value primary"></span>
            </div>
        </div>
        <div class="mb-1 gps">
            <div class="info-row">
                <span class="title-row">t° G7:</span>
                <span id="value_tg7"  class="value primary"></span>
                {{trans('all.gps_temperature')}}
            </div>
        </div>
        <div class="mb-2 gps">
            <div class="info-row">
                <span class="title-row">{{trans('all.gps_satellites')}}:</span>
                <span id="value_satellites" class="value primary"></span>
            </div>
        </div>
    </div>

    <div class="title-route-info modal-info-block params-app-gps-no modal-info-block-separated">
        <div class="no-gps mb-2">
            <div class="info-row">
                <span class="primary">{{ trans('all.no_gps_data') }}</span>
            </div>
        </div>
    </div>

    <div class="title-route-info modal-info-block params-gps modal-info-block-separated">
        {{--<div class="">--}}
            {{--<div class="sub-title">--}}
                {{--{{ trans('all.gps_params') }}--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="title-params-info modal-info-block">
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.fuel_level')}}:</span>
                    <span id="value_full_all" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.oil_level')}}:</span>
                    <span id="value_oil" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.engine_temperature')}}:</span>
                    <span id="value_engine" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps" style="display: none;">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.сabin_temperature')}}:</span>
                    <span id="сabin_temperature" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.engine_speed')}}:</span>
                    <span id="engine_speed" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.mileage')}}:</span>
                    <span id="value_mileage" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.weight_ts')}}:</span>
                    <span id="value_weight_ts" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.speed_by_tachograph')}}:</span>
                    <span id="value_tachograph" class="value_primary"></span>
                </div>
            </div>
            <div class="mb-1 modal-with-gps">
                <div class="info-row">
                    <span class="title-row">{{trans('gps.sum_fuel_consumption_l')}}:</span>
                    <span id="value_sum_fuel" class="value_primary"></span>
                </div>
            </div>
        </div>
    </div>

</div>