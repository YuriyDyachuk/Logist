@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.transport-new-title'))
@section('tutorial')
    <div class="overlay_tutorial__text">{!! trans('tutorials.transport-new') !!}
    </div>
@endsection
@endpush


@push('styles')
    <style>

        .overlay_tutorial__arrow {
            left: 75%;
            top: 135.6px;
        }

        .content-box__add-client  {
            z-index: 10002;
            position: relative;
        }

        .overlay_tutorial__link_back {
            visibility: hidden;
        }
    </style>
@endpush


@push('scripts')
    <script>

        $(window).on('load', function() {

            $('.tutorial').modal('hide');

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');

            var elPosition = $('.content-box__add-client');
            var link = elPosition.find('a').attr('href');
            $('.overlay_tutorial__link_next ').attr('href', link);

            var elPositionTop = elPosition.offset().top;
            var elPositionLeft = elPosition.offset().left;

            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop + 55 + 'px');
            elArrow.css('left', elPositionLeft - 50 + 'px');
        });

        function reset_css(){
            $('.content-box__add-client').css('z-index', 2);
        }

    </script>

@endpush

@include('tutorials.includes.common')

