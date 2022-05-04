@extends('layouts.register')

@section('content')

    <div class="container registration-page login">
        <div class="row page-content">
            <div class="content-box col-xs-12 col-sm-6 col-sm-offset-3">
                <div class="content-box__wrapper">
                    <div class="col-xs-12">
                        <div class="content-box__header"><h1 class="h1 title-blue">{{ trans('all.reset_password') }}</h1></div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="register-form" method="POST" action="{{ route('password.email') }}" style="margin-right: 0">
                            {{ csrf_field() }}

                            <div class="content-box__body-field">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">{{trans('all.email_address')}}</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn button-green btn-block" style="text-transform: inherit">
                                   {{ trans('all.send_password_reset_link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
