<!DOCTYPE html>
<html lang="ru">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113244328-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-113244328-2');
    </script>

    <meta charset="utf-8">
    <title>Inn Logist</title>
    <meta name="description" content="{{ trans('landing.meta_description') }}">
    <meta name="viewport" content="width=device-width">
    <meta property="og:image" content="images/landings/img/dest/preview.jpg">
    <link rel="stylesheet" href="{{ url('images/landings/css/styles.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/font-awesome/css/font-awesome.min.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/main_layout/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-16x16.png') }}" sizes="16x16">

    <link rel="manifest" href="images/landings/site.webmanifest">
    <link rel="mask-icon" href="images/landings/safari-pinned-tab.svg" color="#dc005e">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>


    <style>
        .shake {
            -webkit-animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
            animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        @keyframes shake {
            10%, 90% {
                -webkit-transform: translate3d(-1px, 0, 0);
                transform: translate3d(-1px, 0, 0);
            }
            20%, 80% {
                -webkit-transform: translate3d(2px, 0, 0);
                transform: translate3d(2px, 0, 0);
            }
            30%, 50%, 70% {
                -webkit-transform: translate3d(-4px, 0, 0);
                transform: translate3d(-4px, 0, 0);
            }
            40%, 60% {
                -webkit-transform: translate3d(4px, 0, 0);
                transform: translate3d(4px, 0, 0);
            }
        }
    </style>
</head>

<body class="landing2">

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
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#mnu_cargo"></use>
                            </svg>
                            <h1 class="d-xl-none">{{ __('landing.trucking_on-line') }}</h1>
                        </div>
                        <ul id="main-menu" class="nav sm">
                            <li class="d-none d-xl-block">
                                <a href="{{  config('app.locale') == 'ru' ? url('carrier/') : url('carrier/'.config('app.locale')) }}">{{ __('landing.for_carrier') }}</a>
                            </li>
                        </ul>
                        <!-- <a href="#" class="btn-default d-xl-none">Try it</a> -->
                        <a href="{{  config('app.locale') == 'ru' ? url('carrier/') : url('carrier/'.config('app.locale')) }}"
                           class="carrier">{{ __('landing.for_carrier') }}
                            <svg class="carrier__ico">
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#open-in-new"></use>
                            </svg>
                        </a>
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>

                    </div>
                    <a href="{{url('/login')}}" class="login">{{ __('landing.login') }}</a>
                    <!-- <ul id="lang" class="lang sm">
                        <li><a href="#">RU</a>
                            <ul>
                                <li><a href="en.html">EN</a></li>
                                <li><a href="de.html">DE</a></li>
                                <li><a href="it.html">IT</a></li>
                                <li><a href="es.html">ES</a></li>
                                <li><a href="fr.html">FR</a></li>
                                <li><a href="ar.html">AR</a></li>
                            </ul>
                        </li>
                    </ul> -->

                    <a href="{{url('/register')}}" class="btn-default">{{ __('landing.register') }}</a>
                    <ul id="lang" class="lang sm">
                        <li>
                            <svg>
                                <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#lang"></use>
                            </svg>
                        </li>
                        <li>
                            @if(config('app.locale') == 'en') <a href="/en">EN</a> @elseif(config('app.locale') == 'ru')
                                <a href="/ru">RU</a> @endif
                            <ul>
                                @if(config('app.locale') == 'en')
                                    <li><a href="/ru">RU</a></li> @else
                                    <li><a href="/en">EN</a></li> @endif
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
            <div class="col-lg-4 col-md-4">
                <h1>{{ __('landing.trucking_on-line') }}</h1>
                <svg class="d-md-none">
                    <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#hero2_mob"></use>
                </svg>
                <div class="mob">
                    <p>{{ __('landing.owner_trucking_on-line_text') }}</p>

                    {{--                    <div class="see">--}}
                    {{--                        <svg>--}}
                    {{--                            <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#play"></use>--}}
                    {{--                        </svg>--}}
                    {{--                        <p><a href="https://www.youtube.com/watch?v=t2UnuTnicE4" style="color: #7a7a7a;">{{ __('landing.see_how_it_works') }}</a></p>--}}
                    {{--                    </div>--}}

                    <form id="fDestination" action="{{route('register.home.post')}}" method="post">

                    @csrf

                    <!-- additional_plus -->
                        <div class="line-map">
                            <div class="point-download"></div>
                            <div class="point-upload"></div>
                        </div>
                        <!-- End additional_plus -->

                        <input type="hidden" name="route_polyline">
                        <input type="hidden" name="direction_waypoints">

                        <div class="form-row col-sm-12">

                        @csrf
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <input type="hidden" name="action" value="validate_captcha">
                        <div style="display: none; margin-bottom: 10px;" id="recaptcha_error">Проверка на бота не пройдена</div>

                        <div class="form-row">

                            <div class="form-group">
                                <input id="from" name="from" class="autocomplete" type="text"
                                       placeholder="{{ __('landing.from_where') }}"/>

                                <input id="from_place_id" name="from_place_id" type="hidden"
                                       value="" />
                                <input type="hidden" class="hidden-prev-address">
                                <input type="hidden" class="hidden-prev-place-id">
                                <input type="hidden" name="" class="address_place_id duplicate-address"
                                       data-marker-update=""
                                       data-address="loading"
                                       value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['from_place_id'] : ''}}"
                                >
                            </div>

                            <div class="form-group">
                                <input id="to" name="to" class="autocomplete" type="text"
                                       placeholder="{{ __('landing.to_where') }}"/>

                                <input id="to_place_id" name="to_place_id" type="hidden"
                                       value="" />
                                <input type="hidden" class="hidden-prev-address">
                                <input type="hidden" class="hidden-prev-place-id">
                                <input type="hidden" name=""  class="address_place_id duplicate-address"
                                       data-marker-update=""
                                       data-address="unloading"
                                       value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['to_place_id'] : ''}}"
                                >
                            </div>
                            {{--                            <div class="form-group">--}}
                            {{--                                <input type="submit" class="btn-default g-recaptcha" value="{{ __('landing.start') }}">--}}
                            {{--                            </div>--}}

                            <div class="form-group icon-plus">
                                <span class="plus"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('landing.add_item')}}</span>
                            </div>

                            <div class="form-group">
                                <input type="text" id="tonnage" name="tonnage"
                                       placeholder="{{ __('landing.tonnage') }}"/>
                            </div>

                            <div class="form-group calculator-form">
                                <a href="#" id="startOrder"><span>{{__('landing.calculates')}}</span></a>
                            </div>

                        </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row title-inform">
                    <div class="col-sm-3">{{__('landing.distance')}}: <span id="distance">0 {{__('all.km')}}</span>
                    </div>
                    <div class="col-sm-4">{{__('landing.time_of_delivery')}}: <span
                                id="time">0 {{__('all.time')}}</span></div>
                    <div class="col-sm-5">{{__('all.recommended_price')}}: <span>0 {{__('all.UAH')}}</span></div>
                </div>
                <div class="map-container">
                    <div id="map"></div>
                </div>
                {{--                <img class="lazy img-responsive d-none d-md-block"--}}
                {{--                     src="images/landings/img/@1x/hero2.png"--}}
                {{--                     data-src="images/landings/img/@1x/hero2.png"--}}
                {{--                     data-srcset="images/landings/img/@1x/hero2.png 1x, images/landings/img/@2x/hero2.png 2x"--}}
                {{--                     alt="Hero"--}}
                {{--                     data-aos="fade-left">--}}
            </div>

            <div class="container button-push">
                <div class="row">
                    <div class="col-lg-12 button-order">
                        <a href="{{ url('/profile/register', ['account' => 'client']) }}"
                           class="btn button-style1">{{__('landing.place_of_order')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="second">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h3>Inn.logist system</h3>
                <img class="lazy img-responsive d-md-none"
                     src="images/landings/img/@1x/land2_img.png"
                     data-src="images/landings/img/@1x/land2_img.png"
                     data-srcset="images/landings/img/@1x/land2_img.png 1x, images/landings/img/@2x/land2_img.png 2x"
                     alt="Hero"
                     data-aos="fade-left">
                <p>{{ __('landing.owner_automation_processes') }}</p>
                <div class="see">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#play"></use>
                    </svg>
                    <p><a href="https://www.youtube.com/watch?v=t2UnuTnicE4"
                          style="color: #7a7a7a;">{{ __('landing.see_how_it_works') }}</a></p>
                </div>
                <a href="#" class="btn-default">{{ __('landing.try_it') }}</a>
            </div>
            <div class="col-lg-7">
                <img class="lazy img-responsive d-none d-md-block"
                     src="images/landings/img/@1x/land2_img.png"
                     data-src="images/landings/img/@1x/land2_img.png"
                     data-srcset="images/landings/img/@1x/land2_img.png 1x, images/landings/img/@2x/land2_img.png 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>

        </div>
    </div>
</section>

<section id="features">
    <div class="bg2"></div>
    <!-- <img class="lazy img-responsive bg2"
                src="images/landings/img/@1x/bg-2.png"
                data-src="images/landings/img/@1x/bg-2.png"
                data-srcset="images/landings/img/@1x/bg-2.png 1x, images/landings/img/@2x/bg-2.png 2x"
                alt="Hero"
                data-aos="fade-left"> -->
    <div class="bg3"></div>
    <div class="container">

        <div class="row">
            <div class="col-lg-4">
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#l2_ic1"></use>
                    </svg>
                    <h4>{{ __('landing.owner_technological') }}</h4>
                    <p style="padding-right: 10px;">{{ __('landing.owner_technological_text') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#l2_ic2"></use>
                    </svg>
                    <h4>{{ __('landing.owner_safely') }}</h4>
                    <p>{{ __('landing.owner_safely_text') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#l2_ic3"></use>
                    </svg>
                    <h4>{{ __('landing.owner_free_to_use') }}</h4>
                    <p style="padding-right: 40px;">{{ __('landing.owner_free_to_use_text') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="benefits">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h2>{{ __('landing.owner_benefits') }}</h2>
                <p style="padding-right: 40px;">{{ __('landing.owner_benefits_text') }}</p>
            </div>

            <div class="col-lg-3 offset-sm-1">
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-4"></use>
                    </svg>
                    {{ __('landing.owner_benefits_monitoring_24_7') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-8"></use>
                    </svg>
                    {{ __('landing.owner_benefits_direct_carrier') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-1"></use>
                    </svg>
                    {{ __('landing.owner_benefits_fast_start') }}
                </div>
                <div class="item" style="margin-top: -9px;">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-7"></use>
                    </svg>
                    {{ __('landing.owner_benefits_logistics_market') }}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-6"></use>
                    </svg>
                    {{ __('landing.owner_benefits_quality_level') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-3"></use>
                    </svg>
                    {{ __('landing.owner_benefits_viewable_process') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-5"></use>
                    </svg>
                    {{ __('landing.owner_benefits_saas') }}
                </div>
                <div class="item">
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-2"></use>
                    </svg>
                    {{ __('landing.owner_benefits_electronic_document') }}
                </div>
            </div>
        </div>
    </div>
</section>


<section class="start">
    <div class="container">
        <div class="row step1">
            <div class="col-12"><h2 class="txt_center">{{ __('landing.carrier_how_work') }}</h2></div>
            <div class="col-lg-7">
                <div class="item">
                    <span class="step">{{ __('landing.owner_step_1') }}</span>
                    <h3>{{ __('landing.owner_step_1_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="images/landings/img/@1x/start_1.png"
                         data-src="images/landings/img/@1x/start_1.png"
                         data-srcset="images/landings/img/@1x/start_1.png 1x, images/landings/img/@2x/start_1.png 2x"
                         alt="Hero"
                         data-aos="fade-left">
                    <p>{{ __('landing.owner_step_1_text_2') }}</p>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="lazy img-responsive d-none d-md-block"
                     src="images/landings/img/@1x/start_1.png"
                     data-src="images/landings/img/@1x/start_1.png"
                     data-srcset="images/landings/img/@1x/start_1.png 1x, images/landings/img/@2x/start_1.png 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>
        </div>

        <div class="row align-items-center step2">
            <div class="col-lg-7">
                <img class="lazy img-responsive d-none d-md-block"
                     src="images/landings/img/@1x/start_2.png"
                     data-src="images/landings/img/@1x/start_2.png"
                     data-srcset="images/landings/img/@1x/start_2.png 1x, images/landings/img/@2x/start_2.png 2x"
                     alt="Hero"
                     data-aos="fade-right">
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="item step-2">
                    <span class="step">{{ __('landing.owner_step_2') }}</span>
                    <h3>{{ __('landing.owner_step_2_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="images/landings/img/@1x/start_2.png"
                         data-src="images/landings/img/@1x/start_2.png"
                         data-srcset="images/landings/img/@1x/start_2.png 1x, images/landings/img/@2x/start_2.png 2x"
                         alt="Hero"
                         data-aos="fade-right">
                    <p>{{ __('landing.owner_step_2_text_2') }}</p>
                </div>
            </div>
        </div>

        <div class="row step3">
            <div class="col-lg-6">
                <div class="item">
                    <span class="step">{{ __('landing.owner_step_3') }}</span>
                    <h3>{{ __('landing.owner_step_3_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="images/landings/img/@1x/st3.png"
                         data-src="images/landings/img/@1x/st3.png"
                         data-srcset="images/landings/img/@1x/st3.png 1x, images/landings/img/@2x/st3.png 2x"
                         alt="Hero"
                         data-aos="fade-left">
                    <p>{{ __('landing.owner_step_3_text_2') }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <img class="lazy img-responsive d-none d-md-block"
                     src="images/landings/img/@1x/st3.png"
                     data-src="images/landings/img/@1x/st3.png"
                     data-srcset="images/landings/img/@1x/st3.png 1x, images/landings/img/@2x/st3.png 2x"
                     alt="Hero"
                     data-aos="fade-left">
            </div>
        </div>

        <div class="row align-items-center step4">
            <div class="col-lg-6">
                <img class="lazy img-responsive d-none d-md-block"
                     src="images/landings/img/@1x/st4.png"
                     data-src="images/landings/img/@1x/st4.png"
                     data-srcset="images/landings/img/@1x/st4.png 1x, images/landings/img/@2x/st4.png 2x"
                     alt="Hero"
                     data-aos="fade-right">
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="item step-2">
                    <span class="step">{{ __('landing.owner_step_4') }}</span>
                    <h3>{{ __('landing.owner_step_4_text_1') }}</h3>
                    <img class="lazy img-responsive d-md-none"
                         src="images/landings/img/@1x/st4.png"
                         data-src="images/landings/img/@1x/st4.png"
                         data-srcset="images/landings/img/@1x/st4.png 1x, images/landings/img/@2x/st4.png 2x"
                         alt="Hero"
                         data-aos="fade-right">
                    <p>{{ __('landing.owner_step_4_text_2') }}</p>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="cargo">
    <form id="fCargo" action="{{route('register.home.post')}}" method="post">
        @csrf
        <input type="hidden" name="pre_order_cargo" value="">
    </form>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h2>{{ __('landing.select_cargo_type') }}</h2>
                <p>{{ __('landing.select_cargo_type_text') }}</p>
            </div>
            <div class="col-lg-4 items">
                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_equipment') }}">
                    {{ __('landing.select_cargo_type_equipment') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo-1"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_pharmaceuticals') }}">
                    {{ __('landing.select_cargo_type_pharmaceuticals') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo-2"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_furniture') }}">
                    {{ __('landing.select_cargo_type_furniture') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo-3"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_other') }}">
                    {{ __('landing.select_cargo_type_other') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo-4"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>
            </div>

            <div class="col-lg-4 items">
                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_food') }}">
                    {{ __('landing.select_cargo_type_food') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-9"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_electronics') }}">
                    {{ __('landing.select_cargo_type_electronics') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-10"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_live_cargo') }}">
                    {{ __('landing.select_cargo_type_live_cargo') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-11"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>

                <a href="#" class="item" data-name="{{ __('landing.select_cargo_type_building_materials') }}">
                    {{ __('landing.select_cargo_type_building_materials') }}
                    <svg>
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#b-12"></use>
                    </svg>
                    <svg class="hover">
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#cargo_arrow"></use>
                    </svg>
                </a>
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
                        <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#comment"></use>
                    </svg>
                    <div class="head">
                        <img class="lazy img-responsive"
                             src="images/landings/img/@1x/ava.jpg"
                             data-src="images/landings/img/@1x/ava.jpg"
                             data-srcset="images/landings/img/@1x/ava.jpg 1x, images/landings/img/@2x/ava.jpg 2x"
                             alt="Hero">
                        <h4>Alex Shevchenko</h4>
                    </div>
                    <p>“Thank you for the convenient tool in accelerating daily work. We now have the opportunity to
                        track transport not only using GPS. And not only transport, but also the work of drivers. </p>

                    <p>Logisticians have the opportunity to remotely manage orders and their execution many times
                        faster. Track status and be confident in its efficiency.
                        Thanks for the service! "</p>
                    <div class="foot">
                        <img class="lazy img-responsive"
                             src="images/landings/img/@1x/logo-company.png"
                             data-src="images/landings/img/@1x/logo-company.png"
                             data-srcset="images/landings/img/@1x/logo-company.png 1x, images/landings/img/@2x/logo-company.png 2x"
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
                            <use xlink:href="/images/landings/svg-sprite/sprite/sprite.svg#inn_logo"></use>
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
                <p class="d-none d-md-block">2020. Innlogist. All rights reserved</p>
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
                <p class="copy">2018-2020. Innlogist. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>

<script>
    var form_feedback_text = '{{ __('all.message_sent') }}';
    var recaptcha_key = '{{config('captcha.google_recaptcha_key_3')}}';
</script>

<script src="https://www.google.com/recaptcha/api.js?render={{config('captcha.google_recaptcha_key_3')}}"></script>
{{--<script src="https://www.google.com/recaptcha/api.js"></script>--}}
<script src="images/landings/js/scripts.min.js"></script>
<script src="images/landings/js/_googleMap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollToFixed/1.0.8/jquery-scrolltofixed-min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // формируем новые поля
    $(document).ready(function () {
        $('.plus').click(function (e) {
            console.log(e.target);

            jQuery('div .icon-plus').after(
                '<div class="form-group">' +
                '<input type="text" id="addFeatures" class="autocomplete" name="addFeatures" placeholder="{{ __('landing.add_features') }}" autocomplete="off">' +
                '<input type="hidden" id="" name="" autocomplete="off">' +
                '<i class="fa fa-minus minus" aria-hidden="true"></i>' +
                '</div>'
            );

        });
    });

    // удаление строки с полем
    $(document).on('click', '.minus', function () {
        $(this).closest('div').remove();
    });

    function valid_destination_form(form) {
        var from_text = form.find('#from').val();
        var from_place = form.find('#from_place_id').val();
        var to_text = form.find('#to').val();
        var to_place = form.find('#to_place_id').val();
        var result = true;

        if (from_text === '' || from_place === '') {
            form.find('#from').parent('.form-group').addClass('has-error');
            form.find('#from').parent('.form-group').addClass('shake');
            result = false;
        }

        if (to_text === '' || to_place === '') {
            form.find('#to').parent('.form-group').addClass('has-error');
            form.find('#to').parent('.form-group').addClass('shake');
            result = false;
        }

        if (result === false) {
            return false;
        }
    }

    // GOOGLE
    function calculateDistance() {

        const travelMode = google.maps.TravelMode.DRIVING;
        const origin = document.getElementById("from").value;
        const destination = document.getElementById("to").value;

        var distanceService = new google.maps.DistanceMatrixService();
        distanceService.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: travelMode,
                unitSystem: google.maps.UnitSystem.METRIC,
                drivingOptions: {
                    departureTime: new Date(/* now, or future date */),
                    trafficModel: 'pessimistic'
                }
            },
            function (response, status) {
                if (status !== google.maps.DistanceMatrixStatus.OK) {
                    console.log('Error:', status);
                } else {
                    let outputDivKm = document.getElementById('distance');
                    outputDivKm.innerHTML = '';
                    let outputDivTime = document.getElementById('time');
                    outputDivTime.innerHTML = '';
                    let resultKm = response.rows[0].elements[0].distance.text;
                    outputDivKm.innerHTML = resultKm;

                    let resultTime = response.rows[0].elements[0].duration.value / 60 / 60;
                    let time = Math.floor(resultTime);
                    outputDivTime.innerHTML = time + declOfNum(time, [' {{ __('landing.in_hour') }}', ' {{ __('landing.in_hours') }}', ' {{ __('landing.in_hours_of') }}']);
                }
            }
        );
    }
</script>

<script async
        src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&libraries=places&callback=initMap"
        defer></script>

</body>
</html>