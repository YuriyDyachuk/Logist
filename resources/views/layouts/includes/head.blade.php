<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#ffffff">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

<!-- Favicon section -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ url('/main_layout/images/favicons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-32x32.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ url('/main_layout/images/favicons/favicon-16x16.png') }}" sizes="16x16">
<link rel="manifest" href="{{ url('/main_layout/images/favicons/manifest.json') }}">
<link rel="mask-icon" href="{{ url('/main_layout/images/favicons/safari-pinned-tab.svg') }}" color="#073a85">

<!-- Styles -->
{{--@include('layouts.includes.css_files_old')--}}
@include('layouts.includes.css_files_new')

{{--<link rel="stylesheet" type="text/css" href="{{ url('main_layout/css/response.css') }}">--}}

@stack('styles')

<script>
    var helpers = [];
    window.Laravel = '{{ json_encode([
        'csrfToken' => csrf_token(),
    ]) }}';

    @if(config('amplitude.amplitude_api') !== false)

    (function(e,t){var n=e.amplitude||{_q:[],_iq:{}};var r=t.createElement("script")
    ;r.type="text/javascript"
    ;r.integrity="sha384-+EOJUyXoWkQo2G0XTc+u2DOlZkrMUcc5yOqCuE2XHRnytSyqpFQSbgFZAlGmjpLI"
    ;r.crossOrigin="anonymous";r.async=true
    ;r.src="https://cdn.amplitude.com/libs/amplitude-7.1.1-min.gz.js"
    ;r.onload=function(){if(!e.amplitude.runQueuedFunctions){
        console.log("[Amplitude] Error: could not load SDK")}}
    ;var i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)
    ;function s(e,t){e.prototype[t]=function(){
        this._q.push([t].concat(Array.prototype.slice.call(arguments,0)));return this}}
        var o=function(){this._q=[];return this}
        ;var a=["add","append","clearAll","prepend","set","setOnce","unset"]
        ;for(var c=0;c<a.length;c++){s(o,a[c])}n.Identify=o;var u=function(){this._q=[]
            ;return this}
        ;var l=["setProductId","setQuantity","setPrice","setRevenueType","setEventProperties"]
        ;for(var p=0;p<l.length;p++){s(u,l[p])}n.Revenue=u
        ;var d=["init","logEvent","logRevenue","setUserId","setUserProperties","setOptOut","setVersionName","setDomain","setDeviceId","enableTracking","setGlobalUserProperties","identify","clearUserProperties","setGroup","logRevenueV2","regenerateDeviceId","groupIdentify","onInit","logEventWithTimestamp","logEventWithGroups","setSessionId","resetSessionId"]
        ;function v(e){function t(t){e[t]=function(){
            e._q.push([t].concat(Array.prototype.slice.call(arguments,0)))}}
            for(var n=0;n<d.length;n++){t(d[n])}}v(n);n.getInstance=function(e){
            e=(!e||e.length===0?"$default_instance":e).toLowerCase()
            ;if(!n._iq.hasOwnProperty(e)){n._iq[e]={_q:[]};v(n._iq[e])}return n._iq[e]}
        ;e.amplitude=n})(window,document);

    amplitude.getInstance().init("843e100a11e2bc268e869eb1d844719c");

    @endif
//    amplitude.getInstance().init("e7b290aaf03c2be881ab103528b32787");
</script>