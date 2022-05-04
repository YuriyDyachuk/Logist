<div id="newOrder">
    <div id="editOrderAddress">
        <div id="step-1" class="editOrder">
            <input type="hidden" name="route_polyline" value="">
            <input type="hidden" name="direction_waypoints" value="{!! $order->direction_waypoints ?? '[]' !!}">
            <input type="hidden" name="orderID" id="orderID" value="{{$order->id}}">

            <div class="points-container">

                <!-- dop info img -->
                <div class="dop-img-show"></div>
                <!-- end dop info  -->

                {{-- THE POINT LOADING --}}
                <div class="row point-box with-marker-loading point-box-loading" data-item="0">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="loading_date">{{ trans('all.date_loading') }}</label>
                        <input type="text" class="datetimepickerTime date-start form-control duplicate"
                               name="points[loading][0][date_at]" value=""
                               data-marker-update=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                        <div class="duplicate-error text-danger">{{ trans('all.create_date_duplicate') }}</div>
                        <small id="error_loading_0_date_at" class="text-danger  box_error_loading_date_at"></small>
                    </div>
                    <div class="group col-xs-8">
                        <label class="control-label" for="">{{ trans('all.loading_address') }}</label>
                        {{-- hidden --}}
                        <input type="hidden" name="points[loading][0][address_id]"
                               data-marker-update=""
                               data-address="loading"
                        >
                        <input type="text" class="form-control autocomplete duplicate-address"
                               name="points[loading][0][address]" value=""
                               onClick="this.select();"
                               placeholder="{{ trans('all.placeholder_address') }}" required>
                        <input type="hidden" class="hidden-prev-address">
                        <input type="hidden" class="hidden-prev-place-id">
                        <small class="duplicate-error-address text-danger">{{ trans('all.create_address_duplicate') }}</small>
                        <small id="error_loading_0_address" class="text-danger box_error_loading_address"></small>
                    </div>
                </div>

                @php
                    //TODO uncomment later
                @endphp
                {{--<div class="create-point" data-type="loading">--}}
                    {{--<a href="javascript://">{{ trans('all.create_point_loading') }}</a>--}}
                {{--</div>--}}

                {{-- THE POINT UNLOADING --}}
                <div class="row point-box with-marker-unloading point-box-unloading" data-item="0">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="download_date">{{ trans('all.date_unloading') }}</label>
                        <input type="text" class="datetimepickerTime form-control duplicate"
                               name="points[unloading][0][date_at]" value=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                        <div class="duplicate-error text-danger">{{ trans('all.create_date_duplicate') }}</div>
                        <small id="error_unloading_0_date_at" class="text-danger box_error_unloading_date_at"></small>
                    </div>
                    <div class="group col-xs-8">
                        <label class="control-label"
                               for="">{{ trans('all.unloading_address') }}</label>
                        {{-- hidden --}}
                        <input type="hidden" name="points[unloading][0][address_id]"
                               data-marker-update=""
                               data-address="unloading"
                        >
                        <input type="text" class="form-control autocomplete duplicate-address"
                               name="points[unloading][0][address]" value=""
                               onClick="this.select();"
                               placeholder="{{ trans('all.placeholder_address') }}" required>
                        <input type="hidden" class="hidden-prev-address">
                        <input type="hidden" class="hidden-prev-place-id">
                        <small class="duplicate-error-address text-danger">{{ trans('all.create_address_duplicate') }}</small>
                        <small id="error_unloading_0_address" class="text-danger box_error_unloading_address"></small>
                    </div>
                </div>

                @php
                    //TODO uncomment later
                @endphp
                {{--<div class="create-point" data-type="unloading">--}}
                    {{--<a href="javascript://">{{ trans('all.create_point_unloading') }}</a>--}}
                {{--</div>--}}

            </div>
            @if(isset($order->duration))
                @php
                    $finishTime = strtotime($order->addresses->first()->pivot->date_at) + $order->duration;
                @endphp
                <div class="row">
                    <div class="col-xs-12 group" style="margin-bottom: 0">
                        <label class="control-label"
                               for="estimated_arrival">{{ trans("all.date_estimated_arrival") }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 group">
                        <input type="text" id="estimated_arrival" name="estimated_arrival" class="col-xs-4 col-sm-4 datetimepickerTime form-control" value="{{date("d/m/Y H:i", $finishTime)}}" disabled>
                    </div>
                </div>
            @endif

            {{--
            <div class="points-container">

                        @php
                        $key = 0;
                        @endphp
                        @foreach($order->addresses as $address)

                            @if($address->pivot->type != 'loading')
                                @continue
                            @endif

                            <div class="row point-box with-marker-loading point-box-loading" data-item="{{$key}}">
                                <div class="col-xs-4 group">
                                    <label class="control-label" for="loading_date">{{ trans('all.date_loading') }}</label>
                                    <input type="text" class="datetimepickerTime date-start form-control"
                                           name="points[loading][{{$key}}][date_at]" value="{{ $address->pivot->date_at }}"
                                           data-marker-update=""
                                           placeholder="ДД/ММ/ГГГГ" required>
                                </div>
                                <input type="hidden" class="lat" value="{{ $address->lat }}">
                                <input type="hidden" class="lng" value="{{ $address->lng }}">
                                <div class="group col-xs-8">
                                    <label class="control-label" for="">{{ trans('all.loading_address') }}</label>

                                    <input type="hidden" name="points[loading][{{$key}}][address_id]"
                                           data-marker-update=""
                                           data-address="loading"
                                           value="{{ $address->pivot->address_id }}"
                                    >
                                    <input type="text" class="form-control autocomplete"
                                           name="points[loading][{{$key}}][address]" value="{{ $address->address }}"
                                           onClick="this.select();"
                                           placeholder="Введите адрес" required>
                                </div>

                                @if($key != 0)
                                    <div class="delete-point" onclick="detachPoint(event)"></div>
                                @endif

                            </div>
                                @php
                                $key++;
                                @endphp
                        @endforeach
                        <div class="create-point" data-type="loading">
                            <a href="javascript://">{{ trans('all.create_point_loading') }}</a>
                        </div>

                        @php
                        $key = 0;
                        @endphp

                        @foreach($order->addresses as $address)

                            @if($address->pivot->type != 'unloading')
                                @continue
                            @endif

                            <div class="row point-box with-marker-unloading point-box-unloading" data-item="{{$key}}">
                                <div class="col-xs-4 group">
                                    <label class="control-label" for="download_date">{{ trans('all.date_unloading') }}</label>
                                    <input type="text" class="datetimepickerTime form-control"
                                           name="points[unloading][{{$key}}][date_at]" value="{{ $address->pivot->date_at }}"
                                           placeholder="ДД/ММ/ГГГГ" required>
                                </div>
                                <input type="hidden" class="lat" value="{{ $address->lat }}">
                                <input type="hidden" class="lng" value="{{ $address->lng }}">
                                <div class="group col-xs-8">
                                    <label class="control-label"
                                           for="">{{ trans('all.unloading_address') }}</label>

                                    <input type="hidden" name="points[unloading][{{$key}}][address_id]"
                                           data-marker-update=""
                                           data-address="unloading"
                                           value="{{ $address->pivot->address_id }}"
                                    >
                                    <input type="text" class="form-control autocomplete"
                                           name="points[unloading][{{$key}}][address]" value="{{ $address->address }}"
                                           onClick="this.select();"
                                           placeholder="Введите адрес" required>
                                </div>

                                @if($key != 0)
                                    <div class="delete-point" onclick="detachPoint(event)"></div>
                                @endif

                            </div>

                            @php
                            $key++;
                            @endphp
                        @endforeach


                        <div class="create-point" data-type="unloading">
                            <a href="javascript://">{{ trans('all.create_point_unloading') }}</a>
                        </div>

            </div>
            --}}
        </div>
        <div class="clearfix"></div>
    </div>
</div>