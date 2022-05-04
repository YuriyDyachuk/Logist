<!-- Tab navigation: BEGIN -->
<ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
    <li class="transition init-map{{ \Request::get('tab') != 'transport' ?' active':''   }}">
        <a href="#info" aria-controls="info" role="tab"
           data-toggle="tab">{{ trans('all.general_information') }}</a>
    </li>

    @if($userIsLogistic)
    <li class="transition{{ \Request::get('tab') == 'transport' ?' active':''   }}">
        <a href="#transport" aria-controls="transport" role="tab"
           data-toggle="tab">{{ trans('all.about_transport') }}</a>
    </li>
    @endif

    <li class="transition">
        <a href="#payment" aria-controls="payment" role="tab"
           data-toggle="tab">{{ trans('all.about_payment') }}</a>
    </li>

    <li class="transition">
        <a href="#documents" aria-controls="documents" role="tab"
           data-toggle="tab">{{ trans('all.documents') }}</a>
    </li>

    @if($userIsLogistic)
    <li class="transition">
        <a href="#progress" aria-controls="progress" role="tab"
           data-toggle="tab">{{ trans('all.progress') }}</a>
    </li>
    <li class="transition">
        <a href="#history" aria-controls="history" role="tab"
           data-toggle="tab">{{ trans('all.history') }}</a>
    </li>
    @endif
</ul>
<!-- Tab navigation: END -->
