@extends("layouts.app")

@section("content")
    <div id="viewOrder" class="content-box orders-page">
        <a href="{{ route('orders') }}" class="return-to-list"><div><img src="/img/icon/arrow-left.svg"></div> <div style="display: inline-block; color: #007cff; vertical-align: top;">{{trans('all.order_link_to_list')}}</div></a>
        @include('orders.partials.title')
        @if($order->hasStatus('search') || $order->isItOffer())
            @include('orders.partials.show.' . ($userIsLogistic ? 'logistic':'client') . '-search')
        {{--@elseif($order->user_id !== \Auth::id() && ($partner_view_check && $order->partner == \App\Models\Order\Order::PARTNER_REQUEST) || ($partner_is && $order->partner == \App\Models\Order\Order::PARTNER_REQUEST))--}}
            {{--@include('orders.partials.show.partner')--}}
        @else
            <div class="content-box__body-tabs" data-class="dragscroll">
                @include('orders.partials.show.nav-tabs')
            </div><!-- \dragscroll -->

            <div class="content-box__body" data-order="{{ $order->id }}">
                {{--<div class="content-box__body-tabs">--}}

                    <!-- Tab content: BEGIN -->
                    <div class="tab-content">
                        @include('orders.partials.show.includes.general')

                        @if($order->getOfferSender())
                            @include('orders.partials.show.includes.transport-sent-offer')
                        @elseif($order->hasStatus('planning') && $userIsLogistic)
                            @include('orders.partials.show.includes.transport-planning')
                        @else
                            @includeWhen($userIsLogistic, 'orders.partials.show.includes.transport')
                        @endif

                        @include('orders.partials.show.includes.payment')

                        @include('orders.partials.show.includes.documents')

                        @includeWhen($userIsLogistic, 'orders.partials.show.includes.progress')

                        @includeWhen($userIsLogistic, 'orders.partials.show.includes.history')

                        @include('orders.partials.show.footer')

                        @include('orders.partials.show.modals')
                    </div>
                    <!-- Tab content: END -->
                {{--</div>--}}
            </div>

            @push('scripts')
                <script>
                    var sweetAlert_btn_cancel = '{{ trans('all.cancel') }}';
                    var sweetAlert_btn_confirm = '{{ trans('all.confirm') }}';
                    var sweetAlert_btn_order_title_cancel = '{{ trans('all.order_title_cancel') }}';
                    var sweetAlert_form_placeholder_order = '{{ trans('all.order_placeholder_form') }}';
                    var sweetAlert_success_active_order = '{{ trans('all.order_active_success_form') }}';
                    var sweetAlert_tab_progress_order = '{!! trans('all.order_tab_progress_form') !!}';
                    var sweetAlert_cancel_success_order = '{{ trans('all.order_cancel_form') }}';
                </script>
                <script type="text/javascript" src="{{ url('/main_layout/js/order.js') }}"></script>
            @endpush
        @endif
    </div>
    {{-- tutorials --}}
    @include('tutorials.tutorials')
@endsection

@section('modals')
    @includeWhen($userIsLogistic, 'orders.partials.modal-offer')
@endsection