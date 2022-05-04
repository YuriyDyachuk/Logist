@php
    $name = \Route::currentRouteName();
    //var_dump($name);
@endphp

@if($name === 'register.account')
    {{--@include('tutorials.auth-profile-register', ['account' => $account])--}}
@endif

@if($name === 'user.setting')
    @include('tutorials.settings-index')
@endif

@if($name === 'transport.index' && !auth()->user()->isClient())
    @include('tutorials.transport-index')
@endif

@if($name === 'order.create')
    @include('tutorials.orders-create')
@endif

@if($name === 'orders')
    @include('tutorials.orders-index')
@endif

@if($name === 'orders.show' && !auth()->user()->isClient())
    @include('tutorials.orders-show')
@endif

@if($name === 'user.profile')
    @include('tutorials.profile-profile')
@endif