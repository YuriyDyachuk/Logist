@push('styles')
    <style>

        html, body{
            min-height: 100%;
        }
        body{
            position: relative;
        }
        .overlay_tutorial{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10001;
            /*background-color: rgba(200,200,200,0.6); !*dim the background*!*/
            background-color: rgba(0,0,0,0.4); /*dim the background*/
        }

        .overlay_tutorial__box{
            position: absolute;
            z-index: 10010;

        }

        .overlay_tutorial__box {
            background-color: #F2F7FA;
            padding: 16px 16px;
            position: absolute;
            border: none;
            -webkit-box-shadow: 0px 0px 13px -5px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 13px -5px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 13px -5px rgba(0,0,0,0.75);
            border-radius: 5px;
            width: 400px;
        }

        .overlay_tutorial__link_close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #777;;
            text-transform: uppercase;
            border-radius: .25em ;
            border: none;
            /*padding: 5px;*/
            font-size: 14px;
            line-height: 0;
        }

        .overlay_tutorial__title {
            font-family: opensans-regular;
            margin-top: 5px;
            font-size: 18px;
            /*padding-left: 20px;*/
            padding-right: 15px;
            font-weight: bold;
            color: #4D5C8B;
        }

        .overlay_tutorial__content {
            /*padding-left: 20px;*/
            /*padding-right: 15px;*/
        }

        .overlay_tutorial__text {
            font-size: 14px;
            color: #000000;
            margin-bottom: 25px;
            width: 100%;
            margin-top: 20px;
        }

        .overlay_tutorial__links {
            text-align: right;
        }

        .overlay_tutorial__links div {
            /*width: 30%;*/
            /*float: left;*/
            /*margin-bottom: 20px;*/
            /*margin-left: 20px;*/
            display: inline-block;
            width: 32%;
        }

        .overlay_tutorial__links div:first-child {
            margin-left: 0;
        }

        .overlay_tutorial__links div:last-child {
            /*margin-left: 10px;*/
        }

        .overlay_tutorial__steps {
            /*margin-top: 10px;*/
            color: #c3c5c7;
            text-align: left;
        }

        .overlay_tutorial__steps span{
            position: relative;
            left: -7px;
        }

        .overlay_tutorial__link  a{
            width: 95%;
            display: block;
            text-align: center;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            border-radius: .25em;
            padding: 5px;
            font-weight: bold;
            margin-left: auto;
        }

        .overlay_tutorial__links .overlay_tutorial__link_back {
            color: #00cf3e;
            background-color: #ffffff;
            border: 2px solid #00cf3e;
        }

        .overlay_tutorial__links .overlay_tutorial__link_next {
            color: #ffffff;
            background-color: #00cf3e;
            border: 2px solid #00cf3e;
        }

        .overlay_tutorial__links a.overlay_tutorial__link_next:hover {
            background-color: #00b839;
            border: 2px solid #00b839;
        }

        .overlay_tutorial__links a.overlay_tutorial__link_back:hover {
            color: #ffffff;
            background-color: #00cf3e;
            border: 2px solid #00cf3e;
        }


        @media (max-width: 649.999px) {
            .overlay_tutorial__box {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                border-radius: 0;
            }
        }

        .overlay_tutorial__arrow {
            position: absolute;
            width: 70px;
            height: 45px;
            background-image: url('/images/svg/curved-arrow.svg');
            background-repeat: no-repeat;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(window).on('load', function() {
            view_tutorial();
            hidden_tutorial();
            setTutorialPosition();
        });

        function setTutorialPosition(top){
            var elBox = $('.overlay_tutorial__box');
            var winWidth = $(window).width();
            var elBoxWidth = elBox.width();

            if(winWidth <= getResponsivePoint()) {

            } else {

                if(top !== undefined) {
                    elBox.css('top', top);
                } else {
                    elBox.css('top', '400px');
                }

                elBox.css('left', (0.5 * winWidth - elBoxWidth / 2) + 'px');
            }
        }

        function hidden_tutorial(){
            $('.overlay_tutorial__link_close').on('click', function() {
                hiddenTutorial();
            });

            $('.overlay_tutorial__link_next').on('click', function() {
                if (typeof linkNext !== 'undefined' && $.isFunction(linkNext)) {
                    linkNext();
                }
            });

            $('.overlay_tutorial__link_back').on('click', function() {
                if (typeof linkBack !== 'undefined' && $.isFunction(linkBack)) {
                    linkBack();
                }
            });
        }

        function hiddenTutorial(){
            if (typeof preventFnc !== 'undefined' && $.isFunction(preventFnc)) {
                preventFnc();
            } else {
                hide_tutorial();
            }

            if (typeof reset_css !== 'undefined' && $.isFunction(reset_css)) {
                reset_css();
            } else {
                console.log('reset_css undefined')
            }
        }

        function view_tutorial(){

            $('.overlay_tutorial').height('100%');
//            $('.overlay_tutorial').height($(document).height());
            $('.overlay_tutorial').fadeIn();
            $('.overlay_tutorial__box').fadeIn();
        }

        function hide_tutorial(){
            $('.overlay_tutorial').fadeOut();
            $('.overlay_tutorial__box').fadeOut();
        }

        function getResponsivePoint(){
            var responsivePoint = 649.999;

            return responsivePoint;
        }
    </script>
@endpush



