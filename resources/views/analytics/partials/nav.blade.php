<?php $panel = 'companies'; //default
    if(Request::segment(2)){
        $panel = Request::segment(2);
    }
?>

{{--<div class="content-box__body">--}}
    <div class="content-box__body-tabs" data-class="dragscroll">
        <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
            <li class="@if($panel == 'companies') active @endif transition">
                <a href="{{url('analytics')}}" data-url="redirect" class="">{{ trans('all.analytics_by_company') }}</a>
            </li>
            <li class="transition @if($panel == 'deals') active @endif">
                <a href="{{url('analytics/deals')}}" data-url="redirect" class="">{{ trans('all.analytics_by_deals') }}</a>
            </li>
            <li class="transition @if($panel == 'logistics') active @endif">
                <a href="{{url('analytics/logistics')}}" data-url="redirect" class="">{{ trans('all.analytics_by_logists') }}</a>
            </li>
            <li class="transition @if($panel == 'drivers') active @endif">
                <a href="{{url('analytics/drivers')}}" data-url="redirect" class="">{{ trans('all.analytics_by_drivers') }}</a>
            </li>
            <li class="transition @if($panel == 'transport') active @endif">
                <a href="{{route('analytics.transport')}}" data-url="redirect" class="">{{ trans('all.analytics_by_transport') }}</a>
            </li>
            <li class="transition @if($panel == 'clients') active @endif">
                <a href="{{url('analytics/clients')}}" data-url="redirect" class="grey" onclick="event.preventDefault();">{{ trans('all.analytics_by_clients') }}</a>
            </li>
            <li class="transition @if($panel == 'finances') active @endif">
                <a href="{{url('analytics/finances')}}" data-url="redirect" class="grey" onclick="event.preventDefault();">{{ trans('all.analytics_by_financials') }}</a>
            </li>
        </ul>
    </div>
{{--</div>--}}

{{--<div class="content-box__nav">--}}
    {{--<div class="row">--}}
        {{--<div class="content-box__tabs col-xs-12">--}}
            {{--<!-- Nav tabs -->--}}
            {{--<ul class="nav nav-tabs tablist transition" id="rowTab">--}}
                {{--<li class="@if($panel == 'companies') active @endif transition">--}}
                    {{--<a href="{{url('analytics')}}" data-url="redirect" class="">{{ trans('all.by_company') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'deals') active @endif">--}}
                    {{--<a href="{{url('analytics/deals')}}" data-url="redirect" class="">{{ trans('all.by_deals') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'logistics') active @endif">--}}
                    {{--<a href="{{url('analytics/logistics')}}" data-url="redirect" class="">{{ trans('all.by_logists') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'drivers') active @endif">--}}
                    {{--<a href="{{url('analytics/drivers')}}" data-url="redirect" class="">{{ trans('all.by_drivers') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'clients') active @endif">--}}
                    {{--<a href="{{url('analytics/clients')}}" data-url="redirect" class="grey" onclick="event.preventDefault();">{{ trans('all.by_clients') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'finances') active @endif">--}}
                    {{--<a href="{{url('analytics/finances')}}" data-url="redirect" class="grey" onclick="event.preventDefault();">{{ trans('all.by_financials') }}</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="clearfix"></div>--}}
{{--</div>--}}

{{--<div class="content-box__filter page-menu-filter-nav">--}}
    {{--<div class="row">--}}
        {{--<div class="content-box__body-tabs col-xs-12">--}}
            {{--<ul class="nav nav-tabs transition" id="rowTab_analytics" style="background-color: #FFF;">--}}
                {{--<li class="transition @if($panel == 'companies') active @endif">--}}
                    {{--<a href="/analytics/" class="ajax-tab">{{ trans('all.by_company') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'deals') active @endif">--}}
                    {{--<a href="/analytics/deals">{{ trans('all.by_deals') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'logistics') active @endif">--}}
                    {{--<a href="/analytics/logistics" class="ajax-tab">{{ trans('all.by_logists') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'drivers') active @endif">--}}
                    {{--<a href="/analytics/drivers" class="ajax-tab">{{ trans('all.by_drivers') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'clients') active @endif">--}}
                    {{--<a href="/analytics/clients" class="ajax-tab grey" onclick="event.preventDefault();">{{ trans('all.by_clients') }}</a>--}}
                {{--</li>--}}
                {{--<li class="transition @if($panel == 'finances') active @endif">--}}
                    {{--<a href="/analytics/finances" class="ajax-tab grey" onclick="event.preventDefault();">{{ trans('all.by_financials') }}</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="clearfix"></div>--}}
{{--</div>--}}