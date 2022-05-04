@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row">
            <td>
                <span class="title">
                      {{ trans('all.hello') }}, {{ $client->name }}
                </span>
            </td>
        </tr>


        <tr>
            <td class="row" style="padding: 20px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {!! trans('email.user_invited_you_to_become_partner', ['user' => '<span class="semiBold">'.$user->name.'</span>']) !!}
            </td>
        </tr>

        <tr>
            <td class="row white center" style="padding: 35px 35px 20px 35px; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                <a href="{{route('user.activate', $token)}}" class="btn btn-green semiBold" style="font-size:16px; font-family: Arial,Sans-Serif,serif;">{{ trans('email.join') }}</a>
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px 0px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.with_best_regards') }},
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 35px 15px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.team_innlogist') }}
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 35px 15px 35px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">
                {{ trans('email.password') }} - {{$password}}
            </td>
        </tr>

        <tr class="row white" style="padding: 0px 0px;">
            <div class="border_bottom"></div>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection