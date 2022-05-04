@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.order-template-new-title'))
    @section('tutorial')
        <div class="overlay_tutorial__text">{!! trans('tutorials.order-template-new') !!}
        </div>
    @endsection
@endpush


@push('styles')
    <style>
        .overlay_tutorial__arrow {
            left: 75%;
            top: 135.6px;
        }

        .order-new-page .__header .bootstrap-select  {
            z-index: 10002;
        }

        .overlay_tutorial__link {
            visibility: hidden;
        }
    </style>
@endpush


@push('scripts')
    <script>
        $(window).on('load', function() {

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');

            var elPosition = $('.order-new-page .__header .bootstrap-select').offset();
            var elPositionTop = elPosition.top;
            var elPositionLeft = elPosition.left;

            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop + 55 + 'px');
            elArrow.css('left', elPositionLeft - 50 + 'px');
            elArrow.show();
        });

        function reset_css(){
            $('.order-new-page .__header .bootstrap-select').css('z-index', 2);
        }

    </script>

@endpush

@include('tutorials.includes.common')

