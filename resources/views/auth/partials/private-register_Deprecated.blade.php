<div class="">
    <form class="col-sm-12 register-form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <input type="hidden" name="role" value="{{$account}}-person">

        <div class="content-box__body-field private-field">


            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="@if (isset($data['user']->email)){{$data['user']->email}}@else{{ old('email') }}@endif" placeholder="{{trans('all.email_address')}}">

                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password_1" class="form-control" type="password" name="password" placeholder="{{trans('all.password')}}">

                @if ($errors->has('password'))
                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>
            {{--
            <div class="form-group">
                <input id="password_confirmation_1" class="form-control" type="password"
                       name="password_confirmation" placeholder="{{trans('all.password_confirm')}}">
            </div>
            --}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" class="form-control" placeholder="{{trans('all.name')}}"
                       value="@if (isset($data['user']->name)){{$data['user']->name}}@else{{ old('name') }}@endif">

                @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <input type="tel" name="phone" id="phone2" class="form-control phone_2" placeholder="{{trans('all.phone_user')}}"
                       value="{{ $data['user']->data->phone1 ?? str_replace(' ', '',old('phone'))}}">

                @if ($errors->has('phone'))
                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                <div class="g-recaptcha" data-sitekey="{{config('captcha.google_recaptcha_flag_key')}}" data-callback="recaptchaCallbackP">
                </div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block"><strong>{{ $errors->first('g-recaptcha-response') }}</strong></span>
                @endif
            </div>
        </div>

        <div class="col-sm-12 social-btn-box" style="display: none">
            <a href="{{route('social.login', ['facebook', $account . '-person'])}}"
               class="btn btn-facebook">{{trans('all.sign_in_with')}} Facebook</a>
            <a href="{{route('social.login', ['google', $account . '-person'])}}"
               class="btn btn-google">{{trans('all.sign_in_with')}} Google+</a>
            <a href="{{route('social.login', ['linkedin', $account . '-person'])}}"
               class="btn btn-linkedin">{{trans('all.sign_in_with')}} Linkedin</a>
        </div>


        <div>
            <div class="form-group col-xs-12 text-center content-box__body-submit">
                <button id="submitP" type="submit" name="submit" class="btn button-green btn-block transition" value="submit"  disabled>
                    {{ trans('all.register') }} <span class="arrow-right"></span>
                </button>
            </div>

            <div class="col-xs-12 col-xs-offset-1">
                <div class="license {{ $errors->has('license') ? ' has-error' : '' }}">
                    <input type="checkbox" name="license" id="agreement_company2" class="form-control" value="on">
                    <label for="agreement_company2">
                        {{trans('all.reed_and_agreed')}}<br/>
                        <a href="{{route('page.terms')}}" target="_blank">{{trans('all.innlogist.terms')}}</a><br>
                        <a href="{{route('page.privacy')}}" target="_blank">{{trans('all.innlogist.privacy')}}</a>

                        {{--<a href="#" data-toggle="modal"--}}
                           {{--data-target="#logistic_partner_agreement">{{trans('all.license')}}</a>--}}
                    </label>

                    @if ($errors->has('license'))
                        <span class="help-block">
                            <strong>{{ $errors->first('license') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        {{--<div class="col-xs-12 text-center content-box__add-partner">--}}
            {{--<p>Look Transport partner? <a href="{{ url('/profile/register/client') }}">Sing up like Client</a></p>--}}
        {{--</div>--}}
    </form>
</div>