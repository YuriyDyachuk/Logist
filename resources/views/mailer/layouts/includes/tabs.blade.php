<div class="content-box__header clearfix">
    <div class="content-box__title">
        <h1 class="title-blue">{{trans('all.mailer')}}</h1>
    </div>
</div>

<div class="content-box__body-tabs" data-class="dragscroll">
    <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
        <li class="{{ \Request::get('tab') === null ? ' active':''}} transition"><a href="#message" role="tab" data-toggle="tab">{{trans('mailer.message')}}</a></li>
    </ul>
</div>