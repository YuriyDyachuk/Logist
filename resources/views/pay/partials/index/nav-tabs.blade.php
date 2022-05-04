<ul class="nav nav-tabs" role="tablist">

    <li class="transition{{ \Request::get('tab') == null ? ' active':''   }}">
        <a href="#payment" aria-controls="payment" role="tab"
           data-toggle="tab">{{ trans('all.payment') }}</a>
    </li>

    <li class="transition{{ \Request::get('tab') == 'bills' ?' active':''   }}">
        <a href="#bills" aria-controls="bills" role="tab"
           data-toggle="tab">{{ trans('all.bills') }}</a>
    </li>

    <li class="transition {{ \Request::get('tab') == 'referral' ?' active':''   }}">
        <a href="#referral" aria-controls="referral" role="tab"
           data-toggle="tab">{{ trans('all.referral_program') }}</a>
    </li>
</ul>
