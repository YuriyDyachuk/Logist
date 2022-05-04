@extends('admin.layouts.app')
@section('title', trans('all.new_requests'))
@section('content')

    <section class="content-header">
        <h1>{{trans('all.dashboard')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> {{trans('all.home')}}</a></li>
            <li><i class="fa fa-dashboard"></i> {{trans('all.user_requests')}}</li>
        </ol>
    </section>
    <div class="col-lg-12">
        <div class="list-group">

            @forelse($users as $key => $user)
                <li class="list-group-item">
                    <div>
                        {{trans('all.name')}} : {{$user->name}} <br/>
                        {{trans('all.email_address')}} : {{$user->email}} <br/>
                        <a href="{{route('admin.users.view', $user->id)}}" class="btn btn-sm btn-success">{{trans('all.view_request')}}</a>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    <div>{{trans('all.empty_list')}}</div>
                </li>
            @endforelse
        </div>
        <div>
            {{$users->links()}}
        </div>
    </div>
@endsection