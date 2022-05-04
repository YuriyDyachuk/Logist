@extends('layouts.register')

@section('content')
    <div class="container registration-page login">
        <div class="row page-content">
            <div class="content-box col-xs-12 col-sm-6 col-sm-offset-3">
                <div class="content-box__wrapper">
                    <div class="col-xs-12">
                        <div class="content-box__header"><h1 class="h1 title-blue">{{ trans('all.reset.password') }}</h1></div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="register-form" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}

                            <div class="content-box__body-field">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">{{trans('all.email_address')}}</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ $email or old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">{{trans('all.password')}}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm"
                                           class="control-label">{{trans('all.password_confirm')}}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn button-green btn-block">
                                    {{trans('all.password_reset')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
