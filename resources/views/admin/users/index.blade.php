@extends('admin.layouts.app')
@section('title', trans('all.users'))
@section('content')

    <section class="content-header">
        <h1>{{trans('all.dashboard')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> {{trans('all.home')}}
                </a></li>
            <li><i class="fa fa-dashboard"></i> {{trans('all.users')}}</li>
        </ol>
    </section>
    <div class="col-xs-12">
        <div class="list-group">
            @forelse($users as $key => $user)

                <li class="list-group-item">
                    <div>
                        <p>ID : <strong>{{$user->id}}</strong></p>
                        <p>{{trans('all.name')}} : <strong>{{$user->name}}</strong></p>
                        <p>{{trans('all.phone')}} : <strong>{{$user->phone}}</strong></p>
                        <p>{{trans('all.status')}} :
                            <strong>
                                {{$user->status}}
                            </strong>
                        </p>
                        <p>Email : <strong>{{$user->email}}</strong></p>

                        @if($user->hasRole('client-person'))@include('admin.users.index.client.person', ['user' => $user])
                        @elseif($user->hasRole('client-company'))@include('admin.users.index.client.company', ['user' => $user])
                        @elseif($user->hasRole('logistic-person'))@include('admin.users.index.logistic.person', ['user' => $user])
                        @elseif($user->hasRole('logistic-company'))@include('admin.users.index.logistic.company', ['user' => $user])
                        @endif

                        <a href="{{route('admin.user.get', $user->id)}}"
                           class="btn btn-sm btn-success">{{trans('all.view')}}</a>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    <div>{{trans('all.empty_list')}}</div>
                </li>
            @endforelse
        </div>
        <div class="text-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection

{{--
public function isCompany()
{
return $this->hasRole('client-company') || $this->hasRole('logistic-company');
}

/**
* True if the account is logistic
*
* @return bool
*/
public function isLogistic()
{
return  || $this->hasRole('');
}
--}}
