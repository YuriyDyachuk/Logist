@push('tutorials')
    <div class="overlay_tutorial">
        <div class="overlay_tutorial__text">Заполните необходимые поля для регистрации</div>
    </div>
@endpush


@push('styles')
    <style>
        .overlay_tutorial__text {
            font-family: opensans-regular;
            position: absolute;
            left: 5%;
            top: 130px;
            font-size: 18px!important;
            /*color: #ffffff;*/
            font-weight: bold;
        }

        .overlay_tutorial__arrow {
            position: absolute;
            left: 75%;
            top: 135.6px;
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

            $('.registration-page input').each(function(i){
                $(this).css('z-index', '10002');
                $(this).css('position', 'relative');
            });

        });

    </script>

@endpush

@include('tutorials.includes.common')