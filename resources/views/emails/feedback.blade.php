@extends('layouts.email')
@section('content')
    <h4>Имя: {{ $feedback->name }}</h4>
    <h4>Email: {{ $feedback->email }}</h4>
    <h4>Тема: {{ $feedback->subject }}</h4>
    <br>
    <h4>Сообщение:</h4>
    <p>{{ $feedback->message }}</p>
@endsection