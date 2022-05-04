@if ($smtpStatus)
    <input type="hidden" id="to_one" value="{{ isset($message) && $message->from[0] ? $message->from[0]->mail : ''}}">
    <input type="hidden" id="to_all" value="{{ isset($toAll) ? implode(',', $toAll) : '' }}">
    <input type="hidden" id="forward" value="{{ isset($message) && $message->hasTextBody() ? $message->getTextBody() : '' }}">
    <h4>{{ isset($message) ? trans('mailer.reply') : trans('mailer.new_message') }} : </h4>
    <form action="{{ route('mailer.send') }}" class="form-horizontal" method="POST">
        @method('POST')
        <div class="form-group user_info__input">
            <label class="col-sm-12" for="to">
                {{trans('mailer.to')}}
            </label>
            <div class="col-sm-12">
                <input type="text" name="to" id="to" class="form-control" value="" autocomplete="off" placeholder="{{trans('mailer.to')}}">
            </div>
        </div>

        <div class="form-group user_info__input">
            <label class="col-sm-12" for="subject">
                {{trans('mailer.subject')}}
            </label>
            <div class="col-sm-12">
                <input type="text" name="subject" id="subject" class="form-control" value="{{  isset($message) && !empty($message->getSubject()) ? $incomeMailClient->convertSubjectEncoding($message->getSubject()) : '' }}" autocomplete="off" placeholder="{{trans('mailer.subject')}}">
            </div>
        </div>

        <div class="form-group user_info__input">
            <label class="col-sm-12" for="message_body">
                {{trans('mailer.message')}}
            </label>
            <div class="col-sm-12">
                <textarea name="message" id="message_body" class="form-control" autocomplete="off" placeholder="{{trans('mailer.message')}}"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8">
                <input type="file" name="attachments[]" id="attachments" class="inputfile"
                       data-multiple-caption="{count} - {{trans('all.files_selected')}}"
                       multiple="multiple">
                <label for="attachments" class="btn btn-sm-create-app-def transition">
                    <span>{{trans('mailer.attach_files')}}</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12 text-center">
                <input type="submit" class="btn button-style1" value="{{ trans('mailer.send') }}" id="btn-send-email">
            </div>
        </div>
    </form>
@else
    <div class="text-center">
        <strong>
            {{ trans('mailer.check_smtp_settings_to_send_messages') }}
            <a href="{{ route('mailer.index', ['tab' => 'settings']) }}">
                {{ trans('all.settings') }}
            </a>
        </strong>
    </div>
@endif