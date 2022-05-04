<div class="content-box order-page order-client-search-page" style="padding: 0">
    {{--<div class="content-box__body">--}}
        <div class="content-box__row-footer order__info" style="margin-bottom: 15px;">
            <div class="box">
                <span class=""><strong>{{ trans('all.request_process') }}</strong></span>
                <span class=""><strong>{{ $order->getOffers()->count() }} {{ trans('all.request_amount_offers') }}</strong></span>
                <span class=""><strong>{{ $order->suitableOffers->first() ? $order->suitableOffers->first()->amount : 0 }} {{ trans('all.request_amount_offers_companies') }}</strong></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7 order__container" >
                <div class="order__info">
                    <h2 class="h2 title-black">{{ trans('all.flight_information') }}</h2>
                    <input type="hidden" name="route_polyline"
                           value="">
                    <input type="hidden" name="orderID" id="orderID" value="{{$order->id}}">

                    <div class="points-container">

                        <div class="row" data-item="0">
                            <div class="col-sm-4 group__wrapper">
                                <label class="control-label" for="loading_date">{{ trans('all.date_loading') }}</label>
                                <input type="text" class="datetimepickerTime date-start form-control duplicate"
                                       name="points[loading][0][date_at]" value="{{ \Carbon\Carbon::parse($order->addresses->first()->pivot->date_at)->format('d/m/Y H:i') }}" data-marker-update="" placeholder="ДД/ММ/ГГГГ" required="" disabled>
                                <div class="duplicate-error text-danger">Дублирование даты</div>
                                <small id="error_loading_0_date_at" class="text-danger  box_error_loading_date_at"></small>
                            </div>
                            <div class="group col-sm-8 group__wrapper point-box with-marker-loading point-box-loading">
                                <label class="control-label" for="">{{ trans('all.unloading_address') }}</label>

                                <input type="hidden" name="points[loading][0][address_id]" data-marker-update="0"
                                       data-address="loading" value="6">
                                <input type="text" class="form-control autocomplete duplicate-address"
                                       name="points[loading][0][address]" value="{{ $order->addresses->first()->address }}" onclick="this.select();" placeholder="Введите адрес" required="" disabled="">
                                <small class="duplicate-error-address text-danger">Дублирование адреса</small>
                                <small id="error_loading_0_address" class="text-danger box_error_loading_address"></small>
                            </div>

                            @php
                            /*
                            <div class="group col-sm-offset-4 col-sm-8 group__wrapper point-box with-marker-loading point-box-loading">
                                <label class="control-label" for="">Промежуточная точка</label>

                                <input type="hidden" name="points[loading][0][address_id]" data-marker-update="0"
                                       data-address="loading" value="6">
                                <input type="text" class="form-control autocomplete duplicate-address"
                                       name="points[loading][0][address]" value="" onclick="this.select();"
                                       placeholder="Введите адрес" required="">
                                <small class="duplicate-error-address text-danger">Дублирование адреса</small>
                                <small id="error_loading_0_address" class="text-danger box_error_loading_address"></small>
                            </div>
                            */
                            @endphp
                        </div>

                        <div class="row " data-item="0">
                            <div class="col-sm-4 group__wrapper">
                                <label class="control-label" for="download_date">{{ trans('all.date_unloading') }}</label>
                                <input type="text" class="datetimepickerTime form-control duplicate"
                                       name="points[unloading][0][date_at]" value="{{ \Carbon\Carbon::parse($order->addresses->last()->pivot->date_at)->format('d/m/Y H:i') }}" placeholder="ДД/ММ/ГГГГ" required="" disabled>
                                <div class="duplicate-error text-danger">Дублирование даты</div>
                                <small id="error_unloading_0_date_at" class="text-danger box_error_unloading_date_at"></small>
                            </div>
                            <div class="group col-sm-8 group__wrapper point-box with-marker-unloading point-box-unloading">
                                <label class="control-label" for="">{{ trans('all.unloading_address') }}</label>

                                <input type="hidden" name="points[unloading][0][address_id]" data-marker-update="1"
                                       data-address="unloading" value="180">
                                <input type="text" class="form-control autocomplete duplicate-address"
                                       name="points[unloading][0][address]" value="{{ $order->addresses->last()->address }}" onclick="this.select();" placeholder="Введите адрес" required="" disabled="">
                                <small class="duplicate-error-address text-danger">Дублирование адреса</small>
                                <small id="error_unloading_0_address" class="text-danger box_error_unloading_address"></small>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-sm-5 order__container">
                <div class="order__info">
                    <div class="map-container">
                        <div id="map" style="height: 280px; position: relative; overflow: hidden;">
                        </div>
                        @include('includes.map')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7 order__container" >
                <div class="order__info">
                    <h2 class="h2 title-black">{{ trans('all.cargo_information') }}</h2>
                    <div class="group__wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" for="cargo_name">{{ trans('all.cargo_name') }}</label>
                                <input class="form-control" type="text" name="cargo_name" value="{{ $order->cargo->name }}" disabled="">
                            </div>
                        </div>
                    </div>

                    <div class="group__wrapper">
                        <div class="row spec">
                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_length">{{ trans('all.length') }} ({{ trans('all.cm') }})</label>
                                <input class="form-control" type="text" name="cargo_length" value="{{$order->cargo->length}} {{ trans('all.cm') }}" disabled="">
                            </div>

                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_width">{{ trans('all.width') }} ({{ trans('all.cm') }})</label>
                                <input class="form-control" type="text" name="cargo_width" value="{{$order->cargo->width}} {{ trans('all.cm') }}" disabled="">
                            </div>

                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_height">{{ trans('all.height') }} ({{ trans('all.cm') }})</label>
                                <input class="form-control" type="text" name="cargo_height" value="{{$order->cargo->height}} {{ trans('all.cm') }}" disabled="">
                            </div>

                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_weight">{{ trans('all.weight') }} ({{ trans('all.tons') }})</label>
                                <input class="form-control" type="text" name="cargo_weight" value="{{round($order->cargo->height / 1000, 2)}} {{ trans('all.tons') }}" disabled="">
                            </div>

                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_value">{{ trans('all.volume') }} (м3)</label>
                                <input class="form-control" type="text" name="cargo_value" value="{{$order->cargo->volume}} м3" disabled="">
                            </div>

                            <div class="col-xs-12 col-4 group__wrapper">
                                <label class="control-label" for="cargo_places">{{ trans('all.quantity_of_packages_2') }}</label>
                                <input class="form-control" type="text" name="cargo_places" value="{{$order->cargo->places}}" disabled>
                            </div>

                            <div class="col-xs-12 col-sm-6 group__wrapper">
                                <label class="control-label" for="cargo_temperature">{{ trans('all.temperature_mode') }}</label>
                                <input class="form-control" type="text" name="cargo_temperature" value="{{$order->cargo->temperature}}" disabled>
                            </div>

                            <div class="col-xs-12 col-sm-6 group__wrapper">
                                <label class="control-label" for="cargo_places">{{trans('all.hazard_class')}}</label>
                                <input class="form-control" type="text" name="cargo_places" value="@if($order->cargo->hazardClass){{trans('cargo.'.$order->cargo->hazardClass->slug)}} @endif" disabled="" >
                            </div>

                            <div class="col-xs-12 group__wrapper">
                                <label class="control-label" for="cargo_places">{{ trans('all.package_type') }}</label>
                                <input class="form-control" type="text" name="cargo_places" value="@if($order->cargo->packageType){{trans('cargo.'.$order->cargo->packageType->slug)}} @endif" disabled="" >
                            </div>

                            <div class="col-xs-12 group__wrapper">
                                <label class="control-label" for="cargo_places">{{ trans('all.loading_type') }}</label>
                                <input class="form-control" type="text" name="cargo_loading" value="@if($order->cargo->loadingType){{trans('cargo.'.$order->cargo->loadingType->slug)}} @endif" disabled="" >
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 order__container">
                <div class="order__info" >
                    <h2 class="h2 title-black">{{ trans('all.payment_information') }} </h2>

                    <div class="group__wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" for="recommended_price">{{ trans('all.recommended_price') }}</label>
                                <input class="form-control" type="text" name="recommended_price" value="@if($order->getPerformer()){{ $order->getPerformer()->amount_plan }} {{ $order->currency }} @else {{trans('all.empty')}} @endif " disabled style="color: #007CFF!important;">
                            </div>
                        </div>
                    </div>

                    <div class="group__wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" for="payment_type">{{ trans('all.payment_type') }}</label>
                                <input class="form-control" type="text" name="payment_type" value="{{ ($order->getPerformer() && $order->getPerformer()->payment_type !== null) ? trans('all.order_'.$order->getPerformer()->payment_type->name) : ''}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="group__wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" for="payment_conditions">{{ trans('all.terms_type') }}</label>
                                <input class="form-control" type="text" name="payment_conditions" value="{{ ($order->getPerformer() && $order->getPerformer()->payment_term !== null) ? trans('all.order_'.$order->getPerformer()->payment_term->name) : ''}}" disabled>
                            </div>
                        </div>
                    </div>

                    @if($order->offers->count() == 0)
                        <a href="{{ route('offer.repeat', [$order->id]) }}" class="btn button-style1">
                            {{ trans('all.request_repeat') }}
                            <span class="arrow-right"></span>
                        </a>
                        <a href="javascript://" class="btn button-style1" data-action-order="rejection-{{ $order->id }}">{{ trans('all.cancel_order') }}</a>
                    @endif

                </div>
            </div>
        </div>

    {{--</div>--}}


