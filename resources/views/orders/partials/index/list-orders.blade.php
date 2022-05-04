@forelse ($orders as $order)
    @php
        $status = $order->status;

        $unread = key_exists("order_$order->id", $notifications)
            ? $notifications['order_' .$order->id] : null;

    @endphp
    <div class="content-box__row{{ $unread ? ' unread' : ''}}">
        <a href="{{ route('orders.show', $order->id) }}"
           {{ $unread ? "data-notification=$unread" : '' }}
           class="link-order">
            {{-- BODY --}}
            <div class="card-order">
                <div class="row flex">

                        @if((\Auth::user()->isLogist() || \Auth::user()->isLogistic()) && (($order->getPerformerSender() && isset($partners[$order->getPerformerSender()->user_id])) || ($order->getPerformer() && isset($partners[$order->getPerformer()->sender_user_id]))))
                    <p class="check-partner">
                        <span class="check-partner__wrapp">
                            <span class="check-partner__wrapp-rotate">
                            @if($order->getPerformer() && isset($partners[$order->getPerformer()->sender_user_id]))
                                <span class="check-partner-arrow">&darr;</span>
                            @elseif($order->getPerformerSender() && isset($partners[$order->getPerformerSender()->user_id]))
                                <span class="check-partner-arrow">&uarr;</span>
                            @endif
                                <span>{{trans('all.order_partner')}}</span>
                            </span>
                        </span>
                    </p>
                    @endif
                    {{-- Info --}}
                    <div class="col-xs-2 /*br-2*/ info-ord flex{{ $type == 'orders' || ($status->name != 'search') ?  ' align-content-between' : ''}} vert-line">
                        @if($status->name != 'search')
                            <div class="">
                                <span class="marker-{{ $status->name }} marker-status transition">
                                    {{ trans('all.status_' . $status->name ) }}
                                </span>
                            </div>
                        @endif
                        @if ($status->name == 'search' && \Auth::user()->isClient() && $order->user_id == \Auth::user()->id)
                            <div class="order_search_markers">
                                <div class="order_search_marker_1"><img src="/img/icon/order-search-icon-1.svg"> {{trans('all.searching')}}</div>
                                <div class="order_search_marker_2"><img src="/img/icon/order-search-icon-2.svg"> {{$order->getOffers()->count()}} {{trans('all.order_proposal')}}</div>
                                <div class="order_search_marker_3"><img src="/img/icon/order-search-icon-3.svg">  {{ $order->suitableOffers->first() ? $order->suitableOffers->first()->amount : 0 }} {{trans('all.order_suitable')}}</div>
                            </div>
                        @endif

                        <div class="">
                            <h4 class="title-black label-card order-list-number"><b>#{{ $order->inner_id }}({{ $order->id }})</b></h4>
                        </div>

                        <div>
                            <h5 class="title-grey label-card">{{ trans('all.category') }}</h5>
                            <span class="small-size bold">{{ trans('handbook.' . $order->getCategoryName()) }}</span>
                        </div>
                    </div>

                    <!-- dop info img -->
                    <div class="dop-img-index"></div>
                    <!-- end dop info  -->

                    {{-- Places --}}
                    <div class="col-xs-4 br-2 flex vert-line">
                        <div class="row info-download">
                            <div class="col-xs-5">
                                <h5 class="title-grey label-card">{{ trans('all.date_loading') }}</h5>
                                <span class="order-list-date">{{ \Carbon\Carbon::parse($order->orderAddress->first()->date_at)->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="col-xs-7">
                                <h4 class="title-black label-card order-list-address">{{ $order->addresses->first()->address }}</h4>
                                <div class="line-map">
                                    <div class="point-download"></div>
                                    @foreach($order->addresses as $address)
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
                            </div>
                        </div>

                        <div class="row info-upload">
                            <div class="col-xs-5">
                                <h5 class="title-grey label-card">{{ trans('all.date_unloading') }}</h5>
                                <span class="order-list-date">{{ \Carbon\Carbon::parse($order->orderAddress->last()->date_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="col-xs-7">
                                <h4 class="title-black label-card order-list-address">{{ $order->addresses->last()->address }}</h4>
                            </div>
                        </div>
                    </div>

                    {{-- Cargo --}}
                    <div class="col-xs-3 flex align-center1 cargo{{ $order->transports->first() ? ' align-content-between':'' }} vert-line">
                        <div class="row">
                            <div class="col-xs-12 ">
                                {{--<h5 class="title-grey label-card">{{ trans('all.cargo') }}:--}}
                                    {{--<span class="name">{{ !is_null($order->cargo) ? $order->cargo->name : '' }}</span></h5>--}}

                                <div class="spec">
                                    <div class="order-cargo order-cargo-icon"></div>
                                    <div class="order-cargo order-cargo-dscr">{{ !is_null($order->cargo) ? $order->cargo->name : '' }} {{ !is_null($order->cargo) ? $order->cargo->weight / 1000 : 0 }} {{ trans('all.tons') }} - {{ !is_null($order->cargo) ? $order->cargo->volume : '' }} м<sup>3</sup></div>
                                    @if(!is_null($order->cargo) && $order->cargo->hazard_class_id !== null)
                                    <div class="order-cargo order-cargo-dscr pull-right">
                                        <img src="{{url('/images/svg/order-danger.svg')}}" alt="{{ trans('all.hazard_class') }}">
                                    </div>
                                    @endif

                                    @if(!is_null($order->cargo) && $order->cargo->temperature !== null)
                                        <div class="order-cargo order-cargo-dscr pull-right">
                                            <img src="{{url('/images/svg/order-temperature.svg')}}" alt="{{ trans('all.temperature_mode') }}">
                                        </div>
                                    @endif
                                </div>

                                <div class="spec">
                                    <div class="order-cargo order-size-icon"></div>
                                    <div class="order-cargo order-cargo-dscr">{{ trans('all.length_short') }} {{ !is_null($order->cargo) ? $order->cargo->length : 0 }} {{ trans('all.cm') }}<span class="as-unit after-x"></span>{{ trans('all.width_short') }} {{ !is_null($order->cargo) ? $order->cargo->width : 0}} {{ trans('all.cm') }}<span class="as-unit"></span><span class="as-unit after-x"></span>{{ trans('all.height_short') }} {{ !is_null($order->cargo) ? $order->cargo->height : 0 }} {{ trans('all.cm') }}</div>


                                </div>

                                {{--<div class="spec">--}}
                                    {{--<span><i class="fa fa-arrows-alt"></i></span> Д {{ !is_null($order->cargo) ? $order->cargo->length : 0 }}--}}
                                    {{--<span class="as-unit after-x">{{ trans('all.cm') }}</span>Ш {{ !is_null($order->cargo) ? $order->cargo->width : 0}}<span class="as-unit">{{ trans('all.cm') }}</span>--}}
                                    {{--<span class="as-unit after-x">{{ trans('all.cm') }}</span>В {{ !is_null($order->cargo) ? $order->cargo->height : 0 }}--}}
                                {{--</div>--}}

                                {{--<div class="spec">--}}
                                    {{--<span><i class="fa fa-cube"></i> {{ !is_null($order->cargo) ? $order->cargo->volume : 0 }}<span--}}
                                                {{--class="as-unit">M3</span></span>--}}
                                    {{--<span><i class="fa fa-balance-scale"></i> {{ !is_null($order->cargo) ? $order->cargo->weight / 1000 : 0 }}<span--}}
                                                {{--class="as-unit">{{ trans('all.tons') }}</span></span>--}}
                                {{--</div>--}}
                            </div>
                        </div>

                        {{-- Comment --}}
                        <div class="row">
                            <div class="col-xs-12">
                                @if($order->comment !== null)
                                <i class="as as-comment"></i>
                                <span>{{$order->comment}}</span>
                                @endif

                                @if($order->getOffer())
                                        <h5 class="title-grey label-card">
                                        @if($user->isClient())
                                            {{ trans('all.carrier') }}:
                                        @else
                                            {{ trans('all.client') }}:
                                        @endif
                                            <span class="name">{{$order->getOffer()->creator->name}}</span>
                                        </h5>
                                @endif
                            </div>
                        </div>

                        @if($order->transports->first() && !auth()->user()->isClient())
                            <div class="row">
                                <div class="col-xs-6">
                                    <h5 class="title-grey label-card">{{ trans('all.transport') }}</h5>
                                    <div class="small-size">(ID-{{ $order->transports[0]->id}}) {{ $order->transports[0]->model ?? '' }} {{ $order->transports[0]->number}}</div>
                                </div>
                                @if($order->transports[0]->drivers->count())
                                <div class="col-xs-6">
                                    <h5 class="title-grey label-card">{{ trans('all.driver') }}</h5>
                                    <div class="small-size">
                                            {{ $order->transports[0]->drivers[0]->name }}<br>
                                            {{ $order->transports[0]->drivers[0]->phone }}
                                    </div>
                                </div>
                                @endif
                                {{--<div class="col-xs-6">--}}
                                    {{--<h5 class="title-grey label-card">{{ trans('all.transport') }}</h5>--}}
                                    {{--<div class="small-size bold">(ID-{{ $order->transports[0]->id}}) {{ $order->transports[0]->model or '' }} {{ $order->transports[0]->number}}</div>--}}
                                    {{--@if($order->transports[0]->drivers->count())--}}
                                        {{--<div class="small-size__wrapper flex">--}}
                                            {{--<span class="small-size">{{ $order->transports[0]->drivers[0]->name }}</span>--}}
                                            {{--<span class="small-size">{{ $order->transports[0]->drivers[0]->phone }}</span>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            </div>
                        @endif
                    </div>

                    {{-- Payment --}}
                    <div class="col-xs-3 payment-block">
                        <div class="pl-20 price">

                            @if($order->getOffer() && $order->getOffer()->amount_fact !== null)
                                <span class="sum">{{ number_format($order->getOffer()->amount_plan, 0, '.', ' ') }}/{{ number_format($order->getOffer()->amount_fact, 0, '.', ' ') }} </span>
                            @elseif($order->getOffer() && $order->getOffer()->amount_fact === null)
                                <span class="sum">{{ number_format($order->getOffer()->amount_plan, 0, '.', ' ') }} </span>
                            @elseif($order->getPerformerSender() && $order->getPerformer()->amount_fact !== null)
                                <span class="sum">{{ number_format($order->getPerformer()->amount_plan, 0, '.', ' ') }} / {{ number_format($order->getPerformer()->amount_fact, 0, '.', ' ') }} </span>
                            @elseif($order->getPerformer() && $order->getPerformer()->amount_fact !== null)
                               <span class="sum"> {{ number_format($order->getPerformer()->amount_fact, 0, '.', ' ') }} </span>
                            @elseif($order->getPerformer() && $order->getPerformer()->amount_fact === null)
                                <span class="sum">{{ number_format($order->getPerformer()->amount_plan, 0, '.', ' ') }} </span>
                            @endif

                            <span class="currency">{{ $order->currency }}

                            {{--@if($order->is_vat)--}}
                            @if(($order->getOffer() && $order->getOffer()->vat === 1) || ($order->getPerformer() && $order->getPerformer()->vat === 1))
                                    <span class="vat">{{trans('all.VAT_with')}}</span>
                            @else
                                    <span class="vat">{{trans('all.VAT_without')}}</span>
                            @endif
                            </span>
                        </div>

                        <div class="pl-20 pb-2">
                            <h5 class="title-grey label-card">{{ trans('all.payment_type') }}</h5>
                            {{--@if(is_offer_incoming($order->offers))--}}
                            @if($order->getOffer())
                            <span class="small-size bold">{{ ($order->getOffer()->payment_type_id !== null && isset($payment_types[$order->getOffer()->payment_type_id])) ? trans('all.order_'.$payment_types[$order->getOffer()->payment_type_id]) : ''}}</span>
                            @endif

                            @if($order->getPerformer())
                                <span class="small-size bold">{{ ($order->getPerformer()->payment_type_id !== null && isset($payment_types[$order->getPerformer()->payment_type_id])) ? trans('all.order_'.$payment_types[$order->getPerformer()->payment_type_id]) : ''}}</span>
                            @endif
                        </div>

                        <div class="pl-20 pb-2">
                            <h5 class="title-grey label-card">{{ trans('all.terms_type') }}</h5>

                            @if($order->getOffer())
                                <span class="small-size bold">{{ ($order->getOffer()->payment_term_id !== null && isset($payment_terms[$order->getOffer()->payment_term_id])) ? trans('all.order_'.$payment_terms[$order->getOffer()->payment_term_id]) : ''}}</span>
                            @endif

                            @if($order->getPerformer())
                                <span class="small-size bold">{{ ($order->getPerformer()->payment_term_id !== null && isset($payment_terms[$order->getPerformer()->payment_term_id])) ? trans('all.order_'.$payment_terms[$order->getPerformer()->payment_term_id]) : ''}}</span>
                            @endif

                        </div>

                        @if($type == 'orders' || ($user->isClient() && $type != 'orders'))
                            <div class="pl-20 pb-2">
                                @if($user->isClient())
                                    <h5 class="title-grey label-card">{{ trans('all.carrier') }}</h5>
                                    @if($order->getPerformerSender() !== null)
                                        <span class="small-size bold">{{ isset($order->getPerformerSender()->executor->meta_data['name']) ? $order->getPerformerSender()->executor->meta_data['name'] :  $order->getPerformer()->executor->name}}</span>
                                    @endif
                                @else
                                    <h5 class="title-grey label-card">{{ trans('all.client') }}</h5>
                                    <span class="small-size bold">{{ isset($order->getPerformer()->creator->meta_data['name']) ? $order->getPerformer()->creator->meta_data['name'] :  $order->getPerformer()->creator->name}}</span>
                                @endif

                            </div>
                        @elseif($type == 'requests')

                            @if($order->getOffer() && $order->getOffer()->amount_fact !== null)
                                <span class="btn button-style2">{{trans('all.order_proposal_sent')}}</span>
                            {{--@if($order->getOffer() && $order->getOffer()->amount_fact === null)--}}
                                    {{--<span>--}}
                                        {{--<button class="btn btn-success">{{trans('all.order_proposal_view')}}</button>--}}
                                    {{--</span>--}}
                                        {{--@endif--}}
                            @elseif($order->getOffer() && $order->getOffer()->amount_fact === null)
                                <button type="button" class="btn button-style1"
                                        onclick="event.preventDefault()"
                                        data-toggle="modal"
                                        data-target="#offer"
                                        order-id="{{ $order->id }}">{{trans('all.order_send_proposal')}}
                                </button>
                            @endif

                            <span class="elect{{ $order->isLike($user->id) ? ' liked' : ''}}"
                                  onclick="likeOrder($(this), {{ $order->id }})"></span>

                        {{--@elseif($type == 'client' && $order->hasStatus('search'))--}}
                            {{--<span class="btn btn-primary">--}}
                                {{--поиск предложений--}}
                                {{--{!! $order->offers->count() ? "<span class='badge'>{$order->offers->count()}</span>" :''!!}</span>--}}
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    @if(!isset(\Request::get('filters')["type"]) || \Request::get('filters')["type"] == 'order')
        <div class="content-box__body text-center col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 /*panel panel-default */ empty-panel">
            <div class="row tab-pane">
                <div class="col-xs-12">
                    <h3>{{  trans('all.empty_orders') }}</h3>
                </div>
                <div class="col-xs-12">
                    <i class="fa fa-th"></i>
                </div>
                <div class="col-xs-12 text-center">
                    <div class="content-box__add-rais text-center" style="float: none">
                        @if($user->isClient())
                                <a href="{{ route('order.create') }}" class="btn button-style1 transition" id="linkOrderNew"><i class="as as-adddocument"></i>{{ trans('all.create_new_order') }}</a>
                        @else
                            @if(checkPaymentAccess('order_creating') && profile_filled())
                                <a href="{{ route('order.create') }}" class="btn button-style1 transition11" id="linkOrderNew"><i class="as as-adddocument"></i>{{ trans('all.create_new_order_logist') }}</a>
                            @else
                                <button class="btn button-block transition" id="linkOrderNew"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>{{ trans('all.create_new_order_logist') }}</button>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    @endif
@endforelse
<!-- Pagination -->
{{ $orders->appends( ['filters' => $filters])->links() }}