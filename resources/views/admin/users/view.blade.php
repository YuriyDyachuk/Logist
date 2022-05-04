@extends('admin.layouts.app')
@section('title', $user->name)
@section('content')

    @inject('helper', '\App\Helpers\Options')

    <section class="content-header">
        <h1>{{trans('all.dashboard')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> {{trans('all.home')}}
                </a></li>
            <li class="active"><a href="{{route('admin.users.requests')}}"><i
                            class="fa fa-dashboard"></i> {{trans('all.requests')}}</a></li>
            <li class="active"><i class="fa fa-dashboard"></i> {{$user->name}}</li>
        </ol>
    </section>
    <div class="col-lg-12">
        <div class="table-responsive">
            @if($user)

                @include('admin.users.view.indication')

                @include('admin.users.view.information')

                {{--@if( $user->hasRole('client-person') || $user->hasRole('logistic-person')) --}}
                    @include('admin.users.view.photos')
                {{--@endif--}}

                @if(true)
                    @include('admin.users.view.documents')
                @endif

                @if(true)
                    @include('admin.users.view.ccards')
                @endif

                @if(true)
                    @include('admin.users.view.transports')
                @endif

                @if(true)
                    @include('admin.users.view.trailer')
                @endif

                @if(true)
                    @include('admin.users.view.specialization')
                @endif

                @include('admin.users.view.actions')
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
@endsection