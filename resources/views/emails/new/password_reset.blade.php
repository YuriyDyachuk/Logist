@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row center">
            <td>
                <span class="title">
                      {{ trans('email.password_reset_title') }}
                </span>
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {!! trans('email.password_reset', ['link' => $link]) !!}
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