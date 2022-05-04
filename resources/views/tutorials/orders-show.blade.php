@if($order->hasStatus('planning') && user_tutorials('order-show'))
    @include('tutorials.pages.order-show')
@endif

@if($order->hasStatus('active') && !user_tutorials('order-show') && user_tutorials('order-show-activated'))
    @include('tutorials.pages.order-show-activated')
@endif