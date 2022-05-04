<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == null ? ' active in':''   }}" id="payment">
    <div class="row margin-top-md">
        @if ($message = Session::get('success'))
            <div class="custom-alerts alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php Session::forget('success');?>
        @endif

        @if ($message = Session::get('error'))
            <div class="custom-alerts alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php Session::forget('error');?>
        @endif
    </div>

    <div id="subscriptionBody">
        @include('pay.partials.index.includes.subscription')
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 text-left">
            <button type="button" class="btn button-style1 upgradeBtn">
                <i class="fa fa-arrow-up"></i> {{ trans('all.upgrade') }}
            </button>
            {{--@if ($active_subscription && $active_subscription->plan_id != 1)--}}
            {{--<button type="button" class="btn button-style1 unsubscribeBtn" data-pay="{{trans('pay.cancel_subscription')}}" data-submit="{{ trans('all.submit')  }}">--}}
                {{--{{trans('pay.cancel_subscription')}}--}}
            {{--</button>--}}
            {{--@endif--}}

        </div>
    </div>
</div>