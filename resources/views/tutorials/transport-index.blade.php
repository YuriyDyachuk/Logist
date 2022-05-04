@if(user_tutorials('transport-new'))
    @include('tutorials.pages.transport-new')
@endif

@if(!user_tutorials('transport-new') && user_tutorials('transport-added'))
    @include('tutorials.pages.transport-new-added')
@endif

@if(!user_tutorials('transport-new') && !user_tutorials('transport-added') && user_tutorials('order-section-link'))
    @include('tutorials.pages.order-section-link')
@endif