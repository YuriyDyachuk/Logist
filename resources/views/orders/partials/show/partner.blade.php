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
            <h2 class="title-black">{{ trans('all.flight_information') }}</h2>
            <div class="row">
                <div class="col-sm-6 form-horizontal">
                    @foreach($order->addresses as $address)
                        <div class="form-group">
                            <label data-notice=""
                                   class="control-label col-sm-5">{{ trans('all.date_' . $address->pivot->type) }}</label>
                            <div class="col-sm-7">{{ $address->pivot->date_at }}</div>
                        </div>
                        <div class="form-group">
                            <label data-notice=""
                                   class="control-label col-sm-5">{{ trans('all.'.$address->pivot->type . '_address') }}</label>
                            <div class="col-sm-7">{{ $address->address }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="col-sm-6">
                    @include('includes.map')
                </div>
            </div>
        </div>
        <!-- First tab: END -->

        <!-- Second tab: BEGIN -->
        <div role="tabpanel" class="tab-pane fade transitione" id="cargo">
            <h2 class="title-black">{{ trans('all.cargo_information') }}</h2>
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
                        <div class="col-sm-7">{{ $order->cargo['hazard_class'] }}</div>
                    </div>
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.package_type') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['pack_type'] }}</div>
                    </div>
                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.loading_type') }}</label>
                        <div class="col-sm-7">{{ $order->cargo['loading_type'] }}</div>
                    </div>
                </div>
                <div class="col-sm-6" style="min-height: 350px"></div>
            </div>
        </div>
        <!-- Second tab: END -->

        <!-- Three tab: BEGIN -->
        <div role="tabpanel" class="tab-pane fade transitione" id="payment">
            <h2 class="title-black">{{ trans('all.payment_information') }}</h2>
            <div class="row">
                <div class="col-sm-6 form-horizontal">
                    <div class="form-group">
                        <label data-notice=""
                               class="control-label col-sm-5">{{ trans('all.recommended_price') }}</label>
                        <div class="col-sm-7" style="text-transform: uppercase">
                            @if($order->amount_partner)
                                <span class="sum">{{ $order->amount_partner }}</span>
                                <span class="currency">{{ $order->currency }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">

                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.payment_type') }}</label>
                        <div class="col-sm-7">{{ trans('all.order_'.($order->payment_type ? $order->payment_type->name : '')) }}</div>
                    </div>

                    <div class="form-group">
                        <label data-notice="" class="control-label col-sm-5">{{ trans('all.terms_type') }}</label>
                        <div class="col-sm-7">{{ trans('all.order_'.($order->payment_term ? $order->payment_term->name : '')) }}</div>
                    </div>
                </div>
                <div class="col-sm-6" style="min-height: 350px"></div>
            </div>
        </div>
        <!-- Three tab: END -->

        <div class="text-center">
            @if($order->partner == \App\Models\Order\Order::PARTNER_REQUEST)
                <a href="{{route('order.partner.approved', ['id' => $order->id, 'check' => 1])}}" class="btn button-green xs" ><span>Согласится</span></a>
                <a href="{{route('order.partner.approved', ['id' => $order->id, 'check' => 0])}}" class="btn btn-danger  xs" ><span>Отказатся</span></a>
            @endif
        </div>
    </div>
    <!-- Tab content: END -->
</div>