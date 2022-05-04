<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title ?? ''}}</title>

<!-- Styles -->

{{--    <link rel="stylesheet" type="text/css" href="{{ url('/main_layout/css/pdf.css')}}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ url('/main_layout/css/template.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{ url('/css/pdf.css')}}">

{{--@include('layouts.includes.css_files_new')--}}

    <style>
        span {
            font-size: 14px;
        }
        input {
            color: #323232;
            border: none;
            background-color: rgba(0, 0, 0, 0.05)
        }
    </style>

<!-- Script -->
    {{--<script type="text/javascript" src="{{ url('js/app.js') }}"></script>--}}
</head>
<body>
@yield('content')
</body>
</html>