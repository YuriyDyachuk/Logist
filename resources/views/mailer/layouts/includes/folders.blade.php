@foreach($folders as $folder)
    <?php $status = $folder->getStatus(\Webklex\IMAP\IMAP::SA_ALL); ?>
    @if ($status !== false)
        <a href="{{ route('mailer.folder', $folder->full_name_url) }}" class="list-group-item list-group-item-action @if ($folder->full_name === $currentFolder->full_name) active @endif">
            <i class="fa fa-folder"></i>
            {{ $folder->name }}
            <span class="pull-right">
                @if ($status->unseen > 0)
                    <span class="label label-danger">{{ $status->unseen }}</span>
                @endif
                <span class="label label-default">{{ $status->messages }}</span>
            </span>
        </a>
    @endif
    @if ($folder->has_children)
        @include('mailer.layouts.includes.folders', ['folders' => $folder->children])
    @endif
@endforeach