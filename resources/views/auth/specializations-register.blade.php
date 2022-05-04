@extends('layouts.register')

@section('content')
    <div class="container registration-page">
        <div class="row page-content">
            <form class="col-sm-8 col-sm-offset-2 form-horizontal register-form" method="POST" action="{{ route('specializations.register', ['user' => $user_id]) }}">

                {{ csrf_field() }}

                <div class="content-box__body">
                    <div class="content-box__header">
                        <h1 class="h1 title-blue">Create a Free Account</h1>
                        <p>Select categories:</p>
                    </div>

                    @if ($errors->has('specializations'))
                        <div class="form-group has-error text-center">
                            <span class="help-block">
                                <strong>{{ $errors->first('specializations') }}</strong>
                            </span>
                        </div>
                    @endif

                    <div class="content-box__body-field type-checkbox">
                        @foreach($specializations as $specialization)
                            <div class="form-group">
                                <input type="checkbox" id="check{{ $loop->iteration }}" name="specializations[]"
                                       value="{{ $specialization['id'] }}">
                                <label for="check{{ $loop->iteration }}">{{ trans('all.'.$specialization['name'])}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class=" col-xs-12 text-center content-box__body-submit">
                    <button type="submit" name="submitCompany" class="btn button-green transition" value="submit" loader-btn>Подать заявку
                        на регистрацию <span class="arrow-right"></span></button>
                </div>
            </form>
        </div>
    </div>
@endsection