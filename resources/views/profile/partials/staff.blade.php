@foreach($staffs as $staff)

    @php
        $on_flight = ($staff->driverTransport->isNotEmpty() && $staff->driverTransport->first()->status_id == 6 && $staff->hasRole(\App\Enums\UserRoleEnums::DRIVER)) ? true : false;
    @endphp

    <div class="row flex">
        <div class="flex align-center">
            <div class="content-box__header-avatar"
                 style="background-image: url({{ $staff->getAvatar() ? \Image::getPath('users', $staff->getAvatar()) : url('/img/default-profile.jpg') }})">
            </div>
        </div>
        <div class="col-sm-4 flex align-left panel-client">
            <label class="name inline">{{ $staff->name }}</label>

            @if($on_flight)
                <div class="label label-status label-success">{{ trans('all.on_the_road') }}</div>
            @endif

            {{--
            <div class="editing-tools inline">
                <button data-id="{{$staff->id}}" data-toggle="modal" data-target="#EditEmployee" class="staffEdit edit"></button>
            </div>
            --}}
        </div>
        <div class="col-xs-3">
            <label class="name inline">{{ trans('all.position') }}</label>
            <span class="label-name">
            @if($staff->getRoleName())
                    {{ trans('all.'. $staff->getRoleName() ) }}
            @else
                -
            @endif
            </span>
        </div>
        <div class="col-xs-3 clearfix">
            <label class="name inline">{{ trans('all.contacts') }}</label>
            <span class="label-name">{{ $staff->phone }}</span>
            <span class="label-name">{{ $staff->email }}</span>
        </div>
        <div class="col-xs-2">
            <label class="name inline">{{ trans('all.date_start_working') }}</label>
            <span class="label-name">{{ $staff->meta_data['work_start'] }}</span>
        </div>
        {{-- <div class="col-xs-1">--}}
        {{--     <label for="">{{ trans('all.accesses') }}</label>--}}
        {{--     @if(app_has_access(['staff.access']))--}}
        {{--         <span class="label-name">Login:</span>--}}
        {{--         <span class="label-name">Password:</span>--}}
        {{--     @endif--}}
        {{-- </div>--}}

        @can('logistic')
        <div class="col-xs-1">
            <label class="name inline">{{ trans('all.rate') }}</label>
            <span class="label-name">@if(isset($staff->meta_data['rate'])){{ $staff->meta_data['rate'] }} @else 0 @endif</span>
        </div>

        <div class="col-xs-1">
            <label class="name inline">{{ trans('all.percent') }}</label>
            <span class="label-name">@if(isset($staff->meta_data['percent'])){{ $staff->meta_data['percent'] }} @else 0 @endif</span>
        </div>
        @endcan
        <div class="panel-client">
            <div class="editing-tools flex animated fadeIn">
                {{--@if(app_has_access(['staff.crud']))--}}
                @if(($user->isLogistic() || $user->isAdmin()) && $user->id != $staff->id)
                    <a href="#" class="edit" onclick="staff.edit($(this))" data-staff="{{ json_encode($staff) }}" data-on_flight="{{ json_encode($on_flight) }}"></a>
                @endif
                    @if(!$on_flight && ($user->isLogistic() || $user->isAdmin()) && $user->id != $staff->id)
                    <span class="trash" onclick="removeStaff({{ $staff->id }})" title="{{ trans('all.remove_employee') }}"></span>
                    @endif
                {{--@endif--}}

            </div>
        </div>
    </div>
@endforeach