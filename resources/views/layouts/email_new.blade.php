<!doctype html>
<html lang="en">
<head>
    <style>
        @font-face {
            font-family: 'opensans-regular';
            src: url('{{ url('main_layout/fonts/open-sans-webfont.eot') }}');
            src: url('{{ url('main_layout/fonts/open-sans-webfont.eot?#iefix')}}') format('embedded-opentype'),
            url('{{ url('main_layout/fonts/open-sans-webfont.woff2')}}') format('woff2'),
            url('{{ url('main_layout/fonts/open-sans-webfont.woff')}}') format('woff'),
            url('{{ url('main_layout/fonts/open-sans-webfont.ttf')}}') format('truetype'),
            url('{{ url('main_layout/fonts/open-sans-webfont.svg#open_sansregular')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'opensans-semibold';
            src: url('{{url('main_layout/fonts/open-sans-semibold-webfont.eot')}}');
            src: url('{{url('main_layout/fonts/open-sans-semibold-webfont.eot?#iefix')}}') format('embedded-opentype'),
            url('{{url('main_layout/fonts/open-sans-semibold-webfont.woff2')}}') format('woff2'),
            url('{{url('main_layout/fonts/open-sans-semibold-webfont.woff')}}') format('woff'),
            url('{{url('main_layout/fonts/open-sans-semibold-webfont.svg#open_sanssemibold')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'opensans-bold';
            src: url('{{ url('main_layout/fonts/open-sans-bold-webfont.eot')}}');
            src: url('{{ url('main_layout/fonts/open-sans-bold-webfont.eot?#iefix')}}') format('embedded-opentype'),
            url('{{ url('main_layout/fonts/open-sans-bold-webfont.woff2')}}') format('woff2'),
            url('{{ url('main_layout/fonts/open-sans-bold-webfont.woff')}}') format('woff'),
            url('{{ url('main_layout/fonts/open-sans-bold-webfont.ttf')}}') format('truetype'),
            url('{{ url('main_layout/fonts/open-sans-bold-webfont.svg#open_sansbold')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        body.wrap{
            background: #f2f7fa;
            width: 100%;
            margin: 25px auto auto 0px;
            text-align: center;
            font-family: 'opensans-regular';
        }

        .wrap > .email{
            width: 825px;
            margin: 0 auto;
        }

        .center{
            text-align: center !important;
        }

        .center > div,
        .center > span
        {
            float: none;
        }

        .semiBold{
            font-family: Arial,Sans-Serif,serif;
            font-weight: bold;
        }


        .email .logo {

        }

        .clear{
            clear: both;
        }

        .row.white,
        .content.white{
            background-color: #ffffff;
            color:#202020;
        }

        .dark{
            background-color: #26496d;
            color:#ffffff;
        }

        .dark-default{
            padding-top: 15px;
            padding-bottom:15px
        }

        .dark a{
            color:#ffffff;
        }

        .content .row{
            text-align: left;
        }

        .content{
            background-color: #26496d;
            width: 100%;
            margin-top:10px;
            color: #e4e9ed;
            -webkit-box-shadow: 4px 4px 24px -2px rgba(0,0,0,0.59);
            -moz-box-shadow: 4px 4px 24px -2px rgba(0,0,0,0.59);
            box-shadow: 4px 4px 24px -2px rgba(0,0,0,0.59);
        }

        .title {
            background-color: #007cff;
            display: inline-block;
            text-align: left;
            padding:18px 40px 17px 40px;
            color: #fff;
            font-size:22px;
            float: left;
            font-family: Arial,Sans-Serif,serif;
            /*font-family: 'opensans-semibold';*/
        }

        .main-content{
            padding:20px 0px 25px 0px;
            text-align: left;
        }

        .main-content > div {
            padding-left:40px;
            padding-right: 40px;
        }

        .main-content .link{
            background-color: #29425d;
            padding-top:12px;
            padding-bottom:12px;
            margin-top: 15px;
            color: #6dbfd7;
        }
        .main-content .link a {
            color: #83e9ff;
            text-decoration: none;
        }

        .row.white a,
        .row.white{
            color:#000000;
        }

        .footer{
            padding:19px 40px;
        }

        .border_bottom{
            border-bottom:1px solid #cfcfcf;
            margin:0px 40px 0px 40px;
        }

        .footer a,
        .footer{
            background: #ffffff;
            color:#101010;
            font-weight: 600;
            text-align: left;
            text-decoration: none;
            font-size: 16px;
        }

        .btn{
            display: inline-block;
            padding:15px 20px;
            border-radius: 25px;
            text-decoration: none;;
        }

        .btn-green {
            background-color: #00c864;
            color: #ffffff !important;
        }

    </style>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body class="wrap" style="background: #f2f7fa;width: 100%;margin: 25px auto auto 0px;text-align: center; font-family: Arial,Sans-Serif,serif;">
    <table class="email" style="border:0px; margin-top: 15px;" cellpadding="0" cellspacing="0">
        <tr class="header">
            <td class="logo">
                <img src="{{ url('img/logo_email.png') }}" style="float: left;"> &nbsp;
            </td>
        </tr>

        <tr>
            <td>
                @yield('content')
            </td>
        </tr>


    </table>
</body>
</html>