<strong>{{ trans('mailer.wrong_configuration') }}</strong>
@if (!empty($incomeMailClient->connectionErorrs))
    @foreach($incomeMailClient->connectionErorrs as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif