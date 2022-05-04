<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'inn.logist') }} @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/jquery-eu-cookie-law-popup/css/jquery-eu-cookie-law-popup.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/youtubepopup/YouTubePopUp.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/swiper/dist/css/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('main_layout/css/landing/style.css') }}">


    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/manifest.json">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">


    <script type="text/javascript">
        (function(e,t){var n=e.amplitude||{_q:[],_iq:{}};var r=t.createElement("script")
        ;r.type="text/javascript";r.async=true
        ;r.src="https://cdn.amplitude.com/libs/amplitude-4.4.0-min.gz.js"
        ;r.onload=function(){if(e.amplitude.runQueuedFunctions){
            e.amplitude.runQueuedFunctions()}else{
            console.log("[Amplitude] Error: could not load SDK")}}
        ;var i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)
        ;function s(e,t){e.prototype[t]=function(){
            this._q.push([t].concat(Array.prototype.slice.call(arguments,0)));return this}}
            var o=function(){this._q=[];return this}
            ;var a=["add","append","clearAll","prepend","set","setOnce","unset"]
            ;for(var u=0;u<a.length;u++){s(o,a[u])}n.Identify=o;var c=function(){this._q=[]
                ;return this}
            ;var l=["setProductId","setQuantity","setPrice","setRevenueType","setEventProperties"]
            ;for(var p=0;p<l.length;p++){s(c,l[p])}n.Revenue=c
            ;var d=["init","logEvent","logRevenue","setUserId","setUserProperties","setOptOut","setVersionName","setDomain","setDeviceId","setGlobalUserProperties","identify","clearUserProperties","setGroup","logRevenueV2","regenerateDeviceId","logEventWithTimestamp","logEventWithGroups","setSessionId","resetSessionId"]
            ;function v(e){function t(t){e[t]=function(){
                e._q.push([t].concat(Array.prototype.slice.call(arguments,0)))}}
                for(var n=0;n<d.length;n++){t(d[n])}}v(n);n.getInstance=function(e){
                e=(!e||e.length===0?"$default_instance":e).toLowerCase()
                ;if(!n._iq.hasOwnProperty(e)){n._iq[e]={_q:[]};v(n._iq[e])}return n._iq[e]}
            ;e.amplitude=n})(window,document);

//        amplitude.getInstance().init("e7b290aaf03c2be881ab103528b32787");
        amplitude.getInstance().init("843e100a11e2bc268e869eb1d844719c");
    </script>

</head>
<body>
<section id="first-display">
    <nav class="navbar navbar-default transition">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">{{ trans('all.toggle_navigation') }}</span>
                    <span class="icon-bar transition"></span>
                    <span class="icon-bar transition"></span>
                    <span class="icon-bar transition"></span>
                </button>
                <a class="navbar-brand transition" href="javascript://"></a>

                <ul class="beta-menu navbar-brand">
                    <li class="transition">
                        <a href="javascript://" class="transition">
                            {{ trans('landing.beta_version') }}
                        </a>
                    </li>
                </ul>

            </div>

            <div class="collapse navbar-collapse transition" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="transition">
                        <a href="#third-display" class="transition">
                            {{ trans('landing.functional') }}
                        </a>
                    </li>
                    <li class="active transition">
                        <a href="#fourth-display" class="transition">
                            {{ trans('landing.excellence') }}
                        </a>
                    </li>
                    <li class="transition">
                        <a href="#sixth-display" class="transition">
                            {{ trans('landing.reviews') }}
                        </a>
                    </li>
                    <li class="transition">
                        <a href="#seventh-display" class="transition">
                            {{ trans('landing.contacts') }}
                        </a>
                    </li>
                    <li class="transition btn-beta">
                        <a href="{{ url('/login') }}" class="button-green transition link ">
                            {{ trans('landing.entrance') }}
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>

<section class="container-fluid header-block">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="header-block__text">
                <div class="header-block__text-wrapper">
                    <h1>{{trans('landing.header_text')}}</h1>
                    <p>
                        {{ trans('landing.sub_header_text') }}
                    </p>
                    <div class="header-block__text-fieldset">
                        <form action="{{ url('/request-test') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="role" value="company">
                            <input type="text" name="from" placeholder="{{ trans('landing.test_placeholder') }}">
                            <button type="submit" class="button-green transition">
                                {{ trans('landing.button_testing') }}
                            </button>
                            <div class="error from text-left" data-error="{{ trans('landing.error_email') }}"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#second-display" class="header-block__next scroll">
        <i class="header-block__next-button"></i>
    </a>
</section>

<section class="container-fluid background-block left">
    <div class="row__backgraund">
        <span>{{ trans('landing.online_service') }}</span>
    </div>
</section>

<section id="second-display" class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h2 class="h2">
                <span>{{ trans('landing.online_service') }}</span>
                <span>{{ trans('landing.management_transport') }}</span>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="tr-companies col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_companies') }}</h3>
                    <p>{{ trans('landing.online_service_desc_companies') }}</p>
                </div>
            </div>
        </div>

        <div class="atm-business col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_business') }}</h3>
                    <p>{{ trans('landing.online_service_desc_business') }}</p>
                </div>
            </div>
        </div>

        <div class="track-location col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_location') }}</h3>
                    <p>
                        {{ trans('landing.online_service_desc_location') }}
                        <a href="javascript://" class="button-green btn link-android-app transition btn-coming-soon">TRACKING
                            APP</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="trs-clients col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_clients') }}</h3>
                    <p>{{ trans('landing.online_service_desc_clients') }}</p>
                </div>
            </div>
        </div>

        <div class="monitoring col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_monitoring') }}</h3>
                    <p>{{ trans('landing.online_service_desc_monitoring') }}</p>
                </div>
            </div>
        </div>

        <div class="electronic-doc col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="table-block">
                <div class="table-cell">
                    <i class="table-ico"></i>
                    <h3 class="h3">{{ trans('landing.online_service_title_electronic') }}</h3>
                    <p>{{ trans('landing.online_service_desc_electronic') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row contact-form">
        <div class="col-sm-12 col-xs-12 clearfix">
            <div class="contact-form__text-label">
                <span>{{ trans('landing.test_label') }}</span>
            </div>
            <div class="contact-form__text-fieldset">
                <form action="{{ url('/request-test') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="from" placeholder="{{ trans('landing.test_placeholder') }}">
                    <button type="submit" class="button-green transition">
                        {{ trans('landing.button_testing') }}
                    </button>
                    <div class="error from" data-error="{{ trans('landing.error_email') }}"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid background-block right">
    <div class="row__backgraund">
        <span>{{ trans('landing.functional') }}</span>
    </div>
</section>

<section id="third-display" class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h2 class="h2">
                <span>{{ trans('landing.functional') }}</span>
                <span>{{ trans('landing.system') }}</span>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <ul id="function-system" class="nav nav-tabs" role="tablist">
                <li class="transition">
                    <a href="#tab_1" class="transition"
                       aria-controls="tab_1" role="tab" data-toggle="tab">
                        <h4 class="h4 transition">
                            {{ trans('landing.system_box_tab_title') }}
                        </h4>
                        <p class="transition">
                            {{ trans('landing.system_box_tab_limit') }}
                            <br>
                            {{ trans('landing.system_box_tab_price') }}
                        </p>
                    </a>
                </li>

                <li class="transition">
                    <a href="#tab_2" class="transition"
                       aria-controls="tab_2" role="tab" data-toggle="tab">
                        <h4 class="h4 transition">
                            {{ trans('landing.system_box_tab_pro_title') }}
                        </h4>
                        <p class="transition">
                            {{ trans('landing.system_box_tab_pro_limit') }}
                            <br>
                            {{ trans('landing.system_box_tab_pro_price') }}
                        </p>
                    </a>
                </li>

                <li class="transition">
                    <a href="#tab_3" class="transition"
                       aria-controls="tab_3" role="tab" data-toggle="tab">
                        <h4 class="h4 transition">
                            {{ trans('landing.system_box_tab_enterprise_title') }}
                        </h4>
                        <p class="transition">
                            {{ trans('landing.system_box_tab_enterprise_limit') }}
                            <br>
                            <button type="button" class="button-green transition btn btn-tab"
                                    data-toggle="modal"
                                    data-target="#modal-form">
                                {{ trans('landing.system_box_tab_enterprise_price') }}</button>
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <br><br><br>

    <div class="row zebra">
        <div class="tab-content col-lg-4 col-lg-offset-2 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
            <h4 class="h4">{{ trans('landing.system_box_title') }}</h4>

            <div role="tabpanel" class="tab-pane fade" id="tab_1">
                <ul>
                    <li><span>{{ trans('landing.privilege_account') }}</span></li>
                    <li><span>{{ trans('landing.privilege_order') }}</span></li>
                    <li><span>{{ trans('landing.privilege_trans') }}</span></li>
                    <li><span>{{ trans('landing.privilege_doc') }}</span></li>
                </ul>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="tab_2">
                <ul>
                    <li><span>{{ trans('landing.privilege_order') }}</span></li>
                    <li><span>{{ trans('landing.privilege_trans') }}</span></li>
                    <li><span>{{ trans('landing.privilege_doc') }}</span></li>
                    <li><span>{{ trans('landing.privilege_manage') }}</span></li>
                    <li><span>{{ trans('landing.privilege_driver') }}</span></li>
                    <li><span>{{ trans('landing.privilege_contract') }}</span></li>
                    <li><span>{{ trans('landing.privilege_finance') }}</span></li>
                    <li><span>{{ trans('landing.privilege_clients') }}</span></li>
                    <li><span>{{ trans('landing.privilege_analytic') }}</span></li>
                </ul>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="tab_3">
                <ul>
                    <li><span>{{ trans('landing.privilege_order') }}</span></li>
                    <li><span>{{ trans('landing.privilege_trans') }}</span></li>
                    <li><span>{{ trans('landing.privilege_doc') }}</span></li>
                    <li><span>{{ trans('landing.privilege_manage') }}</span></li>
                    <li><span>{{ trans('landing.privilege_driver') }}</span></li>
                    <li><span>{{ trans('landing.privilege_contract') }}</span></li>
                    <li><span>{{ trans('landing.privilege_finance') }}</span></li>
                    <li><span>{{ trans('landing.privilege_clients') }}</span></li>
                    <li><span>{{ trans('landing.privilege_analytic') }}</span></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-4 col-lg-offset-2 col-sm-6 col-xs-12">
            <h4 class="h4">{{ trans('landing.system_app_title') }}</h4>
            <div>
                <ul>
                    <li><span>{{ trans('landing.privilege_status') }}</span></li>
                    <li><span>{{ trans('landing.privilege_tracking') }}</span></li>
                    <li><span>{{ trans('landing.privilege_doc') }}</span></li>
                    <li><span>{{ trans('landing.privilege_time') }}</span></li>
                    <li><span>{{ trans('landing.privilege_nav') }}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <h2 class="h2 video_title">
            {!!  trans('landing.how_it_works') !!}
        </h2>
        <div class="flex-block text-center">
            <a href="https://www.youtube.com/watch?v=t2UnuTnicE4" class="playVideo">
                <img src="{{ url('img/landing_video.png') }}">
            </a>
        </div>
    </div>

</section>

<section class="container-fluid background-block left">
    <div class="row__backgraund">
        <span>{{ trans('landing.excellence') }}</span>
    </div>
</section>

<section id="fourth-display" class="container">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-12">
            <h4 class="h4">{{ trans('landing.excellence') }}</h4>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-12">
            <a href="javascript://" class="button-green transition"
               onclick="$( this ).html( '<span>'+$( this ).data( 'error' )+'</span>' );"
               data-error="{{ trans('landing.error_step_dev') }}">
                <span>{!! trans('landing.button_connect') !!}</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_cloud') }}</span>
        </div>

        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_analytic') }}</span>
        </div>

        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_start') }}</span>
        </div>

        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_service') }}</span>
        </div>

        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_doc') }}</span>
        </div>

        <div class="table-block col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <i class="tick-sign"></i>
            <span>{{ trans('landing.excellence_box_process') }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h2 class="h2">
                <span>{{ trans('landing.how_to_start') }}</span>
                <span>{{ trans('landing.how_to_work') }}</span>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="flex-block">
                <div class="flex-box">
                    <div class="flex-box__wrapper">
                        <i class="flex-box__wrapper-icon loged-ico"></i>
                        <span class="flex-box__wrapper-title">
								<span>{{ trans('landing.register_and_login') }}</span>
							</span>
                    </div>
                </div>
                <div class="flex-box">
                    <div class="flex-box__wrapper">
                        <i class="flex-box__wrapper-icon work-ico"></i>
                        <span class="flex-box__wrapper-title">
								<span>{!! trans('landing.get_to_work') !!}</span>
							</span>
                    </div>
                </div>
                <div class="flex-box">
                    <div class="flex-box__wrapper">
                        <div class="flex-box__wrapper-dotted">
                            <div class="flex-box__wrapper-dott"></div>
                            <div class="flex-box__wrapper-dott"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="animated-start"></div>
        </div>
    </div>
</section>

<section id="fifth-display" class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-1 col-sm-6 col-xs-12">
            <div class="image-wrapper">
                <img src="{{ url('main_layout/images/landing/mockup_innlogist.png') }}">
            </div>
        </div>

        <div class="col-lg-5 col-sm-6 col-xs-12">
            <h3 class="h3">{!! trans('landing.web_and_app') !!}</h3>
            <p>{{ trans('landing.all_time_and_location') }}</p>
            <a href="javascript://"
               class="button-green transition btn-coming-soon">{{ trans('landing.dowmload_app') }}</a>
        </div>
    </div>
</section>

<section id="sixth-display" class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h2 class="h2">
                <span>Отзывы</span>
                <span>клиентов</span>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
            <!-- Swiper -->
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="swiper-avatar">
                            <img src="{{ url('main_layout/images/landing/avatar-1.jpg') }}">
                        </div>
                        <div class="swiper-review">
                            <p>
                                "Спасибо за удобный инструмент в ускорении ежедневной работы.
                                У нас появилась возможность отслеживать транспорт не только при помощи GPS. И не только
                                транспорт, но и работу водителей. У логистов появилась возможность дистанционно
                                управлять заказами и их выполнением в разы быстрее. Отслеживать статус и быть уверенными
                                в своей оперативности. Спасибо за сервис!"
                            </p>
                            <div class="h3">
                                Александр Шевченко
                            </div>
                            <div class="swiper-company">
                                Сharton company
                            </div>
                        </div>
                    </div>

                    {{--<div class="swiper-slide">--}}
                    {{--<div class="swiper-avatar">--}}
                    {{--<img src="{{ url('main_layout/images/landing/avatar-2.jpg') }}">--}}
                    {{--</div>--}}
                    {{--<div class="swiper-review">--}}
                    {{--<p>--}}
                    {{--"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque laborum voluptatibus,--}}
                    {{--voluptatem autem, enim suscipit, necessitatibus similique minus incidunt modi harum--}}
                    {{--dignissimos odit cum, reiciendis iure nisi totam temporibus. Accusantium explicabo--}}
                    {{--soluta eum distinctio, suscipit molestias neque et saepe rem numquam, quas eius dolores--}}
                    {{--porro voluptatem, enim odio pariatur ullam amet, minima omnis in recusandae unde illum--}}
                    {{--repellendus."--}}
                    {{--</p>--}}
                    {{--<div class="h3">--}}
                    {{--Ipsum Dolor--}}
                    {{--</div>--}}
                    {{--<div class="swiper-company">--}}
                    {{--Dit amet consectetur--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="swiper-slide">--}}
                    {{--<div class="swiper-avatar">--}}
                    {{--<img src="{{ url('main_layout/images/landing/avatar-3.jpg') }}">--}}
                    {{--</div>--}}
                    {{--<div class="swiper-review">--}}
                    {{--<p>--}}
                    {{--"Dicta, facilis, laudantium! Reiciendis nihil laboriosam in veritatis explicabo sunt--}}
                    {{--maiores mollitia voluptates asperiores culpa similique excepturi repellat vel ipsa sint--}}
                    {{--ipsam cumque corrupti quaerat itaque voluptatibus iure, provident autem. Vero asperiores--}}
                    {{--harum facilis architecto maxime unde eos vitae soluta qui. Officia."--}}
                    {{--</p>--}}
                    {{--<div class="h3">--}}
                    {{--Eliot Adipisicing--}}
                    {{--</div>--}}
                    {{--<div class="swiper-company">--}}
                    {{--Neque--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

<section id="seventh-display" class="container-fluid">
    <div class="row">
        <div class="col-lg-8  col-md-8 col-sm-9 col-xs-12">
            <h2 class="h2">
                <span>Обратная связь</span>
            </h2>
            <p>
                Мы заинтересованы делать сервис лучше и удобнее для каждого клиента. Если у вас есть предложения или
                пожелания - напишите нам!
            </p>

            <!-- Button trigger modal -->
            <button type="button" class="button-green transition btn btn-primary" data-toggle="modal"
                    data-target="#modal-form">
                написать
            </button>
        </div>
        <div class="col-xs-12 col-sm-9  col-md-4  col-lg-4 mail">
            <a href="mailto:info@inn-logist.com">info@inn-logist.com</a>
        </div>
    </div>
</section>

<footer class="container">
    <div class="row">
        <div class="col-sm-4 col-xs-6">
            © 2018. Innlogist. All rights reserved.
        </div>
        <div class="col-sm-4 col-xs-6">
            <style>
                .footer_page::after {
                    content: '';
                }
            </style>
            <a href="{{route('page.privacy')}}" class="footer_page" style="">Политика конфиденциальности</a>
            <a href="{{route('page.terms')}}" class="footer_page" style="">Пользовательское соглашение</a>
        </div>
        <div class="col-sm-4 col-xs-6">
            {{--Design by <a href="http://www.amconsoft.com" target="_blank">Amconsoft</a>--}}
            Design by <span style="color: #0b82ff">E.33</span>
        </div>
    </div>
</footer>

<div class="container-fixed">
    <div id="scrol-top">
        <span class="swing"></span>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modal-form" tabindex="-1" role="dialog"
     aria-labelledby="modal-formTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="feedback">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span>Связаться</span>
                        <span>с нами</span>
                    </h5>
                    <button type="button" class="close transition" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body form-feedback">
                    <fieldset>
                        <div>
                            <input class="transition" type="text" name="name" value="" required>
                            <label class="transition">Имя</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>

                        <div>
                            <input class="transition" type="text" name="email" value="" required>
                            <label class="transition">Email</label>
                            <div class="modal-error transition">Неверные данные</div>
                        </div>

                        <div>
                            <input class="transition" type="text" name="subject" value="" required>
                            <label class="transition">Тема</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>
                    </fieldset>

                    <fieldset class="text-message">
                        <div>
                            <textarea name="message" required></textarea>
                            <label>Сообщение</label>
                            <div class="modal-error message transition">Поле обязательно</div>
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button id="modal-send" type="button" class="button-green transition btn btn-primary">Отправить
                    </button>
                </div>
            </div>

            <div class="correct-send hidden transition">
                <div class="correct-send_wrapper">
                    <div class="correct-send_table">
                        <span>Сообщение успешно</span>
                    </div>
                    <div class="correct-send_table">
                        <span>отправленно</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.includes.cookie-warning');

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'mOhGeIUfDG';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
<!-- Scripts -->
<script type="text/javascript" src="{{ url('bower-components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/youtubepopup/YouTubePopUp.jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/jquery.viewportchecker/dist/jquery.viewportchecker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/swiper/dist/js/swiper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/main_layout/js/landing.js') }}"></script>
</body>
</html>
