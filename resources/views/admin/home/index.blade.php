@extends('admin.layouts.app')
@section('title', 'Admin Home')
@section('content')

    <section class="content-header">
        <h1>{{trans('all.dashboard')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="">
                    <div class="panel-heading">{{trans('all.select_component')}}</div>

                </div>
            </div>
        </div>
    </section>
@endsection
