<div class="row"style="max-width: 100%;">
        <div id="copyright" class="copyright col-sm-6 col-xs-12 text-center">
                <span>Copyright © Innlogist 2018-<?php echo date('Y');?> . All right reserved.</span>
        </div>
        <div class="copyright col-sm-6 col-xs-12 text-center">
                <img src="/img/visa_mastercard.png" height="30px"/>
        </div>
</div>

@section('scripts')
        <script type="text/javascript" src="{{ url('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ url('/plugins/phone_input/js/intlTelInput.js') }}"></script>

        {{-- Bower components js --}}
        <script type="text/javascript" src="{{ url('bower-components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/moment/min/moment-with-locales.min.js') }}"></script>
        @if(app()->isLocale('en'))
                <script type="text/javascript" src="{{ url('bower-components/moment/locale/en-gb.js') }}"></script>
        @else
                <script type="text/javascript" src="{{ url('bower-components/moment/locale/ru.js') }}"></script>
        @endif


        <script type="text/javascript" src="{{ url('bower-components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/simplelightbox/dist/simple-lightbox.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/dragscroll/dragscroll.js') }}"></script>

        <script type="text/javascript" src="{{ url('/main_layout/js/script.js') }}"></script>

        <script>
                var sa2_btn_cancel = '{{ trans('all.cancel') }}';
        </script>

        <script type="text/javascript" src="{{ url('/main_layout/js/main.js') }}"></script>
@endsection