</div>

<div class="content-box__row proposal">
    <div class="col-xs-12">
        <h2 class="h2 title-black">{{ trans('all.proposal') }} [{{ $order->getOffers()->count() }} / {{$order->offers->count()}}]</h2>

        @foreach($order->offers as $offer)
            @if($offer->amount_fact)
            @php($executor = $offer->company())
            <div class="item-offer">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 item-offer__col">
                        <h3 class="name" {{-- style="color: #459DE2"--}}><a href="{{ route('user.profile.company', $executor->id) }}">{{ $executor->name }}</a></h3>
                        <div class="rating">
                            {{--<label for="stars0"></label>--}}
                            {{--<label for="stars3"></label>--}}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2 item-offer__col">
                        <label for="">{{ trans('all.phone') }}</label>
                        <span class="">{{ $executor->phone ? $executor->phone : trans('all.empty')}}</span>
                    </div>
                    <div class="col-xs-6 col-sm-3 item-offer__col">
                        <label for="">email</label>
                        <span class="">{{ $executor->email }}</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 item-offer__col">
                        <label for="">{{ trans('all.amount') }}</label>
                        <span class="sum">@if($offer->amount_fact){{ $offer->amount_plan }} / {{ $offer->amount_fact }} @else {{trans('all.empty')}} @endif</span>
                        @if($offer->amount_fact)
                        <span class="currency">{{ $order->currency }}</span>
                        @endif

                    </div>
                    <div class="col-xs-6 col-sm-2 item-offer__col text-center">
                        @if($offer->amount_fact)
                        <a href="{{ route('offer.agree', [$order->id, $offer->user_id]) }}" class="btn button-style1">{{ trans('all.agree') }}</a>
                        @else
                            {{trans('all.order_proposal_sent')}}
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        @if($order->offers->count() == 0)
            <a href="{{ route('offer.repeat', [$order->id]) }}" class="btn button-style1">{{ trans('all.request_repeat') }}</a>
            <a href="javascript://" class="btn button-style1" data-action-order="rejection-{{ $order->id }}">{{ trans('all.cancel_order') }}</a>
        @endif
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="{{ url('/main_layout/js/order.js') }}"></script>
@endpush