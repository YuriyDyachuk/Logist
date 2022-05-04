<div class="content-box__header">
    <div class="content-box__type-profile">
        {{--<h5 class="h5 title-grey">{{ $user->getRoleName() }}</h5>--}}
        @if(profile_filled() === true )
        <h5 class="h5 title-grey">{{ trans('all.company_type_'.$user->meta_data['type']) }}</h5>
        @endif
    </div>
    <div class="content-box__title">
        <div class="content-box__header-avatar"
             style="background-image: url({{ $user->getAvatar() ? \Image::getPath('users', $user->getAvatar()) : url('/img/default-profile.jpg') }})"></div>
        <div>
            <h1 class="h1 title-company-name">{{$user->name}}</h1>
            {{--<p class="rating">--}}
                {{--<label for="stars0"></label>--}}
                {{--<label for="stars4"></label>--}}
                {{--<span>(34 рекомендации)</span>--}}
            {{--</p>--}}
        </div>
    </div>

    {{--<div class="content-box__add-rais">--}}
        {{--<a href="{{ route('order.create') }}" class="btn btn-info btn-lg button-green transition"--}}
           {{--loader-body>--}}
            {{--<i class="as as-adddocument"></i>--}}
            {{--{{ trans('all.create_new_order') }}--}}
        {{--</a>--}}
    {{--</div>--}}

</div>
