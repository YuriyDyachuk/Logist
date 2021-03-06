<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'inn.logist') }} @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/jquery-eu-cookie-law-popup/css/jquery-eu-cookie-law-popup.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/swiper/dist/css/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('main_layout/css/landing/style.css') }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/manifest.json">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

</head>

<body>
<section id="first-display">
    <nav class="navbar navbar-default transition">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand transition" href="javascript://"></a>
            </div>

            <ul class="nav navbar-nav">
                <li class="transition btn-beta">
                    <a href="{{ url('/login') }}" class="button-green transition link ">
                        {{ trans('landing.entrance') }}
                    </a>
                </li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>
</section>

<section class="container-fluid header-block">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header-block__text-wrapper">

            <h1>{{trans('landing.header_text')}}</h1>

            <form class="header-block__text-fieldset" action="{{ url('/request-test') }}" method="POST">
                {{ csrf_field() }}

                <select name="of" class="selectpicker"
                        data-live-search="true"
                        style="display: none;"
                        title="????????????">
                    <option value="1">??????????</option>
                    <option value="2">????????</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                </select>

                <select name="to" class="selectpicker"
                        data-live-search="true"
                        style="display: none;"
                        title="????????">
                    <option value="1">????????</option>
                    <option value="2">????????????</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                </select>

                <div class="error from transition">?????????????????????? ?????????????? ?????????? ????????????????/????????????????</div>

                <button type="submit" class="button-green transition">
                    ????????????
                </button>
            </form>

        </div>
    </div>
</section>

<section id="second-display" class="container-fluid inn-logist">
    <div class="row">

        <div class="col-sm-11 col-sm-offset-1 col-xs-12">
            <p>
                <span class="text-green">INN.</span><span class="text-blue">LOGIST</span>
                - ?????????????????????????????????????? ?????????????????????????? SaaS ??????????????????, ?? ?????????????? ???????????????????????? ?????????????????? Machine Learning ?????? ?????????????????????????? ?????????????????? ???????????????????????????? ?? ?????????? ?????????? ????????: ???????????????????? ???????????????????????? ????????????????, ???????????? ???????????????????? ?? ????????????????????????, ???????????????????????????? ?????????????????????? ?????????????????????????? ??????????
            </p>
        </div>

        <div class="col-sm-11 col-sm-offset-1 col-xs-12">
            <form class="contact-form__text-fieldset" action="{{ url('/request-test') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="from" placeholder="???????? ?????????? ?????? ??????????????...">
                <button type="submit" class="button-green transition">
                    <span>{{ trans('landing.button_testing') }}</span>
                </button>
                <div class="error from transition">{{ trans('landing.error_email') }}</div>
            </form>
        </div>
    </div>
</section>

<section class="container-fluid benefits-block">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-6 col-xs-12">
            <h2 class="h2">{{ trans('landing.excellence') }}</h2>
        </div>
    </div>
</section>

<section id="third-display" class="container-fluid">
    <div class="row flex-block">
        <div class="col-sm-7 col-xs-12 advantages-background">
        </div>

        <div class="col-sm-5 col-xs-12 advantages-icon flex-block">
            <div class="table-block advantage-icon-cloud">
                <i class="tick-sign"></i>
                <span>{{ trans('landing.excellence_box_cloud') }}</span>
            </div>

            <div class="table-block advantage-icon-edit">
                <i class="tick-sign"></i>
                <span>???????????? ?????????????????????????????? ?? ??????????????????</span>
            </div>

            <div class="table-block advantage-icon-screens">
                <i class="tick-sign"></i>
                <span>???????????? ???????????????????? ?????????? ?? ???????????????? 24/7</span>
            </div>

            <div class="table-block advantage-icon-approve-invoice">
                <i class="tick-sign"></i>
                <span>?????????????????????? ????????????????????</span>
            </div>

            <div class="table-block advantage-icon-security">
                <i class="tick-sign"></i>
                <span>?????????????????????????? ???????? ?? ?????????? "????????"</span>
            </div>

            <div class="table-block advantage-icon-users">
                <i class="tick-sign"></i>
                <span>???????????? ?????????????? ???????? ???????????????????? ???????????????????????????? ??????????</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>
                <span class="text-green">???????? ????????????</span>
                <span>- ?????? ??????????????, ?????????????? ?????????????????? ???????????? ?????? ?????????????? ?????????????????? ?? ???????? ????????!</span>
            </p>
        </div>
    </div>
