@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.order-link-new-title'))
    @section('tutorial')
        <div class="overlay_tutorial__text">
            {!! trans('tutorials.order-link-new')  !!}
            @php
                if(!in_array(getPaymentSubscription()->plan_id, [3,4]) && !auth()->user()->isClient()){
                    echo '<br><br><i>'.trans('tutorials.order-link-new_2').'</i>';
                }
            @endphp

        </div>
    @endsection
@endpush

@push('styles')
    <style>

        .overlay_tutorial__link_back {
            visibility: hidden;
        }

        @if(!in_array(getPaymentSubscription()->plan_id, [3,4]))
        .overlay_tutorial__links div {
            width: 49%!important;
        }
        @endif

        .overlay_tutorial__arrow {
            left: 75%;
            top: 135.6px;
            display: none;
        }

        #linkOrderNew  {
            z-index: 10002;
            position: relative;
        }
    </style>
@endpush


@push('scripts')
    <script>

        $(window).on('load', function() {

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');
            $('.overlay_tutorial__link_back').parent().hide();

            $('.overlay_tutorial__link_next').text('{{trans('tutorials.btn_skip')}}');

            var el = $('#linkOrderNew');
            var elPosition = el.offset();
            var elPositionTop = elPosition.top;
            var elPositionLeft = elPosition.left;

//            $('.overlay_tutorial__link_back').attr('href', el.attr('href'));

            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop + 45 + 'px');
            elArrow.css('left', elPositionLeft - 50 + 'px');
            elArrow.show();

            @if(!in_array(getPaymentSubscription()->plan_id, [3,4]))
                $('.overlay_tutorial__link_next ').on('click', function(){
                    hiddenTutorial();
                });
            @endif

        });

        function reset_css(){
            $('#linkOrderNew').css('z-index', 2);
        }

    </script>

@endpush

@include('tutorials.includes.common')

