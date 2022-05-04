<div class="content-box__header row">
    <div class="content-box__title col-xs-7">
        <h5 class="h5 title-grey">
            {{ trans('all.profile_employee') }}
        </h5>
        <div class="content-box__header-avatar" style="margin-top: 0;background-image: url({{ app_avatar_url($user->getAvatar()) }})">
        </div>
        <div class="user-content">
            <h1 class="h1 title-company-name">{{$user->name}}</h1>

            <div class="phone-title">
                <span class="font">{{ trans('all.phone') }}</span>
                <span>{{$user->phone}}</span>
            </div>
            <div class="email-title">
                <span class="font">{{ trans('all.email') }}</span>
                <span>{{$user->email}}</span>
            </div>
        </div>
    </div>


    <div class="header-tools col-xs-5 mail-block" id="class">
        <div class="logo_email">
        </div>
        <div class="titles-header-mail">
            <span><strong>{{trans('all.hello_day')}}, {{$user->name}}!</strong></span>
            <span>У тебя 4 уведомления и 5 непрочитанных сообщений.</span>
        </div>
    </div>

</div>