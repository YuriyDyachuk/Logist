<input type="hidden" name="type" value="individual">
<input type="hidden" name="check" value="0">

{{--@if ($errors->any())--}}
    {{--<div class="alert alert-danger">--}}
        {{--<ul>--}}
            {{--@foreach ($errors->all() as $error)--}}
                {{--<li>{{ $error }}</li>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--</div>--}}
{{--@endif--}}

{{-- Name --}}
<div class="form-group ">
    <label class="control-label col-sm-4">{{trans('all.name')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <input type="text" name="name" class="form-control" value="{{ $user->name ?? ''}}" autocomplete="off" placeholder="{{trans('all.name')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled()) style="display: none;" @endif>
        {{ $user->name ?? ''}}
    </div>
</div>

{{-- PHONE --}}
<div class="form-group">
    <label class="control-label col-sm-4">{{trans('all.phone')}}</label>
    <div class="col-sm-8 user_info__input" @if(isset($user->meta_data['type'])) style="display: none;" @endif>
        <input type="tel" name="phone" id="phone" class="form-control phone" value="{{ $user->phone ?? '' }}" autocomplete="off" placeholder="{{trans('all.phone')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!isset($user->meta_data['type'])) style="display: none;" @endif>
        {{ $user->phone ?? ''}}
    </div>
</div>

{{-- EMAIL --}}
<div class="form-group">
    <label data-notice="" class="control-label col-sm-4">{{trans('all.email_address')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" autocomplete="off" placeholder="{{trans('all.email_address')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled())) style="display: none;" @endif>
        {{ $user->email ?? ''}}
    </div>
</div>
@include('settings.layouts.deviation-block')

{{-- ADDRESS --}}

<div class="form-group form-group_separator user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <div class="col-sm-12"></div>
</div>

<div class="form-group user_info__text" @if(!profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{ trans('all.address') }}</label>
    <div class="col-sm-8">

        @if(isset($user->meta_data['address_index']))
            {{$user->meta_data['address_index']}},
        @endif

        @if(isset($user->meta_data['address_country_code']))
            {{(new App\Services\GeographerService)->getCountryByCode($user->meta_data['address_country_code'])->name}},
        @endif

        @if(isset($user->meta_data['address_region_code']))
                {{(new App\Services\GeographerService)->getStateByCode($user->meta_data['address_region_code'])->name}},
        @endif

        @if(isset($user->meta_data['address_city_code']))
                {{(new App\Services\GeographerService)->getCityByCode($user->meta_data['address_city_code'])->name}},
        @endif

        @if(isset($user->meta_data['address_street']))
            {{$user->meta_data['address_street']}},
        @endif

        @if(isset($user->meta_data['address_number']))
            {{$user->meta_data['address_number']}}
        @endif

    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.country')}}</label>
    <div class="col-sm-8">
        {{--<input type="text" name="address_country" class="form-control" value="{{ $user->meta_data['address_country'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.country')}}">--}}
        <select id="address_country" name="address_country" class="selectpicker" data-live-search="true" title="{{trans('all.country')}}" autocomplete="off">
            @foreach($address['countries'] as $item)
                @if($item->code == 'UA')
                    <option value="{{ $item->code }}" @if(isset($user->meta_data['address_country_code']) && $user->meta_data['address_country_code'] == $item->code) selected @endif style="font-weight: bold">{{ $item->name }}</option>
                @endif
            @endforeach

            @foreach($address['countries'] as $item)
                @if($item->code == 'RU')
                <option value="{{ $item->code }}" @if(isset($user->meta_data['address_country_code']) && $user->meta_data['address_country_code'] == $item->code) selected @endif style="font-weight: bold">{{ $item->name }}</option>
                @endif
            @endforeach

            @foreach($address['countries'] as $item)
            @if($item->code != 'RU' || $item->code != 'UA')
                <option value="{{ $item->code }}" @if(isset($user->meta_data['address_country_code']) && $user->meta_data['address_country_code'] == $item->code) selected @endif>{{ $item->name }}</option>
            @endif
            @endforeach
        </select>
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.region')}}</label>
    <div class="col-sm-8">
        {{--<input type="text" name="address_region" class="form-control" value="{{ $user->meta_data['address_region'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.region')}}">--}}
        <select id="address_region" name="address_region" class="selectpicker" data-live-search="true" title="{{trans('all.region')}}" autocomplete="off">
            @if(isset($user->meta_data['address_region_code']))
                @foreach($address['regions'] as $item)
                    <option value="{{ $item['code'] }}" @if($user->meta_data['address_region_code'] == $item['code']) selected @endif> {{$item['name']}} </option>
                @endforeach
            @endif
        </select>
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.city')}}</label>
    <div class="col-sm-8">
        {{--<input type="text" name="address_city" class="form-control" value="{{ $user->meta_data['address_city'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.city')}}">--}}
        <select id="address_city" name="address_city" class="selectpicker address_city" data-live-search="true" title="{{trans('all.city')}}" autocomplete="off">
                @if(isset($user->meta_data['address_city_code']))
                    @foreach($address['cities'] as $item)
                        <option value="{{ $item['code'] }}" @if($user->meta_data['address_city_code'] == $item['code']) selected @endif> {{$item['name']}} </option>
                    @endforeach
                @endif
        </select>
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.index')}}</label>
    <div class="col-sm-8">
        <input type="text" name="address_index" class="form-control" value="{{ $user->meta_data['address_index'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.index')}}">
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.street')}}</label>
    <div class="col-sm-8">
        <input type="text" name="address_street" class="form-control" value="{{ $user->meta_data['address_street'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.street')}}">
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <label class="control-label col-sm-4">{{trans('all.address_number')}}</label>
    <div class="col-sm-8">
        <input type="text" name="address_number" class="form-control" value="{{ $user->meta_data['address_number'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.address_number')}}">
        <span class="help-block"></span>
    </div>
</div>

<div class="form-group form-group_separator user_info__input" @if(profile_filled()) style="display: none;" @endif>
    <div class="col-sm-12"></div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">{{trans('all.payment_account')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <input type="text" name="payment_account" class="form-control" value="{{ $user->meta_data['payment_account'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.payment_account')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled()) style="display: none;" @endif>
        {{ $user->meta_data['payment_account'] ?? ''}}
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">{{trans('all.inn')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <input type="text" name="inn" class="form-control" value="{{ $user->meta_data['inn'] ?? ''}}" autocomplete="off" placeholder="{{trans('all.inn')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled()) style="display: none;" @endif>
        {{ $user->meta_data['inn'] ?? ''}}
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">{{trans('all.site_url')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <input id="site_url" type="text" name="site_url" class="form-control"
               value="{{$user->meta_data['site_url'] ?? ''}}" placeholder="{{trans('all.site_url')}}">
        <span class="help-block"></span>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled()) style="display: none;" @endif>
        @if(isset($user->meta_data['site_url']) && filter_var($user->meta_data['site_url'], FILTER_VALIDATE_URL) !== FALSE)
            <a href="{{ $user->meta_data['site_url']}}" target="_blank">{{ $user->meta_data['site_url']}}</a>
        @else
            {{ $user->meta_data['site_url'] ?? ''}}
        @endif
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">{{trans('all.company_description')}}</label>
    <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
                    <textarea id="company_description"
                              rows="6"
                              style="resize: none"
                              type="text"
                              name="description"
                              class="form-control">{{$user->meta_data['description'] ?? ''}}</textarea>
    </div>
    <div class="col-sm-8 user_info__text" @if(!profile_filled()) style="display: none;" @endif>
        {{ $user->meta_data['description'] ?? ''}}
    </div>
</div>