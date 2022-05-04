@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">
        <tr class="row">
            <td>
                <span class="title" style="background-color: #007cff; display: inline-block;text-align: left;padding:18px 40px 17px 40px;font-size:22px;float: left;font-family: 'opensans-semibold';">{{ trans('all.hello') }}, {{$user->name}}!</span>
                <div class="clear"></div>
            </td>
        </tr>

        <tr>
            <td style="padding: 15px 40px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">{{ trans('email.activate_approve_text') }}:</td>
        </tr>

        <tr>
            <td style="padding: 10px 40px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif; background-color: #28425d; color:#83e9ff; text-decoration: none;">
                <div class="link">
                    <a href="{{ route('register.verification', $token) }}" style="color:#83e9ff">{{ route('register.verification', $token) }}</a>
                </div>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px 40px 0px 40px; text-align: left;font-size:16px; font-family: Arial,Sans-Serif,serif;">{{ trans('email.with_best_regards') }},</td>
        </tr>
        <tr>
            <td style="padding: 0 40px 15px 40px; text-align: left; font-size:16px; font-family: Arial,Sans-Serif,serif;">{{ trans('email.team_innlogist') }}</td>
        </tr>


        @include('emails.new.parts.footer')
    </table>
@endsection