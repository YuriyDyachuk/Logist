@extends('layouts.email')
@section('content')
    {{trans('all.activation_email_body')}}<br />
    <a href="{{route('user.activate', $token)}}">{{route('user.activate', $token)}}</a><br />
    {{trans('all.email_copyright')}}.
@endsection