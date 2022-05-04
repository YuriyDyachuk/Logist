<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

        <!-- Favicon section -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{url('/main_layout/images/favicons/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" href="{{url('/main_layout/images/favicons/favicon-32x32.png')}}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{url('/main_layout/images/favicons/favicon-16x16.png')}}" sizes="16x16">
        <link rel="manifest" href="{{url('/main_layout/images/favicons/manifest.json')}}">
        <link rel="mask-icon" href="{{url('/main_layout/images/favicons/safari-pinned-tab.svg')}}" color="#073a85">

        <!-- Styles -->
	    <link rel="stylesheet" type="text/css" href="{{ url('/bower-components/bootstrap/dist/css/bootstrap.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ url('/bower-components/font-awesome/css/font-awesome.min.css') }}">

        <!-- Scripts -->
        <script type="text/javascript" src="{{ url('bower-components/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif !important;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
                display: inline-flex;
                align-items: baseline;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .language-dropdown .flag{
                display: inline-block;
                background-repeat: no-repeat;
                background-position: 0 -2px;
                width: 70px;
                padding-left: 24px;
                background-size: contain;
            }

            .language-dropdown .dropdown-toggle .flag{
                width: 55px;
                padding-left: 30px;
                text-transform: uppercase;
            }

            .language-dropdown .dropdown-menu button{
                width: 100%;
            }

            .language-dropdown .dropdown-menu {
                min-width: 70px;
            }

            .dropdown-menu li:hover{
                background-color: #eee;
            }

            .flag.en {
                background-image: url("img/flags/en_flag.png");
            }

            .flag.ru {
                background-image: url("img/flags/ru_flag.png");
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <ul class="dropdown language-dropdown">
                        <form id="language" action="{{ url('/language') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="flag {{ App::getLocale('locale') }}">{{ App::getLocale('locale') }}</span>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <button class="btn btn-link" type="submit" form="language" name="locale" value="en">
                                    <span class="flag en">EN</span>
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-link" type="submit" form="language" name="locale" value="ru">
                                    <span class="flag ru">RU</span>
                                </button>
                            </li>
                        </ul>
                    </ul>

                    @if (Auth::check())
                        <a href="{{ url('/home') }}">{{trans('all.home')}}</a>
                    @else
                        <a href="{{ url('/login') }}">{{trans('all.login')}}</a>
                        <a href="{{ url('/register') }}">{{trans('all.register')}}</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    inn-logist
                </div>
            </div>
        </div>
    </body>
</html>
