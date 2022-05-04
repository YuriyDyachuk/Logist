<div class="content-box__body">
    <div class="content-box__body-tabs" data-class="dragscroll">
        <!-- Tab navigation: BEGIN -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active transition">
                <a href="#flight" aria-controls="info" role="tab"
                   data-toggle="tab">{{ trans('all.flight_information') }}</a>
            </li>
            <li class="transition">
                <a href="#cargo" aria-controls="cargo" role="tab" data-toggle="tab">{{ trans('all.about_cargo') }}</a>
            </li>
            <li class="transition">
                <a href="#payment" aria-controls="payment" role="tab"
                   data-toggle="tab">{{ trans('all.about_payment') }}</a>
            </li>
        </ul>
        <!-- Tab navigation: END -->
    </div><!-- \dragscroll -->

    <!-- Tab content: BEGIN -->
    <div class="tab-content order-detail">
        <!-- First tab: BEGIN -->
        <div role="tabpanel" class="tab-pane fade in active transition" id="flight">
            <h2 class="title-block">{{ trans('all.flight_information') }}</h2>
            <div class="row">
                <div class="col-sm-6 form-horizontal">
                    @foreach($order->addresses as $address)
                        <div class="form-group">
                            <label data-notice=""
                                   class="control-label col-sm-5">{{ trans('all.date_' . $address->pivot->type) }}</label>
                            <div class="col-sm-7">{{ \Carbon\Carbon::parse($address->pivot->date_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="form-group">
                            <label data-notice=""
                                   class="control-label col-sm-5">{{ trans('all.'.$address->pivot->type . '_address') }}</label>
                            <div class="col-sm-7">{{ $address->address }}</div>
                        </div>
                    @endforeach
                        @if(isset($order->duration))
                            @php
                                $finishTime = strtotime($order->addresses->first()->pivot->date_at) + $order->duration;
                            @endphp
                            <div class="form-group">
                                <label data-notice="" class="control-label col-sm-5">{{trans('all.date_estimated_arrival')}}</label>
                                <div class="col-sm-7">{{date("d/m/Y H:i", $finishTime)}}</div>
                            </div>
                        @endif
                </div>

                <div class="col-sm-6">
                    @include('includes.map')
                </div>
            </div>
        </div>
        <!-- First tab: END -->

        <!-- Second tab: BEGIN -->
        <div role="tabpanel" class="tab-pane fade transitione" id="cargo">
            <h2 class="title-block">{{ trans('all.cargo_information') }}</h2>
            <div class="row">
                <div class="col-sm-6 form-horizontal">
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.cargo_name') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['name'] }}</div>
                    </div>

                    <div class="form-group">
                        <label data-notice=""
                               class="control-label col-sm-5">{{ trans('all.height_length_width') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['height'] }}/{{ $order->cargo['length'] }}
                            /{{ $order->cargo['width'] }}</div>
                    </div>

                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.weight') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['weight'] }}</div>
                    </div>

                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.volume') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['volume'] }}</div>
                    </div>
                    <div class="form-group">
                        <label data-notice=""
                               class="control-label col-sm-5">{{ trans('all.quantity_of_packages') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['places'] }}</div>
                    </div>
                    <div class="form-group">
                        <label data-notice=""
                               class="control-label col-sm-5">{{ trans('all.temperature_mode') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['temperature'] }}</div>
                    </div>
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.hazard_class') }}</label>
                        <div class="col-sm-7">@if($order->cargo->hazardClass)@if(array_key_exists($order->cargo->hazardClass->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->hazardClass->slug)}} @else {{ $order->cargo->hazardClass->name }} @endif @endif</div>
                    </div>
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.package_type') }}</label>
                        <div class="col-sm-7">@if($order->cargo->packageType) @if(array_key_exists($order->cargo->packageType->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->packageType->slug)}} @else {{ $order->cargo->packageType->name }} @endif @endif</div>
                    </div>
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.loading_type') }}</label>
                        <div class="col-sm-7">@if($order->cargo->loadingType)@if(array_key_exists($order->cargo->loadingType->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->loadingType->slug)}} @else {{ $order->cargo->loadingType->name }} @endif @endif</div>
                    </div>
                </div>
                <div class="col-sm-6" style="min-height: 350px"></div>
            </div>
        </div>
        <!-- Second tab: END -->

        <!-- Three tab: BEGIN -->
        <div role="tabpanel" class="tab-pane fade transitione" id="payment">
            <h2 class="title-block">{{ trans('all.payment_information') }}</h2>
            <div class="row">
                <div class="col-sm-6 form-horizontal">
                    <div class="form-group">
                        <label data-notice=""
                               class="control-label col-sm-5">{{ trans('all.recommended_price') }}</label>
                        <div class="col-sm-7" style="text-transform: uppercase">
                            @if($order->getOffer())
                                <span class="sum">{{ $order->getOffer()->amount_plan }}</span>
                                <span class="currency">{{ $order->currency }}</span>
                            @elseif($order->amount_plan)
                                <span class="sum">{{ $order->amount_plan }}</span>
                                <span class="currency">{{ $order->currency }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.payment_type') }}</label>
                        @if($order->getOffer())
                        <div class="col-sm-7">{{ trans('all.order_'.$order->getOffer()->payment_type->name) }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.terms_type') }}</label>
                        @if($order->getOffer())
                        <div class="col-sm-7">{{ trans('all.order_'.$order->getOffer()->payment_term->name) }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6" style="min-height: 350px"></div>
            </div>
        </div>
        <!-- Three tab: END -->

        <div class="text-center">
            @if($order->getOffer() && $order->getOffer()->amount_fact !== null)
{{--                @if(is_user_sent_offer_price($order->offers))--}}
                <div class="btn button-style1"><span>{{trans('all.order_proposal_sent')}}</span></div>
            @else
                <a href="#" class="btn button-style1" data-toggle="modal" data-target="#offer" order-id="{{ $order->id }}">{{trans('all.order_send_proposal')}}<span class="arrow-right"></span></a>
            @endif
        </div>
    </div>
    <!-- Tab content: END -->
</div>