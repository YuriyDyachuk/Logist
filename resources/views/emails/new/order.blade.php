@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row">
            <td>
            <span class="title">{{ trans('all.hello') }}, {{$client->name}}!</span>
            </td>
        </tr>

        <tr class="row">
            <td class="row" style="padding: 20px 35px; text-align: left;padding:18px 40px 17px 40px;color: #ffffff;font-size: 16px;font-family: Arial,Sans-Serif,serif;">
                {!! trans('email.user_invited_you_to_become_partner', ['user' => '<span class="semiBold">'.$user->name.'</span>']) !!}
            </td>
        </tr>

        <tr class="row">
            <td class="row white center" style="padding:35px 35px 0px 35px; text-align: center;">
                <a href="{{ route('orders.show', [$order->id]) }}" class="btn btn-green semiBold" style="padding:18px 40px 17px 40px;color: #ffffff;font-size:16px;font-family: Arial,Sans-Serif,serif;font-weight: bold;">{{ trans('email.go_to_order') }}</a>
            </td>
        </tr>

        <tr class="row">
            <td class="row white" style="padding:35px 35px 0px 35px; text-align: center;padding:18px 40px 17px 40px;color: #202020;font-size:16px;font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.you_can_register_in_system') }}
            </td>
        </tr>

        <tr class="row">
            <td class="row white center" style="padding: 15px 35px; text-align: center;">
                <a href="{{ route('register.account', ['logistic']) }}" class="btn btn-green semiBold" style="padding:18px 40px 17px 40px;color: #ffffff;font-size:16px;font-family: Arial,Sans-Serif,serif;font-weight: bold;">{{ trans('email.register') }}</a>
            </td>
        </tr>

        <tr class="row">
            <td class="row white" style="padding: 10px 35px 0px 35px; text-align: left;color: #202020;font-size:16px;font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.with_best_regards') }},
            </td>
        </tr>

        <tr class="row">
            <td class="row white" style="padding: 0px 35px 15px 35px; ; text-align: left;color: #202020;font-size:16px;font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.team_innlogist') }}
            </td>
        </tr>

        <tr class="row">
            <td class="row white" style="padding: 0px 0px;">
                <div class="border_bottom"></div>
            </td>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection