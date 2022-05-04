@forelse($messages as $message)
    <?php
    $flags = $message->getFlags();
    ?>
    <tr class="@if ($flags->get('seen') === 0) bg-info @endif" data-uid="{{ $message->getUid() }}">
        <td>
            @foreach($message->from as $from)
                <div>{{ Illuminate\Support\Str::limit($from->full, 40, '...') }}</div>
            @endforeach
        </td>
        <td>{{ Illuminate\Support\Str::limit($incomeMailClient->convertSubjectEncoding($message->getSubject()), 40, '...') }}</td>
        <td>
            <div class="text-center">{{ $message->getDate()->toDateString() }}</div>
            <div class="text-center">{{ $message->getDate()->toTimeString() }}</div>
        </td>
        <td>
            <a href="{{ route('mailer.message.show', [$currentFolder->full_name_url, $message->getUid()]) }}" class="btn btn-primary pull-right">
                <i class="fa fa-envelope"></i> {{ trans('mailer.show') }}
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">
            {{ trans('mailer.empty_folder') }}
        </td>
    </tr>
@endforelse