@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.transport-section-title') )
@section('tutorial')
    <div class="overlay_tutorial__text">{{ trans('tutorials.transport-section') }}
    </div>
@endsection
@endpush


@push('styles')
    <style>

        .overlay_tutorial__arrow {
            left: 70px;
            top: 270px;
            -moz-transform: scale(-1, -1);
            -webkit-transform: scale(-1, -1);
            -o-transform: scale(-1, -1);
            -ms-transform: scale(-1, -1);
            transform: scale(-1, -1);
        }

        .overlay_tutorial__left-sidebar {
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(200,200,200,0.6);
        }

        .left-sidebar {
            z-index: 10003;
        }

        body:not(.is-collapsed) .left-sidebar:hover {
            width: 250px;
            overflow-y: hidden;

        }

        .overlay_tutorial__link_back {
            visibility: hidden;
        }
    </style>
@endpush


@push('scripts')
    <script>

        $(window).on('load', function() {

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');

            let leftSidebar = $('.left-sidebar ');
            let leftSideBarHeight = leftSidebar.height();
            let leftSideBarWidth = leftSidebar.width();

            leftSidebar.append('<div class="overlay_tutorial__left-sidebar"></div>');
            let overlayTutorialLeftSidebar = $('.overlay_tutorial__left-sidebar');

            console.log(leftSideBarHeight);
            console.log(leftSideBarWidth);

            overlayTutorialLeftSidebar.height(leftSideBarHeight);
            overlayTutorialLeftSidebar.width(leftSideBarWidth + 250);

            let elLink = $('.as-transport').parents('li');
            elLink.css('background-color', '#0c1b2c');
            elLink.css('position', 'relative');
            elLink.css('z-index', '10005');

            $('.overlay_tutorial__link_next ').attr('href', elLink.find('a').attr('href'));

            var elPosition = elLink.offset();
            var elPositionTop = elPosition.top;
            var elPositionLeft = elPosition.left;

            var elArrow = $('.overlay_tutorial__arrow');
            elArrow.css('top', elPositionTop - 40 + 'px');
            elArrow.css('left', elPositionLeft + 70 + 'px');
            elArrow.show();

        });

        function reset_css(){
            $('.overlay_tutorial__left-sidebar').remove();
            let elLink = $('.as-transport').parents('li');
            elLink.css('background-color', 'inherit');
        }

    </script>

@endpush

@include('tutorials.includes.common')

