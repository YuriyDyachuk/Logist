<div class="top-bar transition">
    <div class="header-box">
        <div class="header-box__search transition">
            <div id="sidebar-toggle">
                <div class="transition"><span class="transition"></span><span class="transition"></span><span class="transition"></span>
                </div>
            </div>
            {{--<div class="transition">--}}
                {{--<form name="search">--}}
                    {{--<label for="search-text" onclick="$(this).parent().toggleClass('is-open');"><i class="i-search"></i></label>--}}
                    {{--<input type="text" id="search-text" name="client-search" placeholder="{{ trans('all.search') }}.."--}}
                           {{--class="transition">--}}
                    {{--<input id="client-search" type="submit" name="submit" value="submit" class="hidden">--}}
                {{--</form>--}}
            {{--</div>--}}
        </div>

        <div class="header-box__info-menu">
            <div class="transition">
            @can('logistics')
                <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#selectSubscription">
                    <i class="fa fa-arrow-up"></i> {{trans('all.upgrade')}}
                </button>
            @endcan
            </div>

            <a id="header-box__comment" href="javascript:void 0" class="transition">
                {{--@if(HelperOption::have_notification(1))--}}
                {{--<i class="header-box__notification blink"></i>--}}
                {{--@endif--}}
                <i class="as as-commenting"></i>
            </a>

            <a id="header-box__mail" href="{{ route('mailer.index') }}" class="transition">
                {{--@if(HelperOption::have_notification(2))--}}
                {{--<i class="header-box__notification blink"></i>--}}
                {{--@endif--}}
                <i class="as as-envelope"></i>
            </a>

            {{-- Dropdown BELL --}}
            <ul class="dropdown">
                <a id="header-box__bell" class="dropdown-toggle transition" data-toggle="dropdown"
                   aria-expanded="false" href="javascript:void 0">

                    @if (count(\Auth::user()->unreadNotifications))
                        <i class="header-box__notification blink"></i>
                    @endif
                    <i class="as as-bell"></i>
                </a>

                <ul class="dropdown-menu pull-right list-group notifications" role="menu">
                    <li class="/*list-group-item*/ list-group-header">
                        <div class="list-group-logo i-bell">Notifications</div>
                        <div>
                            @php
                            $i = 1;
                            @endphp
                            <ul>
                                @forelse(\Auth::user()->unreadNotifications as $unreadNotification)
                                    {{--@php--}}
                                        {{--$i++;--}}
                                    {{--@endphp--}}
                                    {{--@if($i<5)--}}
                                    @include('vendor.notifications.' . class_basename($unreadNotification->type ))
                                    {{--@endif--}}
                                @empty
                                    <li class="list-group-item"><a href="#" style="color: #a6a6a6">{{ trans('all.empty_list') }}</a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </li>

                    {{--@forelse(\Auth::user()->unreadNotifications as $unreadNotification)--}}
                        {{--@if(!$unreadNotification->deleted_at)--}}
                            {{--@include('vendor.notifications.' . class_basename($unreadNotification->type ))--}}
                        {{--@endif--}}
                    {{--@empty--}}
                        {{--<li class="list-group-item"><a href="#" style="color: #a6a6a6">{{ trans('all.empty_list') }}</a></li>--}}
                    {{--@endforelse--}}

                </ul>
            </ul>

            <div class="dropdown">
                <ul class="dropdown-toggle langSelector" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="flag">{!! language()->flag() !!}</span>
                </ul>
                <div class="dropdown-menu LangList" aria-labelledby="dropdownMenuButton">
                    @foreach (language()->allowed() as $code => $name)
                        @if(language()->getName() != $name)
                            <a href="{{ language()->back($code) }}">
                            <span class="flag">
                                @include('layouts.includes.flag', ['code' => language()->getCode($name), 'name' => $name])
                            </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Dropdown User --}}
            <ul class="dropdown">
                <a id="header-box__user" class="dropdown-toggle transition" data-toggle="dropdown"
                   aria-expanded="false" href="javascript:void 0">
                    <img class="img-circle" src="{{ app_avatar_url(\Auth::user()->getAvatar()) }}" alt="">
                    <span class="header-box__user">{{ \Auth::user()->name }}<br><span>({{ trans('all.role.'.\Auth::user()->getRoleName()) }})</span></span>
                </a>

                <ul class="dropdown-menu pull-right list-group" role="menu">
                    <li class="list-group-item">
                        <a href="{{route('user.setting')}}"
                           class="transition">
                            <i class="fa fa-cog fa-dropdown-profile" aria-hidden="true"></i>{{trans('all.settings')}}</a>
                    </li>
                    @if(auth()->user()->isLogistic())
                    <li class="list-group-item">
                        <a href="{{route('pay.index')}}"
                           class="transition">
                            <i class="fa fa-money fa-dropdown-profile" aria-hidden="true"></i> {{ trans('all.payment') }}</a>
                    </li>
                    @endif
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }}</form>
                    <li class="list-group-item">
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="transition">
                            <i class="fa fa-sign-out fa-dropdown-profile" aria-hidden="true"></i>{{trans('all.logout')}}
                        </a>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#sidebar-toggle').click(function () {
            $('body').toggleClass('is-collapsed');
            localStorage.setItem('sidebar_collapsed', $('body').hasClass('is-collapsed'));
        })
    </script>
@endpush
