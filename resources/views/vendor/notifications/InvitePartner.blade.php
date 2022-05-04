<li class="list-group-item" data-notification="{{$unreadNotification->id}}">
    <div class="row" style="padding: 15px; margin: auto">
        <div class="col-md-12">
{{--            <a href="{{ route('user.profile.company',App\Models\User::find($unreadNotification->data['user_invite'])->id) }}">--}}
                {{ trans('notification.partners_offer_income', ['Name' => \App\Models\User::find($unreadNotification->data['user_invite'])->name]) }}
{{--            </a>--}}
        </div>
        <div class="col-md-12 flex">
            <a class="btn-danger btn-lg button-red transition btn-notification" href="{{ route('user.partner.notification',
            ['user_id' => $unreadNotification->data['user_invite'], 'approved' => 0] ) }} "role="button" data-notification="{{ $unreadNotification->id }}">
                {{ trans('all.reject') }}
            </a>

            <a class="btn-success btn-lg button-green transition btn-notification" href="{{ route('user.partner.notification',
            ['user_id' => $unreadNotification->data['user_invite'], 'approved' => 1] ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
                {{ trans('all.confirm') }}
            </a>
        </div>
    </div>
</li>