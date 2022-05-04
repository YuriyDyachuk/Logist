@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row center">
            <td>
                <span class="title">
                      {{ trans('email.your_account_registered', ['user'=>$user->name]) }}
                </span>
            </td>
        </tr>

        <tr>
            <td class="row dark" style="padding: 15px 35px;text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                <div style="margin-bottom: 5px;">{{ trans('email.link_for_login') }} <a href="{{ route('login') }}">{{ route('login') }}</a></div>
                <div>{{ trans('email.login') }} {{ $user->email }}</div>
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px 0px 35px; ;text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.with_best_regards') }},
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 35px 15px 35px; ;text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.team_innlogist') }}
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 0px;text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                <div class="border_bottom"></div>
            </td>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection