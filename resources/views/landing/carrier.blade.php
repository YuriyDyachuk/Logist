<!DOCTYPE html>
<html lang="ru">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113244328-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113244328-3');
    </script>

    <meta charset="utf-8">
    <title>Inn Logist</title>
    <meta name="description" content="{{ trans('landing.meta_description') }}">
    <meta name="viewport" content="width=device-width">
    <meta property="og:image" content="{{ url('images/landings/img/dest/preview.jpg') }}">
    <link rel="stylesheet" href="{{ url('images/landings/css/styles.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/font-awesome/css/font-awesome.min.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/main_layout/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-16x16.png') }}" sizes="16x16">

    <link rel="manifest" href="{{ url('images/landings/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('images/landings/safari-pinned-tab.svg') }}" color="#dc005e">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">


</head>

<body class="landing3">

<!-- CUSTOM HTML -->
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3 col-6">
                <div class="logo">
                    <a href="/">
                        <svg>
                            <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#inn_logo"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-9 col-6">
                <div class="right">
                    <div id="menu" class="menu_wrap">
                        <div class="links d-xl-none">
                            <a href="{{url('/login')}}">{{ __('landing.login') }}</a>
                            <a href="{{url('/register')}}">{{ __('landing.register') }}</a>
                        </div>


                        <div class="mnu__row d-xl-none">
                            <svg class="mnu__row_img">
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#mnu__img"></use>
                            </svg>
                            <h1 class="d-xl-none">{{ __('landing.for_carrier') }}</h1>
                        </div>
                        <ul id="main-menu" class="nav sm">
                            <li><a href="http://solution.innlogist.com{{  config('app.locale') == 'ru' ? '' : '/'.config('app.locale') }}">{{ __('landing.solution') }}</a></li>
                            <li class="d-none d-xl-block"><a href="{{ config('app.locale') == 'ru' ? url('/') : url('/'.config('app.locale')) }}">{{ __('landing.for_owner') }}</a></li>
                        </ul>
                        <!-- <a href="#" class="btn-default d-xl-none">Try it</a> -->
                        <a href="#" class="carrier">{{ __('landing.for_owner') }}
                            <svg class="carrier__ico">
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#open-in-new"></use>
                            </svg>
                        </a>
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>

                    </div>
                    <a href="{{url('/login')}}" class="login">{{ __('landing.login') }}</a>
                    <a href="{{url('/register')}}" class="btn-default">{{ __('landing.register') }}</a>
                    <ul id="lang" class="lang sm">
                        <li><svg>
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#lang"></use>
                            </svg>
                        </li>
                        <li>
                            @if(config('app.locale') == 'en') <a href="/en">EN</a> @elseif(config('app.locale') == 'ru') <a href="/ru">RU</a> @endif
                            <ul>
                                @if(config('app.locale') == 'en') <li><a href="{{url('/carrier/ru')}}">RU</a></li> @else<li><a href="{{url('/carrier/en')}}">EN</a></li> @endif
                            </ul>
                        </li>
                    </ul>
                    <a href="#" class="toggle-mnu d-xl-none"><span></span></a>
                </div>
            </div>
        </div>
    </div>
</header>


<section id="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h1>{{ __('landing.trucking_on-line') }}</h1>
                <img class="lazy img-responsive d-md-none"
                     src="{{ url('images/landings/img/@1x/hero3.png') }}"
                     data-src="{{ url('images/landings/img/@1x/hero3.png')}}"
                     data-srcset="{{ url('images/landings/img/@1x/hero3.png')}} 1x, {{ url('images/landings/img/@2x/hero3.png')}} 2x"
                     alt="Hero"
                     data-aos="fade-left">

                <div class="see d-md-none">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#play"></use>
                    </svg>
                    <p><a href="https://www.youtube.com/watch?v=t2UnuTnicE4" style="color: #7a7a7a;">{{ __('landing.see_how_it_works') }}</a></p>
                </div>
                <p>{{ __('landing.carrier_trucking_on-line_text') }}</p>
                <div class="block">
                    <a href="{{url('/register')}}" class="btn-default">{{ __('landing.try_it') }}</a>
                    <div class="see d-none d-md-flex">
                        <svg>
                            <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#play"></use>
                        </svg>
                        <p><a href="https://www.youtube.com/watch?v=t2UnuTnicE4" style="color: #7a7a7a;">{{ __('landing.see_how_it_works') }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <img class="lazy img-responsive d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/hero3.png')}}"
                     data-src="{{ url('images/landings/img/@1x/hero3.png')}}"
                     data-srcset="{{ url('images/landings/img/@1x/hero3.png')}} 1x, {{ url('images/landings/img/@2x/hero3.png')}} 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>
        </div>
    </div>
</section>



<section id="features">
    <div class="bg2"></div>
    <div class="bg3"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <h2>{{ __('landing.carrier_features') }}</h2>
                <p>{{ __('landing.carrier_features_text') }}</p>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-1"></use>
                    </svg>
                    {{ __('landing.carrier_features_transport') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-2"></use>
                    </svg>
                    {{ __('landing.carrier_features_orders_from_customers') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-3"></use>
                    </svg>
                    {{ __('landing.carrier_features_reduce_idle_runs') }}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-4"></use>
                    </svg>
                    {{ __('landing.carrier_features_ability_partial_loads') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-5"></use>
                    </svg>
                    {{ __('landing.carrier_features_sms') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#l3-6"></use>
                    </svg>
                    {!! __('landing.carrier_features_private_and_companies') !!}
                </div>

            </div>



        </div>
    </div>
</section>

<!-- Block Order on-line -->
<section id="order-block" class="order-block start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h2>{{ __('landing.order_online')}}</h2>
            </div>
        </div>

        <div class="row container">
            <!-- text -->
            <div class="title-text">
                <h4 class="route-info">{{ __('landing.route')}}</h4>
                <h4 class="cargo-info">{{ __('landing.cargo')}}</h4>
                <h4 class="transport-info">{{ __('landing.transport')}}</h4>
            </div>
            <!-- -->

            <!-- block inform -->
            <div class="col-lg-12 content-box__inform">
                <div class="content-box__row">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="line-map">
                                <div class="point-download"></div>
                                <div class="point-upload"></div>
                            </div>

                            <!-- additional_plus -->
                            <div class="additional-cargo_plus"></div>
                            <!-- End additional_plus -->

                            <div class="info-city_in">
                                <span class="">Днепр, ул. Баррикадая 2</span>
                            </div>
                            <div class="info-city_to">
                                <span class="">Одесса, ул. Ришельевская 4</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="info-cargo">
                                <span class="">Сахар, 20 тонн, 86м3</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="info-transport">
                                <span class="">Тент, задняя, боковая</span>
                            </div>
                        </div>

                        <div class="chevron-up">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>

                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12" id="dopInformBlock" style="display: none">
                        <div class="row">
                            <div class="col-lg-6 inform-order">
                                <div class="date-date_loading">
                                    <span class="label-font">{{__('landing.date_loading')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.date_unloading')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.distance')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.estimated_time')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.loading_address_place')}}: </span>
                                    <span></span>
                                </div>

                                <div>
                                    <a href="{{ url('login') }}" class="btn button-style1">{{__('landing.take_order')}}</a>
                                </div>

                            </div>

                            <div class="col-lg-6 inform-maps">
                                <div class="map-container">
                                    <div id="map"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- additional -->
                    <div class="additional_cargo">
                        <span>Догруз</span>
                    </div>
                    <!-- End additional -->


                </div>
            </div>
            <!-- -->

            <!-- block inform -->
            <div class="col-lg-12 content-box__inform">
                <div class="content-box__row">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="line-map">
                                <div class="point-download"></div>
                                <div class="point-upload"></div>
                            </div>

                            <div class="info-city_in">
                                <span class="">Днепр, ул. Баррикадая 2</span>
                            </div>
                            <div class="info-city_to">
                                <span class="">Одесса, ул. Ришельевская 4</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="info-cargo">
                                <span class="">Сахар, 20 тонн, 86м3</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="info-transport">
                                <span class="">Тент, задняя, боковая</span>
                            </div>
                        </div>

                        <div class="chevron-up">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </div>

                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12" id="dopInformBlock" style="display: none">
                        <div class="row">
                            <div class="col-lg-6 inform-order">
                                <div class="date-date_loading">
                                    <span class="label-font">{{__('landing.date_loading')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.date_unloading')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.distance')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.estimated_time')}}: </span>
                                    <span></span>
                                </div>

                                <div class="date-date_unloading">
                                    <span class="label-font">{{__('landing.loading_address_place')}}: </span>
                                    <span></span>
                                </div>

                                <div>
                                    <a href="{{ url('login') }}" class="btn button-style1">{{__('landing.take_order')}}</a>
                                </div>

                            </div>

                            <div class="col-lg-6 inform-maps">
                                <div class="map-container">
                                    <div id="map"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- -->

            <!-- block inform footer -->
            <div class="col-lg-12 footer-info">
                <p>{{ __('landing.info_carrier_order.title') }}</p>
            </div>
        </div>

        <div class="container-fluid footer-line">
            <hr>
        </div>
    </div>
</section>
<!-- End block Order on-line -->

<section class="start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12"><h2>{{ __('landing.carrier_how_work') }}</h2></div>
            <div class="col-lg-7">

                <div class="item">
                    <span class="step">{{ __('landing.carrier_step_1') }}</span>
                    <h3>{{ __('landing.carrier_step_1_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="{{ url('images/landings/img/@1x/start_1.png') }}"
                         data-src="{{ url('images/landings/img/@1x/start_1.png') }}"
                         data-srcset="{{ url('images/landings/img/@1x/start_1.png') }} 1x, {{ url('images/landings/img/@2x/start_1.png') }} 2x"
                         alt="Hero"
                         data-aos="fade-left">
                    <p>{{ __('landing.carrier_step_1_text_2') }}</p>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="lazy img-responsive d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/start_1.png') }}"
                     data-src="{{ url('images/landings/img/@1x/start_1.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/start_1.png') }} 1x, {{ url('images/landings/img/@2x/start_1.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>
        </div>

        <div class="row align-items-center step2">
            <div class="col-lg-7">
                <img class="lazy img-responsive d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/start_2.png') }}"
                     data-src="{{ url('images/landings/img/@1x/start_2.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/start_2.png') }} 1x, {{ url('images/landings/img/@2x/start_2.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-right">
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="item step-2">
                    <span class="step">{{ __('landing.carrier_step_2') }}</span>
                    <h3>{{ __('landing.carrier_step_2_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="{{ url('images/landings/img/@1x/start_2.png') }}"
                         data-src="{{ url('images/landings/img/@1x/start_2.png') }}"
                         data-srcset="{{ url('images/landings/img/@1x/start_2.png') }} 1x, {{ url('images/landings/img/@2x/start_2.png') }} 2x"
                         alt="Hero"
                         data-aos="fade-right">
                    <p>{{ __('landing.carrier_step_2_text_2') }}</p>
                </div>
            </div>
        </div>

        <div class="row align-items-center step3">
            <div class="col-lg-7">

                <div class="item">
                    <span class="step">{{ __('landing.carrier_step_3') }}</span>
                    <h3>{{ __('landing.carrier_step_3_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="{{ url('images/landings/img/@1x/start_1.png') }}"
                         data-src="{{ url('images/landings/img/@1x/start_1.png') }}"
                         data-srcset="{{ url('images/landings/img/@1x/start_1.png') }} 1x, {{ url('images/landings/img/@2x/start_1.png') }} 2x"
                         alt="Hero"
                         data-aos="fade-left">
                    <p>{{ __('landing.carrier_step_3_text_2') }}</p>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="lazy img-responsive d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/st4.png') }}"
                     data-src="{{ url('images/landings/img/@1x/st4.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/st4.png') }} 1x, {{ url('images/landings/img/@2x/st4.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>
        </div>

        <div class="row align-items-center step4">
            <div class="col-lg-7">
                <img class="lazy img-responsive d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/l3-st4.png') }}"
                     data-src="{{ url('images/landings/img/@1x/l3-st4.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/l3-st4.png') }} 1x, {{ url('images/landings/img/@2x/l3-st4.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-right">
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="item step-2">
                    <span class="step">{{ __('landing.carrier_step_4') }}</span>
                    <h3>{{ __('landing.carrier_step_4_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="{{ url('images/landings/img/@1x/start_2.png') }}"
                         data-src="{{ url('images/landings/img/@1x/start_2.png') }}"
                         data-srcset="{{ url('images/landings/img/@1x/start_2.png') }} 1x, {{ url('images/landings/img/@2x/start_2.png') }} 2x"
                         alt="Hero"
                         data-aos="fade-right">
                    <p>{{ __('landing.carrier_step_4_text_2') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="banner">
    <div class="container">
        <div class="banner__wrap">
            <h3 class="banner__title">{{ __('landing.banner_title') }}</h3>
            <p class="banner__descr">{{ __('landing.banner_descr') }}</p>
            <a href="http://solution.innlogist.com/" class="btn-default banner__btn">{{ __('landing.banner_more') }}</a>
        </div>
    </div>
</section>

{{--<section class="solutions">--}}
{{--    <div class="bg2"></div>--}}
{{--    <div class="bg3"></div>--}}
{{--    <div class="container">--}}
{{--        <div class="row sr">--}}
{{--            <div class="col-12">--}}
{{--                <div class="h">--}}
{{--                    <h2>{{ __('landing.carrier_solutions') }}</h2>--}}
{{--                    <p>{{ __('landing.carrier_solutions_text') }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <h4 class="d-none d-md-block">{{ __('landing.carrier_solutions_problem') }}</h4>--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_1') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <h4 class="d-none d-md-block">{{ __('landing.carrier_solutions_solution') }}</h4>--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_1') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_2') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_2') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_3') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_3') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_4') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_4') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_5') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_5') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_6') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_6') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row sr">--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="pr_item">--}}
{{--                    <ul class="ul pr">--}}
{{--                        {!! __('landing.carrier_solutions_problem_text_7') !!}--}}

{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="sl_item">--}}
{{--                    <ul class="ul sl">--}}
{{--                        {!!  __('landing.carrier_solutions_solution_text_7') !!}--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}


<section class="web">
    <div class="container be_static">
        <div class="row web-portal be_static">
            <div class="col-lg-5">
                <h2>{!! __('landing.web_portal_mobile_app') !!}</h2>
                <img class="lazy img-responsive mockup d-md-none"
                     src="{{ url('images/landings/img/@1x/web-portal.png') }}"
                     data-src="{{ url('images/landings/img/@1x/web-portal.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/web-portal.png') }} 1x, {{ url('images/landings/img/@2x/web-portal.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-left">

                <img class="lazy img-responsive phone d-md-none"
                     src="{{ url('images/landings/img/@1x/phone.png') }}"
                     data-src="{{ url('images/landings/img/@1x/phone.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/phone.png') }} 1x, {{ url('images/landings/img/@2x/phone.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-up">
                <p>{!! __('landing.web_portal_mobile_app_text') !!}</p>
                <a href="#">
                    <img class="lazy img-responsive"
                         src="{{ url('images/landings/img/@1x/btn-g-play.png') }}"
                         data-src="{{ url('images/landings/img/@1x/btn-g-play.png') }}"
                         data-srcset="{{ url('images/landings/img/@1x/btn-g-play.png') }} 1x, {{ url('images/landings/img/@2x/btn-g-play.png') }} 2x"
                         alt="Hero"
                         data-aos="fade-in">
                </a>
            </div>
            <div class="col-lg-7 be_static">
                <img class="lazy img-responsive mockup d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/web-portal.png') }}"
                     data-src="{{ url('images/landings/img/@1x/web-portal.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/web-portal.png') }} 1x, {{ url('images/landings/img/@2x/web-portal.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-left">

                <img class="lazy img-responsive phone d-none d-md-block"
                     src="{{ url('images/landings/img/@1x/phone.png') }}"
                     data-src="{{ url('images/landings/img/@1x/phone.png') }}"
                     data-srcset="{{ url('images/landings/img/@1x/phone.png') }} 1x, {{ url('images/landings/img/@2x/phone.png') }} 2x"
                     alt="Hero"
                     data-aos="fade-up">
            </div>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="item">
                    <svg>
                        <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#comment"></use>
                    </svg>
                    <div class="head">
                        <img class="lazy img-responsive"
                             src="{{ url('images/landings/img/@1x/ava.jpg') }}"
                             data-src="{{ url('images/landings/img/@1x/ava.jpg') }}"
                             data-srcset="{{ url('images/landings/img/@1x/ava.jpg') }} 1x, {{ url('images/landings/img/@2x/ava.jpg') }} 2x"
                             alt="Hero"
                             data-aos="fade-left">
                        <h4>Alex Shevchenko</h4>
                    </div>
                    <p>“Thank you for the convenient tool in accelerating daily work. We now have the opportunity to track transport not only using GPS. And not only transport, but also the work of drivers. </p>

                    <p>Logisticians have the opportunity to remotely manage orders and their execution many times faster. Track status and be confident in its efficiency.
                        Thanks for the service! "</p>
                    <div class="foot">
                        <img class="lazy img-responsive"
                             src="{{ url('images/landings/img/@1x/logo-company.png') }}"
                             data-src="{{ url('images/landings/img/@1x/logo-company.png') }}"
                             data-srcset="{{ url('images/landings/img/@1x/logo-company.png') }} 1x, {{ url('images/landings/img/@2x/logo-company.png') }} 2x"
                             alt="Hero">
                        Oiltunes Company
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <h2>{!! __('landing.form_fill') !!}</h2>
                <p class="d">{!! __('landing.form_dscr') !!}</p>
                <div class="address d-none d-md-block">
                    <p>Tsentralnaya St., 8 Kiev, Ukraine</p>
                    <p>
                        <a href="tel:+380685282581">+38 068 528 25 81</a>
                    </p>
                    <a href="mailto:info@inn-logist.com">info@inn-logist.com</a>
                </div>
            </div>
            <div class="col-lg-7">
                <form id="fForm" action="{{ route('feedback.landing') }}" method="POST">
                    <div class="form_row">
                        <div class="field_wrap js--form-field has-float-label">
                            <input id="name" name="name" type="text" placeholder=" ">
                            <label for="name">{!! __('landing.form_input_name') !!}</label>
                            <span class="js--error_message"></span>
                        </div>

                        <div class="field_wrap js--form-field has-float-label">
                            <input id="topic" name="topic" type="text" placeholder=" ">
                            <label for="topic">{!! __('landing.form_input_topic') !!}</label>
                            <span class="js--error_message"></span>
                        </div>
                    </div>
                    <div class="field_wrap js--form-field has-float-label">
                        <input id="email" name="email" type="email" placeholder=" ">
                        <label for="email">{!! __('landing.form_input_email') !!}</label>
                        <span class="js--error_message"></span>
                    </div>
                    <div class="field_wrap js--form-field has-float-label">
                        <textarea id="message" name="message" placeholder=" "></textarea>
                        <label for="message">{!! __('landing.form_text1') !!}</label>
                        <span class="js--error_message"></span>
                    </div>
                    <input type="submit" class="btn-default" value="{!! __('landing.form_submit_btn') !!}">
                </form>
            </div>
        </div>
        <div class="row sub_footer">
            <div class="col-lg-4">
                <div class="logo d-md-none">
                    <a href="/">
                        <svg>
                            <use xlink:href="{{ url('images/landings/svg-sprite/sprite/sprite.svg') }}#inn_logo"></use>
                        </svg>
                    </a>
                </div>
                <div class="address d-md-none">
                    <p>Tsentralnaya St., 8 Kiev, Ukraine</p>
                    <p>
                        <a href="tel:+380685282581">+38 068 528 25 81</a>
                    </p>
                    <a href="mailto:info@inn-logist.com">info@inn-logist.com</a>
                </div>
                <p class="d-none d-md-block">2018-2020. Innlogist. All rights reserved</p>
            </div>
            <div class="col-lg-4 col-6">
                <div class="links">
                    <a href="{{ route('page.terms') }}">{!! __('landing.footer_terms_condition') !!}</a>
                    <a href="{{ route('page.privacy') }}">{!! __('landing.footer_privacy_policy') !!}</a>
                </div>
            </div>
            <div class="col-lg-4 right col-6">
                <p>Design by E.33</p>
            </div>
            <div class="col-12 d-md-none">
                <p class="copy">2020. Innlogist. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>

<script>
    var form_feedback_text = '{{ __('all.message_sent') }}';

</script>

<script src="{{ url('images/landings/js/scripts.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollToFixed/1.0.8/jquery-scrolltofixed-min.js"></script>

<script>
    $(document).ready(function () {
        $('.chevron-up').on('click',function (e){

            if ($(this).parent().parent().find('#dopInformBlock').is(":hidden")) {
                $(this).parent().parent().find('#dopInformBlock').show();
                $(this).css('transform', 'rotate(180deg)');
                $(this).css('transition', '.2s');
            } else {
                $(this).parent().parent().find('#dopInformBlock').hide();
                $(this).css('transform', 'none');
                $(this).css('transition', '.2s');
            }
            return false;
        });
    });


    let map,
        marker = [];

    /**
     * Init map on page load
     */
    function initMap() {

        let myLatlng = new google.maps.LatLng( 50.415, 30.544);
        let mapOptions = {
            zoom: 4,
            center: myLatlng
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        marker = new google.maps.Marker({
            position: myLatlng,
            title:"Hi!"
        });
        marker.setMap(map);

    }

</script>

<script async
        src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&libraries=places&callback=initMap"
        defer></script>
</body>
</html>
