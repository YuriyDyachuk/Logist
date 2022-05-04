@extends('layouts.register_new')

@section('content')
    <div class="registration-page">
        <div class="row page-content  margin-top-lg padding-top-lg">
            <div class="col-xs-12 col-xs-offset-0 col-sm-8 col-sm-offset-2">
                <div class="content-box__wrapper">
                    <div class="content-box__body-type">

                        <div class="text-center">
                            <div class="logo"></div>
                        </div>

                        <div class="text-center">
                            <h3 class="h3">{{ trans('all.glad_to_see_you') }}</h3>
                        </div>

                        <div class="tabs-box" id="registerPopoverWrap">
                            @include('auth.partials.'.$account.'-register')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- tutorials --}}
    @include('tutorials.tutorials', ['account' => $account])
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            /* Validation Tel */
            var inputPhones = $(".phone_1, .phone_2");

            inputPhones.intlTelInput({
                                         initialCountry: "ua",
                                         nationalMode: false,
                                         formatOnDisplay: true,
                                         utilsScript: "{{url('plugins/phone_input/js/utils.js')}}",
                                     });

            inputPhones.blur(function () {
                if ($.trim($(this).val())) {
                    var $group = $(this).parents('.form-group');

                    $group.find('.help-block').detach();
                    if ($(this).intlTelInput("isValidNumber")) {
                        $group.removeClass("has-error");
                    } else {
                        $group.addClass("has-error");
                        $group.append('<span class="help-block"><strong>Телефон недействителен</strong></span>');
                    }
                }
            });

            inputPhones.focus(function () {
                $(this).parent().removeClass("has-error");
            });
        });

//        $(document).find('.tooltipItem').each(function (index) {
//            let $this     = $(this);
//            $(this).popover({
//                container: $(this),
//                html     : true,
//                placement: 'auto right',
//                title    : $(this).data('title'),
//                content  : $(this).data('body'),
//                trigger  : 'hover'
//            });
//        })
    </script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>

        function recaptchaCallbackP() {
            $('#submitP').removeAttr('disabled');
        }

        function recaptchaCallbackC() {
            $('#submitC').removeAttr('disabled');
        }
    </script>
@endpush