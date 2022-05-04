{{--<ul class="nav nav-tabs" role="tablist">--}}

    {{--<li class="transition{{ \Request::get('tab') == null ? ' active':''   }}">--}}
        {{--<a href="#documents" aria-controls="documents" role="tab"--}}
           {{--data-toggle="tab">{{ trans('all.documents') }}</a>--}}
    {{--</li>--}}

    {{--<li class="transition{{ \Request::get('tab') == 'templates' ?' active':''   }}">--}}
        {{--<a href="#templates" aria-controls="templates" role="tab"--}}
           {{--data-toggle="tab">{{ trans('all.templates') }}</a>--}}
    {{--</li>--}}
{{--</ul>--}}

<div class="content-box__nav">
    <div class="row">
        <div class="content-box__tabs col-xs-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
                <li role="presentation" class="{{ \Request::get('tab') == null ? ' active':''   }} transition"><a href="#documents" role="tab" data-toggle="tab">{{ trans('all.documents') }}</a></li>
                <li role="presentation" class="transition {{ \Request::get('tab') == 'templates' ? ' active':''   }}"><a href="#templates" id="s" role="tab" data-is="is" data-toggle="tab">{{ trans('all.templates') }}</a></li>
            </ul>
        </div>
    </div>
    {{--<div class="clearfix"></div>--}}
</div>
