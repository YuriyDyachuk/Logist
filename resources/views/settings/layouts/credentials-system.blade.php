<h2 class="h2 title-block">{{trans('all.system_gps_control')}}</h2>

<div class="form-group ">
    <div class="col-sm-12 text-right">
        <a href="" id="btn_edit_credentials_open"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('all.edit') }}</a>
        <a href="" id="btn_edit_credentials_close" style="display: none"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('all.hide') }}</a>
    </div>
</div>
<div class="form-group credentials-system">
    <div class="col-sm-3 logo">
        <div class="logo-globus"></div>
    </div>
    <div class="col-sm-4">
        <label for="">{{ trans('all.user_login') }}</label>
        <input type="text" class="form-control user_credentials__input" style="display: none" name="systems[globus][login]" value="{{ $user->credentialsOutside->first()->login ?? '' }}">
        <span class="user_credentials__text">{{$user->credentialsOutside->first()->login ?? trans('all.not_specified')}}</span>
    </div>
    <div class="col-sm-5 user_credentials__input" style="display: none">
        <label for="">{{ trans('all.password') }}</label>
        <input type="text" class="form-control user_credentials__input" name="systems[globus][password]" value="" placeholder="********">
    </div>
    <div class="col-sm-9 col-sm-offset-3" style="margin-top: 10px">
        <label for="">Api key</label>
        <input type="text" class="form-control user_credentials__input" style="display: none;" name="systems[globus][api_key]" value="{{ isset($user->credentialsOutside->first()->api_key) ? decrypt($user->credentialsOutside->first()->api_key) : ''}}">
        <div class="user_credentials__text">{{ isset($user->credentialsOutside->first()->api_key) ? decrypt($user->credentialsOutside->first()->api_key) :  trans('all.not_specified')}}
        </div>
    </div>
</div>

{{--@forelse($user->credentialsOutside as $system)--}}

    {{--<div class="form-group credentials-system">--}}
        {{--<div class="col-sm-3 logo">--}}
            {{--<div class="logo-{{ $system->type }}"></div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-4">--}}
            {{--<label for="">{{ trans('all.user_login') }}</label>--}}
            {{--<input type="text" class="form-control" name="systems[globus][login]" value="{{ $system->login }}">--}}
        {{--</div>--}}
        {{--<div class="col-sm-5">--}}
            {{--<label for="">{{ trans('all.password') }}</label>--}}
            {{--<input type="password" class="form-control" name="systems[globus][password]" placeholder="********">--}}
        {{--</div>--}}
        {{--<div class="col-sm-9 col-sm-offset-3" style="margin-top: 10px">--}}
            {{--<label for="">Api key</label>--}}
            {{--<input type="text" class="form-control" name="systems[globus][api_key]" value="{{ $system->api_key ? decrypt($system->api_key) : ''}}">--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@empty--}}
    {{--<div class="form-group ">--}}
        {{--<div class="col-sm-12 text-right">--}}
            {{--<a href="" id="btn_edit_credentials_open"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> редактировать</a>--}}
            {{--<a href="" id="btn_edit_credentials_close" style="display: none"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> скрыть</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group credentials-system">--}}
        {{--<div class="col-sm-3 logo">--}}
            {{--<div class="logo-globus"></div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-4">--}}
            {{--<label for="">{{ trans('all.user_login') }}</label>--}}
            {{--<input type="text" class="form-control" name="systems[globus][login]" value="">--}}
        {{--</div>--}}
        {{--<div class="col-sm-5">--}}
            {{--<label for="">{{ trans('all.password') }}</label>--}}
            {{--<input type="password" class="form-control" name="systems[globus][password]" placeholder="********">--}}
        {{--</div>--}}
        {{--<div class="col-sm-9 col-sm-offset-3" style="margin-top: 10px">--}}
            {{--<label for="">Api key</label>--}}
            {{--<input type="text" class="form-control" name="systems[globus][api_key]" value="">--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endforelse--}}