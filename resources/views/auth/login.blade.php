@extends('layouts.register_new')

@section('content')
    <div class="login ">
        <div class="row page-content  margin-top-lg padding-top-lg">
            <div class="col-xs-12">
                <div class="content-box__wrapper">
                    <div class="">
                        <form class="register-form col-xs-12 col-sm-10 col-sm-offset-1 login-form" id="login-form" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="text-center">
                                <div class="logo"></div>
                            </div>

                            <div class="text-center">
                                <h3 class="h3">{{ trans('all.glad_to_see_you') }}</h3>
                            </div>

                            <div>

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group margin-top-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" placeholder="{{trans('all.email_address')}}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group margin-top-lg step2 passwordInput{{ $errors->has('password') ? ' has-error' : '' }}"
                                     @if(!$errors->count()) style="display: none" @endif>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="{{ trans('all.password') }}">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

{{--                                <div class="form-group type-checkbox">--}}
{{--                                    <input type="checkbox" id="remember" name="remember"--}}
{{--                                            {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                    <label for="remember">{{trans('all.remember_me')}}</label>--}}

{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ trans('all.password_forgot') }}--}}
{{--                                    </a>--}}
{{--                                </div>--}}

                                <div class="col-sm-12 text-center">
                                    <div id="review_recaptcha"></div>
                                </div>


                                <div class="form-group text-center content-box__body-submit">
                                    <button type="button" class="btn btn-block button-style1 btn_step1 step1 transition" @if($errors->count()) style="display: none" @endif>
                                        {{ trans('all.login') }}
                                    </button>

                                    <button type="submit" class="g-recaptcha btn btn-block button-style1 btn_step2 step2 transition" @if(!$errors->count()) style="display: none" @endif data-sitekey="{{config('captcha.google_recaptcha_key')}}" data-callback='onSubmit'>
                                        {{ trans('all.login') }}
                                    </button>
                                    <a class="btn-link btn-block transition" href="{{ route('password.request') }}" style="margin-top: 20px;">
                                        {{ trans('all.password_forgot') }}
                                    </a>

                                    <?php $url = $_SERVER['HTTP_REFERER']; $values = parse_url($url); ?>
                                    @switch($values['path'])
                                        @case("/carrier/en")
                                        <a href="{{ url('/profile/register', ['account' => 'logistic']) }}"
                                           class="btn-link btn-block transition">{{ trans('all.register') }}</a>
                                        @break

                                        @case("/carrier/ru")
                                        <a href="{{ url('/profile/register', ['account' => 'logistic']) }}"
                                           class="btn-link btn-block transition">{{ trans('all.register') }}</a>
                                        @break

                                        @case("/carrier")
                                        <a href="{{ url('/profile/register', ['account' => 'logistic']) }}"
                                           class="btn-link btn-block transition">{{ trans('all.register') }}</a>
                                        @break

                                        @default
                                        <a class="btn-link btn-block transition" href="{{ route('register.home') }}">
                                            {{ trans('all.register') }}
                                        </a>
                                    @endswitch

                                </div>


                                {{--<div class="col-sm-12 text-center">--}}
                                    {{--{{ trans('all.or_auth') }}--}}
                                {{--</div>--}}


                                {{--<div class="col-sm-12 social-btn-box text-center">--}}
                                    {{--<div class="row">--}}
                                        {{--<a href="{{route('social.login', ['facebook'])}}" class="btn btn-facebook">&nbsp;</a>--}}
                                        {{--<a href="{{route('social.login', ['google'])}}" class="btn btn-google">&nbsp;</a>--}}
                                        {{--<a href="{{route('social.login', ['linkedin'])}}" class="btn btn-linkedin">&nbsp;</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.includes.msg')
@endsection

@push('scripts')
@if(config('captcha.google_recaptcha_check') !== false)
    @if ($errors->has('g-recaptcha-response'))
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    @else
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        function onSubmit(token) {
            document.getElementById("login-form").submit();
        }

        var review_recaptcha_widget;
        var onloadCallback = function() {
            if($('#review_recaptcha').length) {
                review_recaptcha_widget = grecaptcha.render('review_recaptcha', {
                    'sitekey' : '{{config('captcha.google_recaptcha_key')}}'
                });
            }
        };

    </script>
@endif
@endpush