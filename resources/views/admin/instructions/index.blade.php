@extends('admin.layouts.app')
@section('title', trans('all.user_instructions'))
@section('content')

    <section class="content-header">
        <h1>{{trans('all.user_instructions')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>

    <section class="content">

        <a href="{{route('instructions.create')}}"
           class="btn btn-sm btn-success">{{trans('all.add')}}</a>

        <div class="col-xs-12">
            <div class="list-group">
                @forelse($instructions as $key => $instruction)
                    @include('admin.instructions.item', ['instruction' => $instruction, 'current_level' => 1, 'level' => []])
                @empty
                    <li class="list-group-item">
                        <div>{{trans('all.empty_list')}}</div>
                    </li>
                @endforelse
            </div>
        </div>
    </section>
@endsection