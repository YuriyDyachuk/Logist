@extends('layouts.email_new')
@section('content')
    <table class="content white" style="margin-bottom: 15px;" cellpadding="0" cellspacing="0">
        <tr class="row">
            <td>
                <span class="title">{{ trans('all.hello') }}, {{$user->name}}!</span>
            </td>
        </tr>

        <tr class="row">
            <td style="padding: 15px 40px 0px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
            {{ trans('email.service_hello', ['name' => $admin->name]) }}
            </td>
        </tr>

        <tr class="row semiBold" style="padding-top: 35px; padding-bottom: 15px;">
            <td style="padding: 0px 40px 15px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
            {{ trans('email.easy_system') }}
            </td>
        </tr>

        <tr class="dark dark-default">
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">
                <div>{{ trans('email.short_course') }} <a href="{{ url('/faq') }}">{{ url('/faq') }}</a></div>
                <div>{{ trans('email.visual') }} <a href="{{ url('/') }}/#fourth-display">{{ url('/') }}</a></div>
                <div>{{ trans('email.reviews_are_here') }} <a href="{{ url('/') }}/#sixth-display">{{ url('/') }}</a></div>
            </td>
        </tr>

        <tr class="row" style="padding-top: 10px;">
            <td style="padding: 15px 40px 0px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
            {{ trans('email.if_you_have_any_questions') }}
            </td>
        </tr>

        <tr class="row white" style="padding-top: 35px;">
            <td style="padding: 15px 40px 0px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
            <a href="{{ url('/') }}">{{ url('/') }}</a>
            <a href="mailto:{{env('MAIL_FROM_ADDRESS')}}">{{env('MAIL_FROM_ADDRESS')}}</a>
            </td>
        </tr>

        <tr class="row" style="padding-top: 35px;">
            <td style="padding: 15px 40px 0px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
            {{ trans('email.fast_response') }}
            </td>
        </tr>

        <tr>
            <td style="padding: 30px 40px 0px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.have_a_nice_day') }} {{ $admin->name }},</td>
        </tr>
        <tr style="padding-top: 10px;">
            <td style="padding: 0px 40px 15px 40px; color:#202020; text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.team_innlogist') }}
            </td>
        </tr>


        <div class="border_bottom"></div>

        @include('emails.new.parts.footer')
    </table>
@endsection