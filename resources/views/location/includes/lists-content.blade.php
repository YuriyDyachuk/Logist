<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active transition" id="transport">
        <?php
        $allTransports = collect(json_decode($transports));
        $transportsWithOrder = $allTransports->where('order_full', '!=', null)->where('order', '!=', null);
        ?>
        @forelse($allTransports as $transport)
            <div class="transport_item_wrap" data-id="{{ $transport->id }}">
                <a href="" class="link_type_window"></a>
                <div class="transport_item {{$transport->status ? 'transport_item_' . $transport->status : 'transport_item_free'}}">
                    <div class="row transport_driver_info">
                        <div class="text-left column col-sm-6">
                            <div class="primary">{{ $transport->name }}</div>
{{--                            <div class="muted">{{ trans('all.id') }} {{ $transport->id }}</div>--}}
                            @if ($transport->gps_params !== null && $transport->gps_params)
                                @foreach($transport->gps_params as $value)
                                    @if ($value->ioparam_value > 0 && $value->ioparam_slug === 'engine_speed')
                                        @if($transport->status == 'on_flight')
                                            <div style="color: #3B9B58" class="muted">{{ trans('all.id') }} {{ $transport->id }}</div>
                                        @else
                                        @endif
                                    @elseif($value->ioparam_value == 0 && $value->ioparam_slug === 'engine_speed')
                                        <div style="color: #031B4E" class="muted">{{ trans('all.id') }} {{ $transport->id }}</div>
                                    @endif
                                @endforeach
                            @else
{{--                                @if ($transport->location == false && $transport->location == '')--}}
                                    <div style="color: #DADADA" class="muted">{{ trans('all.id') }} {{ $transport->id }}</div>
                            @endif
                        </div>
                        @if (!empty($transport->driver))
                            <div class="text-right column col-sm-6">
                                <div class="primary">{{ $transport->driver }}</div>
                                <div class="muted">{{ $transport->driver_phone }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-left primary place">
{{--                        <div class="location_icon"></div>--}}
{{--                        <div class="location_title">--}}
{{--                        @if ($transport->location !== false && $transport->location !== '')--}}
{{--                            {{ $transport->location }}--}}
{{--                        @else--}}
{{--                            @if ($transport->lat !== null && $transport->lng !== null)--}}
{{--                                {{ $transport->lat }}, {{ $transport->lng }}--}}
{{--                            @else--}}
{{--                                {{ trans('all.no_gps_data') }}--}}
{{--                            @endif--}}
{{--                        @endif--}}
{{--                        </div>--}}
{{--                        <div class="icon-truck">--}}
{{--                            @if ($transport->gps_params !== null)--}}
{{--                                @foreach($transport->gps_params as $value)--}}
{{--                                    @if ($value->ioparam_value > 0 && $value->ioparam_slug === 'engine_speed')--}}
{{--                                        @if($transport->status == 'on_flight')--}}
{{--                                            <img style="width: 15%" src="{{ asset('main_layout/images/svg/truck-marker-ignition-on-active.svg') }}" alt="Truck">--}}
{{--                                        @else--}}
{{--                                            <img style="width: 15%" src="{{ asset('main_layout/images/svg/truck-marker-ignition-on-free.svg') }}" alt="Truck">--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">{{ trans('all.empty') }}</h2>
                </div>
            </div>
        @endforelse
        <div class="transport_item_empty" style="display: none">
            <div class="col-sm-12">
                <h2 class="text-center">{{ trans('all.empty') }}</h2>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade in transition" id="orders">
        @forelse($transportsWithOrder as $transportOrder)
            <div class="order_item_wrap" data-id="{{ $transportOrder->id }}">
                <div class="order_item">
                    <div class="row order_info">
                        <div class="text-left column col-sm-5">
                            <div class="block-order-info">
                                <div class="block-order-top">
                                    <div class="primary">
                                        № {{ $transportOrder->order_full->inner_id }}
                                        ({{ $transportOrder->order_full->id }})
                                    </div>
                                    <div class="muted">{{ $transportOrder->cargo }}</div>
                                </div>
                                <div class="block-order-bottom">
                                    <div class="primary">
                                        {{ $transportOrder->client }}
                                    </div>
                                    <div class="muted phone">
                                        {{ $transportOrder->client_phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-left column col-sm-7 addresses">
                            <div class="line-map">
                                <div class="point-download"></div>
                                @foreach($transportOrder->order_full->addresses as $address)
                                    @if(!$loop->first && !$loop->last)
                                        <div class="point-middle"
                                             data-toggle="tooltip"
                                             data-placement="right"
                                             title="{{ $address->address }}"
                                        ></div>
                                    @endif
                                @endforeach
                                <div class="point-upload"></div>
                            </div>
                            <div class="address loading">
                                {{ $transportOrder->order_full->addresses[0]->address ?? '' }}
                            </div>
                            <div class="address unloading">
                                {{ end($transportOrder->order_full->addresses)->address }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">{{ trans('all.empty') }}</h2>
                </div>
            </div>
        @endforelse
        <div class="order_item_empty" style="display: none">
            <div class="col-sm-12">
                <h2 class="text-center">{{ trans('all.empty') }}</h2>
            </div>
        </div>
    </div>
</div>