@extends('layouts.email_new')
@section('content')
    <table class="content" style="border:0px; margin-bottom:30px;" cellpadding="0" cellspacing="0">

        <tr class="row center">
            <td>
                <span class="title">
                      {{ $title }}
                </span>
            </td>
        </tr>

        <tr>
            <td class="row white" style="padding: 10px 35px 0px 35px; ;text-align: left; font-size:16px; font-family: 'opensans-regular';">
                {{$msg}}
            </td>
        </tr>

        @include('emails.new.parts.footer')

    </table>
@endsection