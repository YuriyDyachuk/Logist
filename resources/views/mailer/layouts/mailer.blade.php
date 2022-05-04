<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') === null ? ' active in':''   }}" id="mailer">
    <div class="content-box__body">
        @if ($incomeMailClient->connection !== false)
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <strong>
                        {{ trans('mailer.folders') }} :
                    </strong>

                    <div class="list-group">
                        @include('mailer.layouts.includes.folders', ['folders' => $folders])
                    </div>
                </div>
                <div class="col-xs-12 col-md-9" id="mail-table">
                    @include('mailer.layouts.includes.messages-table')
                </div>
            </div>
        @else
            <strong>{{ trans('mailer.wrong_configuration') }}</strong>
            @if (!empty($incomeMailClient->connectionErorrs))
                @foreach($incomeMailClient->connectionErorrs as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
        @endif
    </div>
</div>
