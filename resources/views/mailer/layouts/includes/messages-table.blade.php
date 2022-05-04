<strong>{{ $currentFolder->name ? $currentFolder->name .' : ' : '' }}</strong>
@if (!empty($incomeMailClient->fetchFoldersErrors))
    @foreach($incomeMailClient->fetchFoldersErrors as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif
<div>
    @include('mailer.layouts.includes.tools')
</div>
<table class="table" id="messages-table">
    <tr>
        <th class="text-center">{{ trans('mailer.from') }}</th>
        <th class="text-center">{{ trans('mailer.subject') }}</th>
        <th class="text-center">{{ trans('mailer.date_and_time') }}</th>
        <th class="text-center"></th>
    </tr>

    @include('mailer.layouts.includes.message-rows')
</table>
@if($messages->count() > 0)
    <div class="text-center">
        {{ $messages->links() }}
    </div>
@endif