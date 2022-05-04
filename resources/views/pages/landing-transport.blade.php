<?php
/**
 * Content landing page template
 */
?>@extends('layouts.landing')
@section('content')
    <section id="first-display">
        <nav class="navbar navbar-default transition">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand transition" href="javascript://"></a>
                </div>

                <ul class="nav navbar-nav">
                    <li class="btn-menu">
                        <a href="" class="transition">грузовладельцам</a>
                    </li>
                    <li class="btn-menu">
                        <a href="" class="transition">перевозчикам</a>
                    </li>
                    <li class="btn-beta">
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

                <div class="header-block__note">бесплатный поиск транспорта и грузов без лишних действий с отслеживанием местонахождения</div>

                <form class="header-block__text-fieldset" action="{{ url('/request-test') }}" method="POST">
                    {{ csrf_field() }}

                    <select name="of" class="selectpicker"
                            data-live-search="true"
                            style="display: none;"
                            title="Откуда">
                        <option value="1">Днепр</option>
                        <option value="2">Киев</option>
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
                            title="Куда">
                        <option value="1">Киев</option>
                        <option value="2">Берлин</option>
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

                    <button type="submit" class="button-green transition">
                        Вперед
                    </button>

                    <div class="error from transition">Некорректно указано место отправки/прибытия</div>
                </form>

            </div>
        </div>
    </section>

    <section id="second-display" class="container-fluid inn-logist">
        <div class="row">

            <div class="col-sm-11 col-sm-offset-1 col-xs-12">
                <p>
                    <span class="text-green">INN.</span><span class="text-blue">LOGIST</span>
                    - многофункциональная логистическая SaaS платформа, в которой используются алгоритмы Machine Learning для автоматизации процессов грузоперевозок с любой точки мира: построение оптимального маршрута, подбор транспорта и исполнителей, предоставление необходимых сопутствующих услуг
                </p>
            </div>

            <div class="col-sm-11 col-sm-offset-1 col-xs-12">
                <form class="contact-form__text-fieldset" action="{{ url('/request-test') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="from" placeholder="Ваша почта или телефон...">
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
                    <span>онлайн документооборот и аналитика</span>
                </div>

                <div class="table-block advantage-icon-screens">
                    <i class="tick-sign"></i>
                    <span>онлайн мониторинг груза и процесса 24/7</span>
                </div>

                <div class="table-block advantage-icon-approve-invoice">
                    <i class="tick-sign"></i>
                    <span>верификация транспорта</span>
                </div>

                <div class="table-block advantage-icon-security">
                    <i class="tick-sign"></i>
                    <span>рекомендуемая цена и режим "сейф"</span>
                </div>

                <div class="table-block advantage-icon-users">
                    <i class="tick-sign"></i>
                    <span>единая система всех участников логистического рынка</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>
                    <span class="text-green">НАША ЗАДАЧА</span>
                    <span>- это система, которая позволяет решить все вопросы логистики в один клик!</span>
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
                        Создание заказа
                    </p>
                </div>
            </div>

            <div class="col-3">
                <div class="table-box">
                    <div>2.</div>
                    <p>
                        Автоподбор оптимального заказа
                    </p>
                </div>
            </div>

            <div class="col-3">
                <div class="table-box">
                    <div>3.</div>
                    <p>
                        Утверждение участника
                    </p>
                </div>
            </div>

            <div class="col-3">
                <div class="table-box">
                    <div>4.</div>
                    <p>
                        Контроль выполнения
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
                    <span class="text-green">Отзывы</span>
                    <span>наших клиентов</span>
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
                                    Артем Кавдин
                                </div>
                                <div class="swiper-company">
                                    Исполнительный директор АО НПО «Новодез»
                                </div>
                            </div>
                            <div class="swiper-review">
                                <p>
                                    C транспортной компанией ООО «Inn Logist» мы работаем уже несколько лет.
                                    За время нашего сотрудничества они нас ни разу не подвели. Любые вопросы решают очень оперативно.
                                    Работают качественно и цены приемлемые.
                                    <br>
                                    АО НПО «Новодез» рекомендует ООО «Inn Logist» как надежного партнера в сфере транспортно-логистических услуг.
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
                    Форма обратной связи
                </h5>

                <div class="form-feedback transition">
                    <fieldset class="clearfix">
                        <div>
                            <input class="transition" type="text" name="name" value="" required placeholder="">
                            <label class="transition">Имя</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>

                        <div>
                            <input class="transition" type="text" name="subject" value="" required>
                            <label class="transition">Тема</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <input class="transition" type="text" name="email" value="" required>
                            <label class="transition">Email</label>
                            <div class="modal-error transition">Неверные данные</div>
                        </div>
                    </fieldset>

                    <fieldset class="text-message">
                        <div>
                            <textarea class="transition" name="message" required></textarea>
                            <label>Сообщение</label>
                            <div class="modal-error message transition">Поле обязательно</div>
                        </div>
                    </fieldset>

                    <button id="modal-send" type="button" class="button-green transition btn btn-primary">Отправить
                    </button>
                </div>

                <div class="correct-send hidden transition">
                    Сообщение успешно отправленно
                </div>
            </div>

            <div class="col-sm-5 col-sm-offset-1 col-xs-12">
                <h5 class="h5">
                    <span>Контакты</span>
                </h5>
                <p>
                    Мы заинтересованы делать сервис лучше и удобнее для каждого клиента.
                    Если у вас есть предложения или пожелания - напишите нам!
                </p>
                <div class="contact-info">
                    <div class="contact-info__address">
                        <p>ул.Центральная,8 г. Киев, Украина</p>
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

@endsection
