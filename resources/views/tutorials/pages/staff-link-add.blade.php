@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.staff-link-add-title'))
@section('tutorial')
    <div class="overlay_tutorial__text">{!! trans('tutorials.staff-link-add')  !!}</div>
@endsection
@endpush

@push('styles')
    <style>

        .overlay_tutorial__arrow {
            left: 75%;
            top: 135.6px;
        }

        #linkAddEmployee {
            z-index: 10005;
            position: relative
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

            var elPosition = $('#linkAddEmployee');
            var elPositionTop = elPosition.offset().top;
            var elPositionLeft = elPosition.offset().left;
            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop + 40 + 'px');
            elArrow.css('left', elPositionLeft - 55 + 'px');

            $('#linkAddEmployee').on('click', function(){
                hiddenTutorial();
            });
        });

        function reset_css(){
            $('#linkAddEmployee').css('z-index', 'inherit');
        }



    </script>

@endpush

@include('tutorials.includes.common')