</section>

<section id="fourth-display" class="container-fluid progress-box">
    <div class="row clearfix">
        <div class="col-3">
            <div class="table-box">
                <div>1.</div>
                <p>
                    ???????????????? ????????????
                </p>
            </div>
        </div>

        <div class="col-3">
            <div class="table-box">
                <div>2.</div>
                <p>
                    ???????????????????? ???????????????????????? ????????????
                </p>
            </div>
        </div>

        <div class="col-3">
            <div class="table-box">
                <div>3.</div>
                <p>
                    ?????????????????????? ??????????????????
                </p>
            </div>
        </div>

        <div class="col-3">
            <div class="table-box">
                <div>4.</div>
                <p>
                    ???????????????? ????????????????????
                </p>
            </div>
        </div>
    </div>
</section>

<section id="fifth-display" class="container-fluid application-bg">
    <div class="row flex-block">
        <div class="col-sm-7 col-xs-12">
            <div class="image-wrapper">
                <img src="{{ url('main_layout/images/landing/mockup_innlogist.png') }}">
            </div>
        </div>

        <div class="col-sm-4 col-sm-offset-1 col-xs-12">
            <h3 class="h3">{!! trans('landing.web_and_app') !!}</h3>
            <p>{{ trans('landing.all_time_and_location') }}</p>
            <a href="javascript://"
               class="button-blue transition btn-coming-soon">{{ trans('landing.dowmload_app') }}</a>
        </div>
    </div>
</section>

<section id="sixth-display" class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h2 class="h2">
                <span class="text-green">????????????</span>
                <span>?????????? ????????????????</span>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <!-- Review slider -->
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="swiper-avatar">
                            <img src="{{ url('main_layout/images/landing/avatar-1.jpg') }}">
                        </div>
                        <div class="swiper-info">
                            <div class="h3 text-blue">
                                ?????????? ????????????
                            </div>
                            <div class="swiper-company">
                                ???????????????????????????? ???????????????? ???? ?????? ??????????????????
                            </div>
                        </div>
                        <div class="swiper-review">
                            <p>
                                C ???????????????????????? ?????????????????? ?????? ??Inn Logist?? ???? ???????????????? ?????? ?????????????????? ??????.
                                ???? ?????????? ???????????? ???????????????????????????? ?????? ?????? ???? ???????? ???? ??????????????. ?????????? ?????????????? ???????????? ?????????? ????????????????????.
                                ???????????????? ?????????????????????? ?? ???????? ????????????????????.
                                <br>
                                ???? ?????? ?????????????????? ?????????????????????? ?????? ??Inn Logist?? ?????? ?????????????????? ???????????????? ?? ?????????? ??????????????????????-?????????????????????????? ??????????.
                            </p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="swiper-avatar">
                            <img src="{{ url('main_layout/images/landing/avatar-2.jpg') }}">
                        </div>
                        <div class="swiper-info">
                            <div class="h3 text-blue">
                                Ipsum Dolor
                            </div>
                            <div class="swiper-company">
                                Dit amet consectetur
                            </div>
                        </div>
                        <div class="swiper-review">
                            <p>
                            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque laborum voluptatibus,
                            voluptatem autem, enim suscipit, necessitatibus similique minus incidunt modi harum
                            dignissimos odit cum, reiciendis iure nisi totam temporibus. Accusantium explicabo
                            soluta eum distinctio, suscipit molestias neque et saepe rem numquam, quas eius dolores
                            porro voluptatem, enim odio pariatur ullam amet, minima omnis in recusandae unde illum
                            repellendus."
                            </p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="swiper-avatar">
                            <img src="{{ url('main_layout/images/landing/avatar-3.jpg') }}">
                        </div>
                        <div class="swiper-info">
                            <div class="h3 text-blue">
                                Eliot Adipisicing
                            </div>
                            <div class="swiper-company">
                                Neque
                            </div>
                        </div>
                        <div class="swiper-review">
                            <p>
                            "Dicta, facilis, laudantium! Reiciendis nihil laboriosam in veritatis explicabo sunt
                            maiores mollitia voluptates asperiores culpa similique excepturi repellat vel ipsa sint
                            ipsam cumque corrupti quaerat itaque voluptatibus iure, provident autem. Vero asperiores
                            harum facilis architecto maxime unde eos vitae soluta qui. Officia."
                            </p>
                        </div>
                    </div>

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

