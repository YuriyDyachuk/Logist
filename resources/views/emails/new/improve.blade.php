@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">
        <tr class="row">
            <td>
                <span class="title" style="background-color: #007cff; display: inline-block;text-align: left;padding:18px 40px 17px 40px;color: #ffffff;font-size:22px;float: left;font-family: 'opensans-semibold';">{{ trans('all.hello') }}, {{$data['to']}}!</span>
                <div class="clear"></div>
            </td>
        </tr>

        <tr>
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.name') }}: {{ $data['name'] }}</td>
        </tr>

        <tr>
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.email_address') }}: {{ $data['email'] }} </td>
        </tr>

        <tr>
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.subject') }}: {{ $data['subject'] }}</td>
        </tr>

        <tr>
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.text') }}: {{ $data['message'] }}</td>
        </tr>

        @if($data['files_uploaded'])
        <tr>
            <td style="padding: 15px 40px; color:#ffffff; text-align: left; font-size:16px; font-family: 'opensans-regular';">{{ trans('email.files_was_attached') }}</td>
        </tr>
        @endif

        @include('emails.new.parts.footer')
    </table>
@endsection