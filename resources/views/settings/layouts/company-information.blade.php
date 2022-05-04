{{-- COMPANY NAME --}}


    <div class="form-group{{ ($errors->has('name') || isset($userData['new_name'])) ? ' has-error' : '' }}">
        <label class="control-label col-sm-4">{{trans('all.company_name')}}</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            @if ($errors->has('name'))
                <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong></span> @endif
            @if (isset($userData['new_name']))
                <span class="help-block"><strong>{{trans('all.data_not_accepted')}}</strong></span>
            @endif
        </div>
    </div>



{{-- EGRPOU or INN --}}
<div class="form-group{{ ($errors->has('egrpou_or_inn') || isset($userData['new_egrpou_or_inn'])) ? ' has-error' : '' }}">
    <label class="control-label col-sm-4">{{trans('all.egrpou_or_inn')}}</label>
    <div class="col-sm-8">
        <input type="text" name="egrpou_or_inn" class="form-control"
               value="@if(isset($user->meta_data['egrpou_or_inn']) || isset($userData['new_egrpou_or_inn'])){{ $user->meta_data['egrpou_or_inn'] or $userData['new_egrpou_or_inn'] }}@endif">

        @if ($errors->has('egrpou_or_inn'))
            <span class="help-block">
                <strong>{{ $errors->first('egrpou_or_inn') }}</strong></span>@endif

        @if (isset($userData['new_egrpou_or_inn']))
            <span class="help-block"><strong>{{trans('all.data_not_accepted')}}</strong></span>
        @endif
    </div>
</div>

{{-- DELEGATE NAME --}}
<div class="form-group{{ $errors->has('delegate_name') || isset($userData['new_delegate_name']) ? ' has-error' : '' }}">
    <label class="control-label col-sm-4">{{trans('all.name')}}</label>
    <div class="col-sm-8">
        <input type="text" name="delegate_name" class="form-control"
               value="@if(isset($user->meta_data['delegate_name']) || isset($userData['new_delegate_name'])){{$user->meta_data['delegate_name'] or $userData['new_delegate_name']}}@endif">

        @if ($errors->has('delegate_name'))
            <span class="help-block"><strong>{{ $errors->first('delegate_name') }}</strong></span>
        @endif

        @if (isset($userData['new_delegate_name']))
            <span class="help-block"><strong>{{trans('all.data_not_accepted')}}</strong></span>
        @endif
    </div>
</div>
