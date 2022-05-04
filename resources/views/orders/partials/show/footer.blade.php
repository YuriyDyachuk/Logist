<div class="col-xs-12 footer text-center">
    @if($order->getOfferSender())
        <a href="javascript://" class="btn button-cancel"
           data-action-order="rejectionoffers-{{ $order->id }}">{{ trans('all.reject-offer') }} <i>&times;</i>
        </a>
    @elseif($userIsLogistic && $order->hasStatus('planning'))

        @if(($order_from_client || $order_from_partner) && !$order_to_partner)
            <a href="javascript://" class="btn button-cancel"
               data-action-order="rejectionexecuteoffer-{{ $order->id }}">{{ trans('all.reject') }} <i>&times;</i>
            </a>
        @elseif(!$order_to_partner)
            <a href="javascript://" class="btn button-cancel"
               data-action-order="rejection-{{ $order->id }}">{{ trans('all.cancel_order') }}
                <i>&times;</i>
            </a>
        @endif

        {{-- chack if can update --}}
        @if(checkPaymentAccess('order'))
        <button type="submit" class="btn button-style3 updateAddress">
            <span id="text-save-btn" class="">{{ trans('all.save') }}</span> <span id="text-save-btn2" style="display: none;">@if($order_to_partner === false) @if(app()->getLocale() == 'en') and send @else и отправить @endif @endif</span>
        </button>
        @else
            <button class="btn button-block updateAddress" disabled><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>{{ trans('all.save') }}</button>
        @endif

        <button @if($order_to_partner === true) disabled @endif id="activate-button" type="button" class="btn @if($order_to_partner === true) button-block @else button-style1 @endif"
                data-action-order="activate-{{ $order->id }}">
           {{ trans('all.activate_order') }}
            <span class="arrow-right"></span>
        </button>



    @elseif($order->hasStatus('active') && $userIsLogistic && $order->getPerformerSender() === null)
            <button type="button" class="btn button-style1 " id="completed"
                    data-action-order="completed-{{ $order->id }}" data-action-order1="completion-{{ $order->id }}" title="{{ trans('all.select_all_progress') }}">{{ trans('all.completed_order') }}
                <span class="arrow-right"></span></button>

    @elseif($order->hasStatus('canceled') && $userIsLogistic && $order->getPerformerSender() === null)
        <button @if($order_to_partner === true) disabled @endif id="activate-button" type="button" class="btn button-style1 "
                data-action-order="planning-{{ $order->id }}">
            {{ trans('all.order_restore') }}
            <span class="arrow-right"></span>
        </button>
    @endif
</div>

<div class="clearfix"></div>
@if($order->offers->count() > 0 && $order->offers->contains('sender_user_id',\Auth::id()))
<div class="content-box__row proposal">
    <div class="col-xs-12">
        <h2 class="h2 title-black">{{ trans('all.proposal') }} [{{ $order->getOffers()->count() }} / {{$order->offers->count()}}]</h2>

        @foreach($order->offers as $offer)
            @php($executor = $offer->company())
            <div class="item-offer">
                <div class="row">
                    <div class="col-xs-3">
                        <h3 class="name"><a href="javascript://">{{ $executor->name }}</a></h3>
                        <div class="rating">
                            {{--<label for="stars0"></label>--}}
                            {{--<label for="stars3"></label>--}}
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <label for="">{{ trans('all.phone') }}</label>
                        <span class="">{{ $executor->phone ? $executor->phone : trans('all.empty')}}</span>
                    </div>
                    <div class="col-xs-3">
                        <label for="">email</label>
                        <span class="">{{ $executor->email }}</span>
                    </div>
                    <div class="col-xs-2">
                        <label for="">{{ trans('all.amount') }}</label>
                            <span class="sum">@if($offer->amount_fact){{ $offer->amount_plan }} / {{ $offer->amount_fact }} <span class="currency">{{ $order->currency }}</span> @else {{trans('all.empty')}} @endif</span>
                    </div>
                    <div class="col-xs-2 text-right">
                        @if($offer->amount_fact)
                        <a href="{{ route('order.partner.approved', [$order->id, $executor->id]) }}" class="btn button-style1">{{ trans('all.agree') }}</a>
                        @else
                            {{trans('all.order_proposal_sent')}}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endif


@push('scripts')
<script>
    $( document ).ready(function() {


    });
</script>
@endpush

@if($order_to_partner)
    @push('scripts')
    <script>
        $( document ).ready(function() {
            $('#activate-button').prop('disabled', true);
        });
    </script>
    @endpush
@endif