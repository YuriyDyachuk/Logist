<a href="{{ route('mailer.message.new') }}" class="btn btn-primary ">
    <i class="fa fa-plus-square"></i>
    {{ trans('mailer.new') }}
</a>

<a href="{{ route('mailer.folder', $currentFolder->full_name_url) }}" class="btn btn-primary">
    <i class="fa fa-refresh"></i>
    {{ trans('mailer.refresh') }}
</a>
