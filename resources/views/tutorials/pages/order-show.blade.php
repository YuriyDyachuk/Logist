@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.order-show-title'))
@section('tutorial')
    <div class="overlay_tutorial__text overlay_tutorial__text_1">
        {!! trans('tutorials.order-show-1') !!}
    </div>
    <div class="overlay_tutorial__text overlay_tutorial__text_2">
        {!! trans('tutorials.order-show-2') !!}
    </div>
    <div class="overlay_tutorial__text overlay_tutorial__text_3">
        {!! trans('tutorials.order-show-3') !!}
    </div>
    <div class="overlay_tutorial__text overlay_tutorial__text_4">
        {!! trans('tutorials.order-show-4') !!}
    </div>
    <div class="overlay_tutorial__text overlay_tutorial__text_5">
        {!! trans('tutorials.order-show-5') !!}
    </div>
@endsection
@endpush


@push('styles')
    <style>

        .overlay_tutorial__arrow {
            left: 50%;
            top: 440px;
            -moz-transform: scale(-1, -1);
            -webkit-transform: scale(-1, -1);
            -o-transform: scale(-1, -1);
            -ms-transform: scale(-1, -1);
            transform: scale(-1, -1);
        }

        .overlay_tutorial__text_2 {
            display: none;
        }

        .overlay_tutorial__text_3 {
            display: none;
        }

        .overlay_tutorial__text_4 {
            display: none;
        }

        .overlay_tutorial__text_5 {
            display: none;
        }

        .overlay_tutorial__box {
            height: 300px;
        }

        .overlay_tutorial__links {
            text-align: right;
            position: absolute;
            bottom: 16px;
            width: 368px;
        }

    </style>
@endpush

@include('tutorials.includes.common')

@push('scripts')
    <script>

        $(window).on('load', function() {

            $('.overlay_tutorial__step_amount').text('5');

            let step1 = false;

            let tabTransport = $('a[href="#transport"]');

            tabTransport.tab('show');

            $('#transport').css('z-index', '10002');

//            $('.overlay_tutorial__text_1').show();

            $(tabTransport).on('shown.bs.tab', function (e) {
                step_transport();
                step1 = true;
            });

            if(step1 === false){
                step_transport();
            }

            $('#activate-button').click(function (e) {
                hide_tutorial();
            });

        });

        function reset_css() {
            $('#transport').css('z-index', '2');
            $('#payment').css('z-index', '2');
            $('#documents').css('z-index', '2');
            $('#progress').css('z-index', '2');
        }

        function linkBack(){

            let stepTutorial = $('body').data('tutorial');
            $('body').data('tutorial', stepTutorial - 2);
            runStep();
        }

        function linkNext(){
            runStep();
        }

        function runStep(){
            let stepTutorial = $('body').data('tutorial');

            console.log(stepTutorial);

            hideText();

            if(stepTutorial !== undefined && stepTutorial === 1){
                step_transport();
            }
            if(stepTutorial !== undefined && stepTutorial === 2){
                step_payment();
            }

            if(stepTutorial !== undefined && stepTutorial === 3){
                step_documents();
            }

            if(stepTutorial !== undefined && stepTutorial === 4){
                step_progress();
            }

            if(stepTutorial !== undefined && stepTutorial === 5){
                step_activate();
            }

            if(stepTutorial !== undefined && stepTutorial === 6){
                hide_tutorial();
            }
        }

        function hideText(){
            $('.overlay_tutorial__text_1').hide();
            $('.overlay_tutorial__text_2').hide();
            $('.overlay_tutorial__text_3').hide();
            $('.overlay_tutorial__text_4').hide();
            $('.overlay_tutorial__text_5').hide();
        }



        // STEP 1
        function step_transport(){
            $('.overlay_tutorial__text_1').fadeIn();
            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__link_back').fadeOut();

            let listTransportWrapper = $('.box-list-transport .bootstrap-select');
            let listTransport = $('.box-list-transport .bootstrap-select .list-transport');

            let elPositionTop = listTransportWrapper.offset().top;
            let elPositionLeft = listTransportWrapper.offset().left;
            let elPositionWidth = listTransportWrapper.width();
            let elPositionHeight = listTransportWrapper.height();

            let elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', (elPositionTop - elPositionHeight -10) + 'px');
            elArrow.css('left', (elPositionLeft + elPositionWidth - 20) + 'px');

            $('body').data('tutorial', 2);
        }

        // STEP 2
        function step_payment(){
            $('.overlay_tutorial__step_current').text('2');
            $('.overlay_tutorial__link_back').fadeIn();

            let tabPayment = $('a[href="#payment"]');
            tabPayment.tab('show');

            $('#payment').css('z-index', '10001');
            $('#payment').css('position', 'relative');

            $('.overlay_tutorial__text_2').fadeIn();

            view_tutorial();

            $(tabPayment).on('shown.bs.tab', function (e) {
                let elRecommendPrice = $('input[name=recommend_price]');

                let elPositionTop = elRecommendPrice.offset().top;
                let elPositionLeft = elRecommendPrice.offset().left;
                let elPositionWidth = elRecommendPrice.width();
                let elPositionHeight = elRecommendPrice.height();

                let elArrow = $('.overlay_tutorial__arrow');
                elArrow.css('top', (elPositionTop - elPositionHeight - 30) + 'px');
                elArrow.css('left', (elPositionLeft + elPositionWidth - 20) + 'px');
            });

            $('body').data('tutorial', 3);

        }

        // STEP 3
        function step_documents(){
            $('.overlay_tutorial__step_current').text('3');

            $('.overlay_tutorial__arrow').hide();

            let tabDocuments = $('a[href="#documents"]');
            tabDocuments.tab('show');

            view_tutorial();
            $('.overlay_tutorial__text_3').fadeIn();

            $('#documents').css('z-index', '10001');
            $('#documents').css('position', 'relative');

            $('body').data('tutorial', 4);
        }

        function step_progress(){
            $('.overlay_tutorial__step_current').text('4');

            $('.overlay_tutorial__arrow').hide();

            let tabProgress = $('a[href="#progress"]');
            tabProgress.tab('show');

            view_tutorial();
            $('.overlay_tutorial__text_4').fadeIn();

            $('#progress').css('z-index', '10002');

            $('body').data('tutorial', 5);

        }

        function step_activate(){
            $('.overlay_tutorial__step_current').text('5');

            let elArrow = $('.overlay_tutorial__arrow');

            let activateButton = $('#activate-button');

            if(activateButton.length){
                view_tutorial();
                $('.overlay_tutorial__text_5').fadeIn();
                elArrow.show();

                activateButton.css('z-index', '10005');

                let elPositionTop = activateButton.offset().top;
                let elPositionLeft = activateButton.offset().left;
                let elPositionWidth = activateButton.width();
                let elPositionHeight = activateButton.height();

                elArrow.css('top', (elPositionTop - elPositionHeight - 30) + 'px');
                elArrow.css('left', (elPositionLeft + (elPositionWidth / 2)) + 'px');

                $('html, body').animate({
                    scrollTop: activateButton.offset().top
                }, 2000);
            } else {
                hide_tutorial();
            }

            $('body').data('tutorial', 6);
        }

    </script>

@endpush