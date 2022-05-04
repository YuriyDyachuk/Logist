<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.ga')
    {{--@include('layouts.includes.style-loader')--}}
    @include('layouts.includes.head')
    @include('layouts.includes.cookie-warning')
    @include('layouts.includes.fb-pixel')
    <style>
        @keyframes loader {
            0%, 10%, 100% {
                width: 80px;
                height: 80px;
            }
            65% {
                width: 150px;
                height: 150px;
            }
        }
        @keyframes loaderBlock {
            0%, 30% {
                transform: rotate(0);
            }
            55% {
                background-color: #00CF3E;
            }
            100% {
                transform: rotate(90deg);

            }
        }
        @keyframes loaderBlockInverse {
            0%, 20% {
                transform: rotate(0);
            }
            55% {
                background-color: #007cff;
            }
            100% {
                transform: rotate(-90deg);
            }
        }
        .cssload-body2 {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80px;
            height: 80px;
            transform: translate(-50%, -50%) rotate(45deg) translate3d(0, 0, 0);
            animation: loader 1.2s infinite ease-in-out;
            -moz-animation: loader 1.2s infinite ease-in-out;
            -webkit-animation: loader 1.2s infinite ease-in-out;
        }

        .cssload-body2 span {
            position: absolute;
            display: block;
            width: 40px;
            height: 40px;
            background-color: #007cff;
            animation: loaderBlock 1.2s infinite ease-in-out both;
            -moz-animation: loaderBlock 1.2s infinite ease-in-out both;
            -webkit-animation: loaderBlock 1.2s infinite ease-in-out both;
        }

        .cssload-body2 span:nth-child(1) {
             top: 0;
             left: 0;
         }
        .cssload-body2 span:nth-child(2) {
             top: 0;
             right: 0;
             animation: loaderBlockInverse 1.2s infinite ease-in-out both;
            -moz-animation: loaderBlockInverse 1.2s infinite ease-in-out both;
            -webkit-animation: loaderBlockInverse 1.2s infinite ease-in-out both;
         }
        .cssload-body2 span:nth-child(3) {
             bottom: 0;
             left: 0;
             animation: loaderBlockInverse 1.2s infinite ease-in-out both;
            -moz-animation: loaderBlockInverse 1.2s infinite ease-in-out both;
            -webkit-animation: loaderBlockInverse 1.2s infinite ease-in-out both;
         }
        .cssload-body2 span:nth-child(4) {
             bottom: 0;
             right: 0;
         }
    </style>
</head>
<body class="loading /*is-collapsed*/" data-language="{{app()->getLocale()}}">
{{--<body class="loading">--}}
    <div id="appLoader">
        {{--<div class="cssload-body">--}}
            {{--<span><span></span></span>--}}
        {{--</div>--}}
        <div class="cssload-body2">
            <span></span><span></span><span></span><span></span>
        </div>
        {{--<div class="cssload-longfazers">--}}
            {{--<span></span><span></span><span></span><span></span>--}}
        {{--</div>--}}
    </div>

    <section>
        <div id="app">
                <div class="left-sidebar transition">
                    @include('layouts.includes.sidebar')
                </div>

                <div class="page-container transition">
                    @include('layouts.includes.top-menu')

                    @include('layouts.includes.msg')

                    @yield('content')

                    @include('layouts.includes.footer')
                </div>
        </div>
    </section>

    <div id="scrollTop" class="hidden transition">
        <div class="transition">
            <i class="as as-adddocument"></i>
        </div>
    </div>

    @stack('tutorials')

    @yield('modals')

    @yield('scripts')

    @include('layouts.includes.modals')
    @stack('scripts')
<script type="text/javascript" src="{{ url('bower-components/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js') }}"></script>

{{--<script src="{{ url('main_layout/js/jquery-eu-cookie-law-popup.js') }}"></script>--}}
<script type="text/javascript">
    $(document).ready(function () {

        @if(profile_filled() === false && auth()->user()->isLogist() === false && in_array(\Route::currentRouteName(), ['user.setting', 'orders']) )

            let url, url_array, url_segment, company_type;

            url = window.location.href;
            url_array = url.split( '#' );

            if(typeof url_array[1] === 'undefined'){
                $('#selectProfile').modal('show');
            }
            else if(url_array[1] === 'individual' || url_array[1] === 'company'){
                viewBlock(url_array[1]);
            }

            $('.company_type').on('change', function(e){
                let type = $(this).val();

                $('#btn_selectProfile').prop('disabled', false);
                company_type = type;
            });

            $('#btn_selectProfile').on('click', function (e) {
                e.preventDefault();
                window.location.replace('{{route('user.setting')}}#' + company_type);
                $('#selectProfile').modal('hide');
//                $('.'+company_type+'_block ').show();
                viewBlock(company_type);

            });

        $('#btn_selectProfileLater').on('click', function (e) {
            e.preventDefault();
            $('#selectProfile').modal('hide');
        });


        function viewBlock(company_type){
            $('.'+company_type+'_block ').show();
            $("input[name='company_type'][value='"+company_type+"']").prop('checked', true);
        }
        @endif


        // Sidebar toggle
        if (localStorage.getItem('sidebar_collapsed') == 'false') {
            $('body').removeClass('is-collapsed');
        }

        setTimeout(function () {
            $('#appLoader').fadeOut(100, function () {
                $(this).detach();
                $('body').removeClass('loading');
            })
        }, 300);

        $( '.datetimepicker' ).datetimepicker( {
            useCurrent : false,
            locale : '{{app()->getLocale()}}',
            format : 'DD/MM/YYYY',
            disabledHours : [],
            // debug:true
        } );

        $( '.datetimepickerTime' ).datetimepicker( {
            useCurrent : false,
            locale : '{{app()->getLocale()}}',
            format : 'DD/MM/YYYY HH:mm',
            // collapse   : true,
            // debug:true
        } );

        @if(auth()->user())

        checkNotification();
        var c = 0;
        setInterval(function(){
            c++;
            checkNotification();
        }, 60000);

        function checkNotification(){
            $.ajax({
                url: '{{route('notification.check')}}',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (res) {
                    if(res.amount > 0){
                        $.notify({
                            // options
                            message: '{{trans('notification.new_notification')}}'
                        },{
                            // settings
                            type: 'info',
                            delay: 7000,
                        });
                    }
                })
                .fail(function () {

                })
        }

        @endif

    });
</script>
</body>
</html>