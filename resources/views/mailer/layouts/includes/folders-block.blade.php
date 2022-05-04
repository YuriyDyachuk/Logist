<div class="col-xs-12 col-md-3" style="min-height: 100%">
    <strong>
        {{ trans('mailer.folders') }} :
    </strong>

    <div class="list-group">
        @include('mailer.layouts.includes.folders', ['folders' => $folders])
    </div>
</div>