<ul class="nav nav-tabs" role="tablist">

    <li class="transition{{ \Request::get('tab') == null ? ' active':''   }}">
        <a href="#instructions" aria-controls="instructions" role="tab"
           data-toggle="tab">{{ trans('all.user_instructions') }}</a>
    </li>

    <li class="transition{{ \Request::get('tab') == 'faqs' ?' active':''   }}">
        <a href="#faqs" aria-controls="faqs" role="tab"
           data-toggle="tab">{{ trans('all.FAQs') }}</a>
    </li>
</ul>
