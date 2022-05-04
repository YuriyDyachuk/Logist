<div class="overlay_tutorial">
    <div class="overlay_tutorial__arrow"></div>
</div>
<div class="overlay_tutorial__box">
    <div class="overlay_tutorial__title">
        @yield('titleTutorial')
    </div>
    <a href="#" class="overlay_tutorial__link_close transition"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    <div class="overlay_tutorial__content">
        @yield('tutorial')
        <div class="overlay_tutorial__links">
            <div class="overlay_tutorial__steps">
                <span class="overlay_tutorial__step_current"></span>
                <span class="overlay_tutorial__step_text">{{ trans('tutorials.of') }}</span>
                <span class="overlay_tutorial__step_amount"></span>
            </div>
            <div class="overlay_tutorial__link">
                <a href="#" class="overlay_tutorial__link_back transition">{{ trans('tutorials.btn_back') }}</a>
            </div>
            <div class="overlay_tutorial__link">
                <a href="#" class="overlay_tutorial__link_next transition">{{ trans('tutorials.btn_next') }}</a>
            </div>
        </div>
    </div>
</div>
