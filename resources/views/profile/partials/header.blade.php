<div class="content-box__header row">
    <div class="content-box__type-profile col-xs-12">
        <h5 class="h5 title-grey">
            @if(isset($user->meta_data['type']))
                {{ trans('all.company_type_'.$user->meta_data['type']) }}
            @else
                {{ $user->getRoleName() }}
            @endif
        </h5>
    </div>
    <div class="content-box__title col-xs-7">
        <div class="content-box__header-avatar" style="background-image: url({{ app_avatar_url($user->getAvatar()) }})">
        </div>
        <div>
            <h1 class="h1 title-company-name">{{$user->name}}</h1>
            @if(request('id'))
                <div class="row">
                    <div class="company-rating">
                        <div class="col-sm-4" style="display: flex">
                            <span class="glyphicon glyphicon-star @if($testimonials_rating >= 1) checked @endif" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-star @if($testimonials_rating >= 2) checked @endif" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-star @if($testimonials_rating >= 3) checked @endif" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-star @if($testimonials_rating >= 4) checked @endif" aria-hidden="true"></span>
                            <span class="glyphicon glyphicon-star @if($testimonials_rating >= 5) checked @endif" aria-hidden="true"></span>

                            {{--                        <span class="fa fa-star{{ $testimonials_rating <= 0 ? '-o' : '' }}" aria-hidden="false"></span><!-- First case is for 0 and 1 case or empty and filled star -->--}}
                            {{--                        <span class="fa fa-star{{ $testimonials_rating >= 2 ? '-o' : '' }}" aria-hidden="false"></span>--}}
                            {{--                        <span class="fa fa-star{{ $testimonials_rating >= 3 ? '-o' : '' }}" aria-hidden="false"></span>--}}
                            {{--                        <span class="fa fa-star{{ $testimonials_rating >= 4 ? '-o' : '' }}" aria-hidden="false"></span>--}}
                            {{--                        <span class="fa fa-star{{ $testimonials_rating >= 5 ? '-o' : '' }}" aria-hidden="false"></span>--}}
                        </div>
                        <div class="col-sm-8 rating-company">
                            {{ $testimonials_rating .' '. \App\Models\Transport\Testimonial::number($testimonials_rating, ['рекомендация', 'рекомендации', 'рекомендаций']) }}
                        </div>
                    </div>
                </div>
            @endif
            <label class="site-url">
                {{trans('all.site')}}
                @if(isset($resCompany->site_url) && filter_var($resCompany->site_url, FILTER_VALIDATE_URL) !== FALSE)
                    <a href="{{ $resCompany->site_url}}">{{ $resCompany->site_url}}</a>
                @else
                    -
                @endif
            </label>
        </div>
    </div>

    @if(request('id') == null)
    @can('create-staff')
        <div class="header-tools col-xs-5">
            {{--<a href="javascript://" class="btn btn-info btn-lg button-green transition" disabled>--}}
                {{--<i class="as as-branch"></i>--}}
                {{--<span>{{ trans('profile.add_affiliate') }}</span>--}}
                {{--<span class="hidden">филиал</span>--}}
            {{--</a>--}}
            {{--<a href="javascript://" class="btn btn-info btn-lg button-green transition" disabled>--}}
                {{--<i class="as as-department"></i>--}}
                {{--<span>{{ trans('profile.add_department') }}</span>--}}
                {{--<span class="hidden">отдел</span>--}}
            {{--</a>--}}
                <button type="button" class="btn button-block transition" disabled>
                    <span class="glyphicon glyphicon-lock" aria-hidden="true" style="margin-bottom: 10px;"></span>
                    {{ trans('profile.add_affiliate') }}
                </button>
                <button type="button" class="btn button-block transition" disabled>
                    <span class="glyphicon glyphicon-lock" aria-hidden="true" style="margin-bottom: 10px;"></span>
                    {{ trans('profile.add_department') }}
                </button>
                <button type="button" class="btn button-style1 transition" data-toggle="modal"
                        data-target="#addEmployee" id="linkAddEmployee">
                    <i class="as as-addclient"></i>
                    {{ trans('profile.add_employee') }}
                </button>
                @if(checkPaymentAccess('partners'))
                <button type="button" class="btn button-style1 transition" data-toggle="modal"
                        data-target="#addPartner">
                    <i class="as as-addclient"></i>
                    {{ trans('profile.add_partner') }}
                </button>
                @else
                <button type="button" class="btn button-block transition" disabled>
                    <span class="glyphicon glyphicon-lock" aria-hidden="true" style="margin-bottom: 10px;"></span>
                    <span>{{ trans('profile.add_partner') }}</span>
                </button>
                @endif
        </div>
    @endcan
    @else
        <div class="content-box template-page col-xs-5" id="button-back" style="padding: 0;min-height: 0;">
            <div class="container-fluid btn-header">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <?php $tab = '#partners' ?>
                        <a class="btn button-cancel" id="templates" href="{{route('user.profile') . $tab}}">
                            {{trans('all.back_to_partners')}}
                            <i>&times;</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>