@if($user->isLogist() || $user->isLogistic())
    <div class="form-group form-group_separator user_info__input" @if(profile_filled()) style="display: none;" @endif>
        <div class="col-sm-12"></div>
    </div>
    <div class="form-group">
        <label data-notice="" class="control-label col-sm-4">{{trans('all.deviation_notification')}}</label>
        <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
            <select id="deviation_notification" name="deviation_notification" class="selectpicker" data-live-search="false" title="{{trans('all.deviation_notification')}}" autocomplete="off">
                <option value="1" @if(isset($user->meta_data['deviation_notification']) && (int) $user->meta_data['deviation_notification'] === 1) selected @endif>
                    {{ trans('all.enabled') }}
                </option>

                <option value="0" @if(isset($user->meta_data['deviation_notification']) && (int) $user->meta_data['deviation_notification'] === 0) selected @endif>
                    {{ trans('all.disabled') }}
                </option>
            </select>
        </div>
        <div class="col-sm-8 user_info__text" @if(!profile_filled())) style="display: none;" @endif>
            {{ isset($user->meta_data['deviation_notification']) && (int) $user->meta_data['deviation_notification'] === 1 ? trans('all.enabled') : trans('all.disabled')}}
        </div>
    </div>
    <div class="form-group">
        <label data-notice="" class="control-label col-sm-4">{{trans('all.deviation_distance')}}, {{ trans('all.m') }}</label>
        <div class="col-sm-8 user_info__input" @if(profile_filled()) style="display: none;" @endif>
            <input type="number" name="deviation_distance" class="form-control" step="0.001" id="deviation_distance" value="{{ $user->meta_data['deviation_distance'] ?? '' }}" autocomplete="off" placeholder="{{trans('all.deviation_distance')}}">
        </div>
        <div class="col-sm-8 user_info__text" @if(!profile_filled())) style="display: none;" @endif>
            @if(isset($user->meta_data['deviation_notification']) && (int) $user->meta_data['deviation_notification'] === 1)
                {{ $user->meta_data['deviation_distance'] }} {{ trans('all.m') }}
            @else
                {{ trans('all.disabled') }}
            @endif
        </div>
    </div>
@endif
