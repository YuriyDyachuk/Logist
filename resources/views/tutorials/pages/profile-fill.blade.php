@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.profile-fill-title'))
@section('tutorial')
    <div class="overlay_tutorial__text">{{ trans('tutorials.profile-fill') }}
    </div>
@endsection
@endpush


@push('styles')
    <style>
        .overlay_tutorial {
            display: none;
        }

        .overlay_tutorial__arrow {
            left: 45%;
            top: 150px;
            -moz-transform: scale(-1, -1);
            -webkit-transform: scale(-1, -1);
            -o-transform: scale(-1, -1);
            -ms-transform: scale(-1, -1);
            transform: scale(-1, -1);
        }

        #edit_user {
            position: relative;
        }

        .overlay_tutorial__link_back {
            visibility: hidden;
        }

        .overlay_tutorial__arrow {
            display: none;
        }
    </style>
@endpush

@include('tutorials.includes.common')

@push('scripts')
    <script>

        $(window).on('load', function() {

            if($('#selectProfile').is(":visible") == true){
                hide_tutorial();
            }

            $('#btn_selectProfile').on('click', function(){
                view_tutorial();
            });

            $('.overlay_tutorial__step_current').text('1');
            $('.overlay_tutorial__step_amount').text('1');

            $('#edit_user').find('input').css('position', 'relative');
            $('#edit_user').find('.bootstrap-select').css('position', 'relative');

            let hash = window.location.hash.substr(1);

            if(hash === 'individual' || hash === 'company') {
                view_tutorial();
                zindex('input', '10003');
                zindex('.bootstrap-select', '10003');
                zindex('.flag-container', '10004');
                $('body').data('tutorial', 1);
            }

            let modal = $('#selectProfile');

            modal.on('shown.bs.modal', function (e) {
                hide_tutorial();
            });

            modal.on('hidden.bs.modal', function (e) {
                view_tutorial();
                zindex('input', '10003');
                zindex('.bootstrap-select', '10003');
                zindex('.flag-container', '10004');
            })
        });

        function reset_css() {

            let hash = window.location.hash.substr(1);
            let step = $('body').data('tutorial');

            if(hash && (step === undefined)) {
//                $('.overlay_tutorial').show();
                view_tutorial();
                zindex('input', '10003');
                zindex('.bootstrap-select', '10003');
                zindex('.flag-container', '10004');

                $('body').data('tutorial', 1);
            }
        }


        function zindex(el,index){
            $('#edit_user').find(el).css('z-index', index);
        }

//        function preventFnc(){
//            let step = $('body').data('tutorial');
//            let modal = $('#selectProfile');
//
//            if((modal.is(':visible') !== true || modal.css('display') === 'none') && step !== undefined){
//                hide_tutorial();
//                zindex('input', 'inherit');
//                zindex('.bootstrap-select', 'inherit');
//                zindex('.flag-container', 'inherit');
//            }
//        }

        function linkNext(){
            hide_tutorial();
            zindex('input', 'inherit');
            zindex('.bootstrap-select', 'inherit');
            zindex('.flag-container', 'inherit');
        }

    </script>

@endpush