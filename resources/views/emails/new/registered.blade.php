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
            <td class="row center" style="padding: 15px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.get_easy') }}
            </td>
        </tr>


        <tr>
            <td class="row center white semiBold" style="padding: 10px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.for_next_activation_you_need') }}
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.upload_your_official_docs') }}
            </td>
        </tr>

        <tr>
            <td class="row center white" style="padding: 10px 35px 30px 35px">
                <a href="{{ url('profile') }}" class="btn btn-green semiBold" style="text-align: left; font-size:16px; font-family: 'opensans-semibold';">{{ trans('email.upload_documents') }}</a>
            </td>
        </tr>

        <tr>
            <td class="row dark" style="padding: 15px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                <div>{{ trans('email.link_for_login') }} <a href="{{ route('login') }}">{{ route('login') }}</a></div>
                <div>{{ trans('email.login') }} {{ $user->email }}</div>
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 15px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.you_get_free_use') }}
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px 0px 35px; ;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.with_best_regards') }},
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 35px 15px 35px; ;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{ trans('email.team_innlogist') }}
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 0px 0px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                <div class="border_bottom"></div>
            </td>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection