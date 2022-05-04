@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row dark">
            <td>
                <span class="title">
                      {{ trans('all.hello') }}, {{ $client->name }}
                </span>
            </td>
        </tr>

        <tr class="row dark">
            <td style="padding: 20px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
            {!! trans('email.user_invited_you', ['user' => '<span class="semiBold">'.$user->name.'</span>']) !!}
            </td>
        </tr>

        <tr class="row dark">
            <td style="padding: 10px 35px 20px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
            {{ trans('email.for_your_comfort_after_register') }}
            </td>
        </tr>

        <tr class="row white center">
            <td style="padding: 35px 35px">
                <a href="{{ url('/invitation', ['token' => $token]) }}" class="btn btn-green semiBold" style="font-size:16px; font-family: Arial,Sans-Serif,serif;">{{ trans('email.join') }}</a>
            </td>
        </tr>

        <tr class="row white">
            <td style="padding: 10px 35px 0px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
            {{ trans('email.with_best_regards') }},
            </td>
        </tr>

        <tr class="row white">
            <td style="padding: 0px 35px 15px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
            {{ trans('email.team_innlogist') }}
            </td>
        </tr>

        <tr class="row white" style="padding: 0px 0px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
            <div class="border_bottom"></div>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection