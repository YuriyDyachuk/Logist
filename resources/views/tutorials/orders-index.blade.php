@if($orders->count() === 0 && profile_filled() && user_tutorials('order-link-new'))
    @include('tutorials.pages.order-link-new')
@endif

@if(!user_tutorials('order-link-new') && user_tutorials('order-created') && $orders->count() === 1 && !auth()->user()->isClient())
    @include('tutorials.pages.order-created')
@endif