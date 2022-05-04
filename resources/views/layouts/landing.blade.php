<?php
/**
 * Layouts landing page template
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.ga')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'inn.logist') }} @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/jquery-eu-cookie-law-popup/css/jquery-eu-cookie-law-popup.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/swiper/dist/css/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('main_layout/css/landing/style.css') }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/manifest.json">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <script type="text/javascript">
        (function(e,t){var n=e.amplitude||{_q:[],_iq:{}};var r=t.createElement("script")
                ;r.type="text/javascript";r.async=true
        ;r.src="https://cdn.amplitude.com/libs/amplitude-4.4.0-min.gz.js"
        ;r.onload=function(){if(e.amplitude.runQueuedFunctions){
            e.amplitude.runQueuedFunctions()}else{
            console.log("[Amplitude] Error: could not load SDK")}}
        ;var i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)
        ;function s(e,t){e.prototype[t]=function(){
            this._q.push([t].concat(Array.prototype.slice.call(arguments,0)));return this}}
            var o=function(){this._q=[];return this}
                    ;var a=["add","append","clearAll","prepend","set","setOnce","unset"]
                    ;for(var u=0;u<a.length;u++){s(o,a[u])}n.Identify=o;var c=function(){this._q=[]
                    ;return this}
                    ;var l=["setProductId","setQuantity","setPrice","setRevenueType","setEventProperties"]
                    ;for(var p=0;p<l.length;p++){s(c,l[p])}n.Revenue=c
            ;var d=["init","logEvent","logRevenue","setUserId","setUserProperties","setOptOut","setVersionName","setDomain","setDeviceId","setGlobalUserProperties","identify","clearUserProperties","setGroup","logRevenueV2","regenerateDeviceId","logEventWithTimestamp","logEventWithGroups","setSessionId","resetSessionId"]
                    ;function v(e){function t(t){e[t]=function(){
                e._q.push([t].concat(Array.prototype.slice.call(arguments,0)))}}
                for(var n=0;n<d.length;n++){t(d[n])}}v(n);n.getInstance=function(e){
                e=(!e||e.length===0?"$default_instance":e).toLowerCase()
                ;if(!n._iq.hasOwnProperty(e)){n._iq[e]={_q:[]};v(n._iq[e])}return n._iq[e]}
            ;e.amplitude=n})(window,document);

        amplitude.getInstance().init("843e100a11e2bc268e869eb1d844719c");
//        amplitude.getInstance().init("e7b290aaf03c2be881ab103528b32787");
    </script>
    @include('layouts.includes.fb-pixel')
</head>
<body data-page="landing">
    @yield('content')

    @include('layouts.includes.cookie-warning');

    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function(){ var widget_id = 'mOhGeIUfDG';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>
    <!-- {/literal} END JIVOSITE CODE -->

    <!-- Scripts -->
    <script type="text/javascript" src="{{ url('bower-components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower-components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower-components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower-components/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower-components/jquery.viewportchecker/dist/jquery.viewportchecker.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower-components/swiper/dist/js/swiper.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/main_layout/js/landing.js') }}"></script>
</body>
</html>
