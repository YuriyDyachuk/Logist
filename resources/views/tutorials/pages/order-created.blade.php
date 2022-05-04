@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.order-created-title'))
@section('tutorial')
    <div class="overlay_tutorial__text">
        {!! trans('tutorials.order-created') !!}
    </div>
@endsection
@endpush


@push('styles')
    <style>
        /*.overlay_tutorial__text {*/
            /*left: 22%;*/
            /*top: 250px;*/
        /*}*/

        .overlay_tutorial__arrow {
            left: 15%;
            top: 250px;
            -moz-transform: scale(-1, -1);
            -webkit-transform: scale(-1, -1);
            -o-transform: scale(-1, -1);
            -ms-transform: scale(-1, -1);
            transform: scale(-1, -1);
        }

        .content-box__row:nth-child(1){
            z-index: 10002;
            position: relative;
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

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');

            let elOrder = $('.content-box__row:nth-child(1)');
            let link = elOrder.find('.link-order').attr('href');

            $('.overlay_tutorial__link_next').attr('href', link);

            var elPosition = elOrder.offset();
            var elPositionTop = elPosition.top;
            var elPositionLeft = elPosition.left;
            var elOrderHeight = elOrder.height();

            var elBox = $('.overlay_tutorial__box');
            setTutorialPosition((elPositionTop + elOrderHeight + 30) + 'px');

            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop - 50 + 'px');
            elArrow.css('left', elPositionLeft + 70 + 'px');
            elArrow.show();
        });

        function reset_css(){
            let elOrder = $('.content-box__row:nth-child(1)');
            elOrder.css('z-index', 'inherit');
        }

    </script>

@endpush