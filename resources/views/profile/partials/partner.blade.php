@foreach($partners as $partner)
    <div class="row flex">
        <div class="flex align-center">
            <div class="content-box__header-avatar"
                 style="background-image: url({{ $partner->getAvatar() ? \Image::getPath('users', $partner->getAvatar()) : url('/img/default-profile.jpg') }})">
            </div>
        </div>
        <div class="col-sm-4 flex panel-client">
            <label class="name inline">{{ trans('all.company') }}</label>
            <div class="label-name">
                <div class="label-name">
                    <a href="{{route('user.profile.company',$partner->id)}}">{{ $partner->name }}</a>
                </div>
            </div>
            {{-- Incoming Request / Outcoming Reguest --}}
            @if($partner->pivot->status_id == 1 && (auth()->id() === $partner->pivot->action_user_id || (auth()->user()->parent_id == $partner->pivot->action_user_id && auth()->user()->isAdmin())))
                {{-- Outcoming Reguest --}}
                <div class="label-name">{{ trans('all.partners_status_'.$partner_statuses[$partner->pivot->status_id]) }}</div>
            @elseif($partner->pivot->status_id == 1 && auth()->id() !== $partner->pivot->action_user_id &&(auth()->id() == $partner->pivot->user_one_id || auth()->id() == $partner->pivot->user_two_id))
                {{-- Incoming Reguest --}}
                <div class="label-name">{{ trans('all.partners_status_received') }}</div>
                <div>
                    <div class="row">
                        <div class="col-xs-12">
                            <span>
                            <a class="btn button-style1 transition" href="{{route('user.partner.notification', ['user_id' => $partner->pivot->action_user_id, 'approved' => 1])}}" >{{ trans('all.confirm') }}</a>
                            </span>
                            <span>
                                <a class="btn button-danger /*button-red*/ transition" href="{{route('user.partner.notification', ['user_id' => $partner->pivot->action_user_id, 'approved' => 0])}}" >{{ trans('all.reject') }}</a>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-xs-3">
            <label class="name inline">{{ trans('all.name') }}</label>
            @if(json_decode(!isset($partner->meta_data['delegate_name'])))
                <div class="label-name">{{ isset($partner->name) ? $partner->name : '' }}</div>
            @endif
                <div class="label-name">{{ isset($partner->meta_data['delegate_name']) ? $partner->meta_data['delegate_name'] : '' }}</div>
        </div>
        <div class="col-xs-3 clearfix">
            <label class="name inline">Email</label>
            <span class="label-name">{{ $partner->email }}</span>
        </div>
        <div class="col-xs-2">
            <label class="name inline">{{ trans('all.phone') }}</label>
            <span class="label-name">{{ $partner->phone ? $partner->phone : trans('all.empty') }}</span>
        </div>
        <div class="panel-client">
            <div class="editing-tools flex animated fadeIn">
                {{-- @if(app_has_access(['staff.crud']))--}}
                    {{--<a href="#" class="edit" onclick="editPartner($(this))"
                        data-partner="{{ json_encode($partner) }}"></a>--}}
                {{--@endif--}}
                @if($user->isLogistic() || $user->isAdmin())
                    <span class="trash" onclick="removePartner({{ $partner->id }})" title="{{ trans('all.remove_employee') }}"></span>
                @endif
            </div>
        </div>
    </div>
@endforeach