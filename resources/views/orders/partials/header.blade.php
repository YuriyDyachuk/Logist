<div class="content-box__header">
    <div class="content-box__title">
        <h1 class="h1 title-blue">{{ trans('all.orders') }}</h1>
    </div>
    <div class="content-box__right-block">
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