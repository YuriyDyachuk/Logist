<!-- Left navigation: BEGIN -->
<div class="sidebar-logo header-box__logo">
    <a href="{{route('orders')}}" class="brand-logo transition" title="{{ __('all.home_link')}}"></a>
</div>

<ul id="office-nav">
    @if(user_current_can('profile'))
        <li class="transition{{ \Request::is('profile') ? ' active' : '' }}">
            <a href="{{route('user.profile')}}" class="transition">
                <i class="as as-mycompany"></i>
                {{ \Auth::user()->hasRole('logistic-company') ? __('all.my_company') : __('all.my_profile') }}
            </a>
        </li>
    @endif

    @if(user_current_can('orders'))
        <li class="transition{{ \Request::is('order*') ? ' active' : '' }}">
            <a href="{{ route('orders') }}" class="transition">
                <i class="as as-request"></i>
                {{ __('all.orders') }}
            </a>
        </li>
    @endif

    @if(user_current_can('clients'))
        <li class="transition{{ \Request::is('clients') ? ' active' : '' }}">
            <a href="{{ url('/clients') }}" class="transition">
                <i class="as as-clients"></i>
                {{ __('all.clients') }}
            </a>
        </li>
    @endif

    @if(user_current_can('transport'))
        <li class="transition{{ \Request::is('transport*') ? ' active' : '' }}">
            <a href="{{ route('transport.index') }}" class="transition">
                <i class="as as-transport"></i>
                {{ __('all.transport') }}
            </a>
        </li>
    @endif

    @if(user_current_can('location'))
        <li class="transition{{ \Request::is('location') ? ' active' : '' }}">
            <a href="{{ route('location.index') }}" class="transition">
                <i class="as as-positions"></i>
                {{ __('all.location') }}
            </a>
        </li>
    @endif

    @if(user_current_can('analytics'))
        <li class="transition{{ \Request::is('analytics') ? ' active' : '' }}">
            <a href="{{ url('analytics') }}" class="transition">
                <i class="as as-analitic"></i>
                {{ __('all.analytics') }}
            </a>
        </li>
    @endif

    @if(user_current_can('documents'))
        <li class="transition{{ \Request::is('documents-list') ? ' active' : '' }}">
            <a href="{{ url('documents-list') }}" class="transition">
                <i class="icon document"></i>
                {{ __('all.documents') }}
            </a>
        </li>
    @endif

    @if(user_current_can('finance'))
        <li class="transition{{ \Request::is('finance') ? ' active' : '' }}">
            <a href="{{ url('finance') }}" class="transition">
                <i class="icon finance"></i>
                {{ __('all.finance') }}
            </a>
        </li>
    @endif

    @if(user_current_can('mailer'))
        <li class="transition{{ \Request::is('mailer') ? ' active' : '' }}">
            <a href="{{ route('mailer.index') }}" class="transition">
                <i class="as as-telephone"></i>
                    {{ __('all.mailer') }}
                </a>
        </li>
    @endif

    <li class="transition sidebar-path">
        <span>{{ trans('all.help') }}</span>
    </li>

    <li class="transition faq-item">
        <a href="{{ url('/faq') }}" class="transition faq-tooltip" data-title="{{trans('all.FAQs')}}"
           data-body="{{trans('tooltips.faq')}}">
            <i class="as as-question"></i>
            FAQs
        </a>
    </li>

    <li class="transition{{ \Request::is('contacts') ? ' active' : '' }}">
        <a href="{{ url('/contacts') }}" class="transition">
            <i class="as as-telephone"></i>
            {{ __('all.contacts') }}
        </a>
    </li>

    <li class="transition{{ \Request::is('improve') ? ' active' : '' }}">
        <a href="{{ url('/improve') }}" class="transition">
            <i class="as as-handshake"></i>
            {{ __('all.improve_system') }}
        </a>
    </li>
</ul>
<!-- Left navigation: AND -->
