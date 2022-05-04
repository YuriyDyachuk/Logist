<div class="col-sm-9">
    @if(isset($message))
        <div>
            <h1>
                {{ !empty($message->getSubject()) ? $incomeMailClient->convertSubjectEncoding($message->getSubject()) : trans('mailer.empty_subject') }}
            </h1>
        </div>
        <div>
            {{ trans('mailer.from') }} :
            <strong>
                @foreach($message->from as $from)
                    <div>{{ $from->full }}</div>
                @endforeach
            </strong>
        </div>
        <div>
            {{ trans('all.date') }} :
            <strong>
                {{ $message->getDate() }}
            </strong>
        </div>
        <div>
            {{ trans('mailer.to') }} :
            <strong>
                @foreach($message->to as $to)
                    <div>{{ $to->full }}</div>
                @endforeach
            </strong>
        </div>
        @if($message->hasAttachments())
            <div>
                {{ trans('mailer.attachments') }} : <br/>
                <strong>
                    @foreach($message->attachments as $attachment)
                        <div>
                            <a href="{{ route('mailer.message.attachment', [$currentFolder->full_name_url, $message->getUid(), $attachment->getId()]) }}" target="_blank">
                                {{ $attachment->name }} ( {{formatBytes($attachment->size) }} )
                            </a>
                        </div>
                    @endforeach
                </strong>
            </div>
        @endif
        @if ($message->hasHTMLBody())
            <div class="htmlbody">
                {!! $message->getHTMLBody() !!}
            </div>
        @elseif ($message->hasTextBody())
            <div class="textbody">
                {{ $message->getTextBody() }}
            </div>
        @endif
    @endif
    @if (isset($message))
        <div class="block" id="reply-buttons">
            <button class="btn btn-default mailer-reply-message" data-reply="one"><i class="fa fa-reply"></i> {{ trans('mailer.reply')  }}</button>
            @if (count($message->to) > 1)
                <button class="btn btn-default mailer-reply-message" data-reply="all"><i class="fa fa-reply-all"></i> {{ trans('mailer.reply_to_all')  }}</button>
            @endif
            <button class="btn btn-default mailer-reply-message" data-reply="forward"><i class="fa fa-share"></i> {{ trans('mailer.forward')  }}</button>
        </div>
    @endif
    <div class="block" id="reply-block" @if (isset($message)) style="display: none" @endif>
        @include('mailer.layouts.includes.reply')
    </div>
</div>