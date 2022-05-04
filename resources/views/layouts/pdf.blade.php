<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
{{--    <title>{{ $title }}</title>--}}

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('/main_layout/css/pdf.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('/main_layout/css/template.css')}}">
    {{--@include('layouts.includes.css_files_new')--}}

    <!-- Script -->
    <script type="text/javascript" src="{{ url('js/app.js') }}"></script>
</head>
<body>
    @yield('content')
</body>
</html>