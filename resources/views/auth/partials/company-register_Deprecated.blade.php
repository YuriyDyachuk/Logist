<div class="">
    <form class="col-sm-12 register-form" method="POST" action="{{ route('register') }}">
        <input type="hidden" name="social_type"
               value="@if (isset($data['provider'])){{$data['provider']}}@else{{ old('social_type') }}@endif">
        <input type="hidden" name="social_id"
               value="@if (isset($data)){{$data['user']->id}}@else{{ old('social_id') }}@endif">

        {{ csrf_field() }}
        <input type="hidden" name="role" value="{{$account}}-company">

        <div class="content-box__body">
            <div class="content-box__body-field">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="{{trans('all.email_address')}}"
                           value="@if (isset($data['user']->email)){{$data['user']->email}}@else{{ old('email') }}@endif">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" class="form-control" type="password" name="password" placeholder="{{trans('all.password')}}">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                {{--
                <div class="form-group">
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="{{trans('all.password_confirm')}}">
                </div>
                --}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" name="name" class="form-control" placeholder="{{trans('all.company_name')}}"
                           value="{{ $data['user']->data->companyName ?? old('name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                {{--
                <div class="form-group{{ $errors->has('egrpou_or_inn') ? ' has-error' : '' }}">
                    <input type="text" name="egrpou_or_inn" class="form-control" value="{{ old('egrpou_or_inn') }}" placeholder="{{trans('all.egrpou_or_inn')}}">

                    @if ($errors->has('egrpou_or_inn'))
                        <span class="help-block">
                            <strong>{{ $errors->first('egrpou_or_inn') }}</strong>
                        </span>
                    @endif
                </div>
                --}}

                <div class="form-group{{ $errors->has('delegate_name') ? ' has-error' : '' }}">
                    <input type="text" name="delegate_name" class="form-control" placeholder="{{trans('all.name')}}"
                           value="{{ $data['user']->name ?? old('delegate_name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('delegate_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input type="tel" name="phone" id="phone1" class="phone_1 form-control" placeholder="{{trans('all.phone_user')}}"
                           value="{{ $data['user']->data->phone1 ?? str_replace(' ', '',old('phone'))}}">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                    <div class="g-recaptcha" data-sitekey="{{config('captcha.google_recaptcha_flag_key')}}" data-callback="recaptchaCallbackC">
                    </div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block"><strong>{{ $errors->first('g-recaptcha-response') }}</strong></span>
                    @endif
                </div>
            </div>

            <div class="form-group col-xs-12 text-center content-box__body-submit">
                <button id="submitC"  type="submit" name="submitCompany" class="btn button-green btn-block transition" value="submit" disabled>
                    {{ trans('all.register') }} <span class="arrow-right"></span>
                </button>
            </div>
        </div>



        <div class="col-xs-12 col-xs-offset-1">
            <div class="license {{ $errors->has('license') ? ' has-error' : '' }}">
                <input type="checkbox" name="license" id="agreement_company1" class="form-control" value="on">
                <label for="agreement_company1">
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

    </form>
</div>