@extends('layouts.register_new')

@section('content')
    <div class="registration-page">
        <div class="row page-content margin-top-lg padding-top-lg">
            <div class="content-box col-xs-12">
                <div class="content-box__wrapper">
                    <div class="content-box__body-type">
                        <form class="col-sm-12 register-form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="userId" value="{{$userId}}">
                            <div class="form-group">
                                <input type="tel" name="phone" id="phone" class="form-control phone" placeholder="{{trans('all.phone_user')}}" value="">
                                <span class="help-block" id="error_phone" style="display: none;"></span>

                            </div>

                            <div class="form-group phoneCheck" style="display: none;">
                                <input type="text" name="phoneCheck" id="phoneCheck" class="form-control" placeholder="Проверочный код" value="">
                                <span class="help-block" style="display: none;"></span>
                            </div>
                            <div class="form-group col-xs-12 text-center content-box__body-submit">
                                <button id="submit" type="submit" name="submit" class="btn button-style1 btn-block transition" value="submit"  disabled>{{ trans('auth.phone_activation') }}</button>
                                <a href="" class="btn button-style1 btn-block transition disabled" data-user="{{$userId}}" id="repeat_send_msg" style="display: none;">{{ trans('auth.phone_activation_again') }}</a><br>
                                <p id="timer_wrapper" style="display: none;">{!! trans('auth.phone_activation_again_time') !!}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            /* Validation Tel */
            var inputPhones = $(".phone");

            inputPhones.intlTelInput({
                initialCountry: "ua",
                nationalMode: false,
                formatOnDisplay: true,
                utilsScript: "{{url('plugins/phone_input/js/utils.js')}}",
            });

            inputPhones.blur(function () {
                if ($.trim($(this).val())) {
                    var $group = $(this).parents('.form-group');

//                    $group.find('.help-block').detach();
                    if ($(this).intlTelInput("isValidNumber")) {
//                        $group.removeClass("has-error");
                    } else {
//                        $group.addClass("has-error");
                        $group.find('.help-block').html('<strong>Телефон недействителен</strong>');
                    }
                }
            });

            inputPhones.focus(function () {
                $(this).parent().removeClass("has-error");
            });
// 38
            $('input[name=phone]').mask('+000-00-000-00-00');

            $('input[name=phone]').on('input',function(e){
                var value = $(this).val();
                var userId = $('input[name=userId]').val();
                $('.form-group').removeClass("has-error");
                $('#error_phone').hide();

                if(value.length == 17){

                    var csrf = $('meta[name="csrf-token"]').attr('content');

                    data = {_token: csrf, phone:value, user_id:userId};

                    $.post('/profile/register/send/phone', data, function(data, status){
                        $('input[name=phone]').prop('disabled', true);
                        $('#phoneCheck').prop('disabled', false);
                        $('#submit').prop('disabled', false);
                        $('.phoneCheck').show();
                        $('#repeat_send_msg').show();
                        timer_reset();

                    }).fail(function(data) {

                        $('#error_phone').html('<strong>'+data.responseJSON.phone+'</strong>');
                        $('#error_phone').parent('.form-group').addClass('has-error');

                        $('#error_phone').show();
                        appAlert('', 'error', 'warning');
                    });
                }

            });

            function timer(){
                let time = parseInt($('#timer').text());
                $('#timer').text(time-1);

                if(time == 1){
                    $('#timer_wrapper').hide();
                    $('#repeat_send_msg').removeClass('disabled');
                }
            }
            function timer_reset(){
                $('#timer').text(60);
                $('#timer_wrapper').show();
                $('#repeat_send_msg').addClass('disabled');
            }

            setInterval(timer, 1000);

            $('#submit').on('click',function(e){
                e.preventDefault();

                let code = $('#phoneCheck').val();

                data = {token:code};

                $.get('/verification/'+code, '', function(data, status){
                    if(data.status === true){
                        window.location.replace(data.url);
                    }

                    if(data.status === false){
                        appAlert('', data.text, 'warning');
                    }

                }).fail(function(data) {
                    appAlert('', 'error', 'warning');
                });
            });

            $('#repeat_send_msg').on('click', function(e) {
                e.preventDefault();

                timer_reset();

                let userId = $(this).data('user');

                var csrf = $('meta[name="csrf-token"]').attr('content');

                data = {_token: csrf, user_id: userId, phone: $('#phone').val()};
//
                $.post('{{route('register.send', ['type' => 'phone'])}}', data, function(data, status){

                }).fail(function() {
                    appAlert('', 'error', 'warning');
                });
            });

        });
    </script>
@endpush