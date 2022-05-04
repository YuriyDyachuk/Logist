@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.transport-new-added-title'))
@section('tutorial')
    <div class="overlay_tutorial__text overlay_tutorial__text_1">{!! trans('tutorials.transport-new-added-1') !!}</div>
    <div class="overlay_tutorial__text overlay_tutorial__text_2">{!! trans('tutorials.transport-new-added-2') !!}</div>
    <div class="overlay_tutorial__text overlay_tutorial__text_3">{!! trans('tutorials.transport-new-added-3') !!}</div>
@endsection
@endpush


@push('styles')
    <style>

        .overlay_tutorial__arrow {
            top: 288.15px;
            left: 791.5px;
            display: none;
            -moz-transform: scale(1, -1);
            -webkit-transform: scale(1, -1);
            -o-transform: scale(1, -1);
            -ms-transform: scale(1, -1);
            transform: scale(1, -1);
        }

        .panel-group:nth-child(1) .panel-transport {
            z-index: 10002;
        }

        #t {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            z-index: 10005;
        }

        .overlay_tutorial__text_2 {
            display: none;
        }

        .overlay_tutorial__text_3 {
            display: none;
        }

        .overlay_tutorial__link_back {
            visibility: hidden;
        }

    </style>
@endpush

@include('tutorials.includes.common')

@push('scripts')
    <script>

        $(window).on('load', function() {

            $('.overlay_tutorial__step_amount').text('3');

            step1();

        });

        function reset_css(){

            if ($('body').data('tutorial') === 3){
                hide_tutorial();
            }

            let el = $('.panel-group:nth-child(1)').find('.panel-transport');
//            el.append('<div id="t"></div>');
            el.css('z-index', 'inherit');

        }


        function linkBack(){

            if ($('body').data('tutorial') === 3){
                step2();
            }
            else if ($('body').data('tutorial') === 2){
                step1();
                $('.overlay_tutorial__link_back').css('visibility', 'hidden');
            }
        }

        function linkNext(){

            if ($('body').data('tutorial') === 1){
                step2();
            }
            else if ($('body').data('tutorial') === 2){
                step3();
            }
            else if ($('body').data('tutorial') === 3){
                hide_tutorial();
                return;
            }

            $('.overlay_tutorial__link_back').css('visibility', 'visible');

        }

        function step1() {
            $('.overlay_tutorial__step_current').text('1');

            let el = $('.panel-group:nth-child(1)').find('.panel-transport');
            el.append('<div id="t"></div>');
            el.css('z-index', '10002');
            $('.overlay_tutorial__arrow').hide();

            var elPosition = el.offset();
            var elPositionTop = elPosition.top;
            var elOrderHeight = el.height();

            setTutorialPosition((elPositionTop + elOrderHeight + 30) + 'px');

            $('body').data('tutorial', 1);
        }


        function step2() {

            let el = $('.panel-group:nth-child(1)').find('.panel-transport');
            let el2 = $('.panel-group:nth-child(1) .driver-info .bootstrap-select');

            $('#t').hide();
            $('.overlay_tutorial__text_1').hide();

            el.css('z-index', 'inherit');

            $('.overlay_tutorial__step_current').text('2');
            $('.overlay_tutorial__text_2').show();

            view_tutorial();
            el2.css('z-index', '10002');

            $('.overlay_tutorial__arrow').fadeIn();

            let elPosition = el2.offset();

            let elPositionTop = elPosition.top;
            let elPositionLeft = elPosition.left;

            let elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop - 60 + 'px');
            elArrow.css('left', elPositionLeft - 50 + 'px');

            $('body').data('tutorial', 2);
        }

        function step3() {

//            $('.overlay_tutorial__arrow').fadeOut();

            $('.overlay_tutorial__step_current').text('3');
            $('.overlay_tutorial__text_2').hide();
            $('.overlay_tutorial__text_3').show();

            let el1 = $('.panel-group:nth-child(1) .driver-info .bootstrap-select');
            el1.css('z-index', 'inherit');

            let el2 = $('.panel-group:nth-child(1)').find('.panel-transport');
            let el3 = $('.panel-group:nth-child(1)').find('.asd');
            $('#t').show();
            el2.css('z-index', '10002');

            let elPosition = el3.offset();

            let elPositionTop = elPosition.top;
            let elPositionLeft = elPosition.left;

            let elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop - 65 + 'px');
            elArrow.css('left', elPositionLeft - 80 + 'px');

            $('body').data('tutorial', 3);
        }

    </script>

@endpush