@extends('layouts.email')
@section('content')
    {{trans('all.password_changed_text')}}<br />
    <a href="{{route('user.password.accept', $token)}}">{{route('user.password.accept', $token)}}</a><br />
    {{trans('all.email_copyright')}}
@endsection