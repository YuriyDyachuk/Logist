<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.head')
</head>
<body style="height: 100%">
@include('layouts.includes.cookie-warning')
<section>

        <div class="margin-left-0 margin-right-0 auth_wrap">

            <div class="panel margin-bottom-0 auth_panel" style="min-height:100%">
                <div class="col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0 col-md-12 col-md-offset-0 col-lg-12 col-lg-offset-0">
                    @yield('content')
                </div>
            </div>
            <div class="hidden-xs hidden-sm auth_placeholder" style="min-height:100%">
                &nbsp;
            </div>


        </div>

</section>

<script type="text/javascript" src="{{ url('bower-components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/phone_input/js/intlTelInput.js') }}"></script>

{{-- Bower components js --}}
<script type="text/javascript" src="{{ url('bower-components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/moment/min/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/moment/min/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/moment/locale/ru.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/simplelightbox/dist/simple-lightbox.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower-components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>

<script type="text/javascript" src="{{ url('bower-components/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js') }}"></script>

<script>
    var sa2_btn_cancel = '{{ trans('all.cancel') }}';
</script>

<script type="text/javascript" src="{{ url('/main_layout/js/script.js') }}"></script>
<script type="text/javascript" src="{{ url('/main_layout/js/main.js') }}"></script>
<script type="text/javascript" src="{{ url('/main_layout/js/auth.js') }}"></script>

@stack('scripts')

@stack('tutorials')
</body>
</html>