<section id="seventh-display" class="container-fluid">
    <div class="row">

        <div id="feedback" class="col-sm-6 col-xs-12">
            <h5 class="h5">
                ?????????? ???????????????? ??????????
            </h5>

            <div class="form-feedback transition">
                <fieldset class="clearfix">
                    <div>
                        <input class="transition" type="text" name="name" value="" required placeholder="">
                        <label class="transition">??????</label>
                        <div class="modal-error transition">???????? ??????????????????????</div>
                    </div>

                    <div>
                        <input class="transition" type="text" name="subject" value="" required>
                        <label class="transition">????????</label>
                        <div class="modal-error transition">???????? ??????????????????????</div>
                    </div>
                </fieldset>

                <fieldset>
                    <div>
                        <input class="transition" type="text" name="email" value="" required>
                        <label class="transition">Email</label>
                        <div class="modal-error transition">???????????????? ????????????</div>
                    </div>
                </fieldset>

                <fieldset class="text-message">
                    <div>
                        <textarea class="transition" name="message" required></textarea>
                        <label>??????????????????</label>
                        <div class="modal-error message transition">???????? ??????????????????????</div>
                    </div>
                </fieldset>

                <button id="modal-send" type="button" class="button-green transition btn btn-primary">??????????????????
                </button>
            </div>

            <div class="correct-send hidden transition">
                ?????????????????? ?????????????? ??????????????????????
            </div>
        </div>

        <div class="col-sm-5 col-sm-offset-1 col-xs-12">
            <h5 class="h5">
                <span>????????????????</span>
            </h5>
            <p>
                ???? ???????????????????????????? ???????????? ???????????? ?????????? ?? ?????????????? ?????? ?????????????? ??????????????.
                ???????? ?? ?????? ???????? ?????????????????????? ?????? ?????????????????? - ???????????????? ??????!
            </p>
            <div class="contact-info">
                <div class="contact-info__address">
                    <p>????.??????????????????????,8 ??. ????????, ??????????????</p>
                </div>
                <div class="contact-info__phone">
                    <a href="tel:+380685282581">+38 068 528 25 81</a>
                </div>
                <div class="contact-info__mail">
                    <a href="mailto:info@inn-logist.com">info@inn-logist.com</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="container-fluid">
    <div class="row">
        <div class="col-sm-4 col-xs-8">
            &copy; 2018. Innlogist. All rights reserved.
        </div>
        <div class="col-sm-4 col-sm-offset-4 col-xs-4">
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

@include('layouts.includes.cookie-warning');

<?php /*
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'mOhGeIUfDG';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
*/ ?>

<!-- Scripts -->
<script type="text/javascript" src="{{ url('bower-components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/jquery.viewportchecker/dist/jquery.viewportchecker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/swiper/dist/js/swiper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/main_layout/js/landing.js') }}"></script>
</body>
</html>
