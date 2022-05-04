@extends('layouts.register_new')

@section('content')
    <div class="registration-page">
        <div class="row page-content margin-top-lg padding-top-lg">
            <div class="content-box col-xs-12 col-xs-offset-0 col-sm-8 col-sm-offset-2 col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1">
                <div class="content-box__wrapper">
                    <div class="content-box__body-type">
                        @if(Session::has('msg-send-email'))
                            <div class="col-sm-6 col-sm-offset-3 text-center">
                                <div class="cover cover-client"></div>
                                <div class="content-box__header">
                                    <p>{{Session::get('msg-send-email')}}</p>
                                </div>
                            </div>

                            <div class=" col-xs-12 text-center content-box__body-submit">
                                <a href="" class="btn button-style1 transition disabled" data-user="{{session('msg-send-email-userId')}}" id="repeat_send_msg">{{ trans('auth.email_activation_again') }}</a><br>
                                {{--<p id="timer_wrapper">Повторить отправку через <span id="timer">60</span> с</p>--}}
                                <p id="timer_wrapper">{!! trans('auth.email_activation_again_time', ['sec' => 60]) !!}</p>
                                {{--<a href="{{ url('/login') }}" class="btn button-green transition"--}}
                                   {{--value="submit">{{ trans('all.finish_register') }}</a>--}}
                            </div>
                        @elseif(Session::has('msg-send-fail'))
                            {{session('msg-send-fail')}}
                        @else
                            <div class="content-box__header">
                                <h1 class="h1 title-blue">{{ trans('register.start') }}</h1>
                                <p>{{ trans('register.select_role') }}</p>
                            </div>

                            <div class="box-items">
                                {{-- Person --}}
                                <div class="col-sm-6 item-profile">
                                    <div class="item-profile-person text-center">
                                        <div class="cover"></div>
                                        <a href="{{ url('/profile/register', ['account' => 'client']) }}"
                                           class="btn button-style1">{{trans('all.logistic_owner')}}</a>
                                    </div>
                                </div>

                                {{-- Company --}}
                                <div class="col-sm-6 item-profile">
                                    <div class="item-profile-company text-center">
                                        <div class="cover"></div>
                                        <a href="{{ url('/profile/register', ['account' => 'logistic']) }}"
                                           class="btn button-style1">{{trans('all.logistic_carrier')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if(Session::has('msg-send-email'))
    <script>
        $(document).ready(function () {
            $('#repeat_send_msg').on('click', function(e) {
                e.preventDefault();

                timer_reset();

                let userId = $(this).data('user');

                var csrf = $('meta[name="csrf-token"]').attr('content');

                data = {_token: csrf, user_id: userId};

            $.post('{{route('register.send', ['type' => 'email'])}}', data, function(data, status){

            }).fail(function() {
                appAlert('', 'error', 'warning');
            });
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


        });
    </script>
    @endif
@endpush