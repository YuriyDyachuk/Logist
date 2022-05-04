<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') === 'settings' ? ' active in':''   }}" id="settings">
    <div class="content-box__body">
        <form action="{{ route('mailer.settings.update') }}" class="form-horizontal" method="POST">
            @method('POST')

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.income_protocol')}}</label>
                <div class="col-sm-8">
                    <select name="income_mail_protocol" id="income_mail_protocol" class="selectpicker" data-live-search="true" title="{{trans('mailer.income_mail_protocol')}}" autocomplete="off">
                        <option value="imap" @if (isset($user->meta_data['income_mail_protocol']) && $user->meta_data['income_mail_protocol'] === 'imap') selected="selected" @endif>
                            {{ trans('mailer.imap') }}
                        </option>

                        <option value="pop3" @if (isset($user->meta_data['income_mail_protocol']) && $user->meta_data['income_mail_protocol'] === 'pop3') selected="selected" @endif>
                            {{ trans('mailer.pop3') }}
                        </option>

                        <option value="nntp" @if (isset($user->meta_data['income_mail_protocol']) && $user->meta_data['income_mail_protocol'] === 'nntp') selected="selected" @endif>
                            {{ trans('mailer.nntp') }}
                        </option>
                    </select>
                    <span class="help-block">{!! trans('mailer.income_mail_protocol_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.income_server')}}</label>
                <div class="col-sm-8">
                    <input type="text" name="income_server" class="form-control" value="{{ $user->meta_data['income_server'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.income_server')}}">
                    <span class="help-block">{!! trans('mailer.income_server_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.income_port')}}</label>
                <div class="col-sm-8">
                    <input type="number" name="income_port" class="form-control" value="{{ $user->meta_data['income_port'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.income_port')}}">
                    <span class="help-block">{!! trans('mailer.income_port_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.income_encryption')}}</label>
                <div class="col-sm-8">
                    <select name="income_encryption" id="income_encryption" class="selectpicker" data-live-search="true" title="{{trans('mailer.income_encryption')}}" autocomplete="off">
                        <option value="0" @if (isset($user->meta_data['income_encryption']) && (int) $user->meta_data['income_encryption'] === 0) selected="selected" @endif>
                            {{ trans('mailer.disabled') }}</option>
                        <option value="ssl" @if (isset($user->meta_data['income_encryption']) && $user->meta_data['income_encryption'] === 'ssl') selected="selected" @endif>
                            {{ trans('mailer.ssl') }}
                        </option>
                        <option value="tls" @if (isset($user->meta_data['income_encryption']) && $user->meta_data['income_encryption'] === 'tls') selected="selected" @endif>
                            {{ trans('mailer.tls') }}
                        </option>

                        <option value="starttls" @if (isset($user->meta_data['income_encryption']) && $user->meta_data['income_encryption'] === 'starttls') selected="selected" @endif>
                            {{ trans('mailer.starttls') }}
                        </option>

                        <option value="notls" @if (isset($user->meta_data['income_encryption']) && $user->meta_data['income_encryption'] === 'notls') selected="selected" @endif>
                            {{ trans('mailer.notls') }}
                        </option>
                    </select>
                    <span class="help-block">{!! trans('mailer.income_protection_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.smtp_server')}}</label>
                <div class="col-sm-8">
                    <input type="text" name="smtp_server" class="form-control" value="{{ $user->meta_data['smtp_server'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.smtp_server')}}">
                    <span class="help-block">{!! trans('mailer.smtp_server_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.smtp_port')}}</label>
                <div class="col-sm-8">
                    <input type="number" name="smtp_port" class="form-control" value="{{ $user->meta_data['smtp_port'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.smtp_port')}}">
                    <span class="help-block">{!! trans('mailer.smtp_port_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.smtp_encryption')}}</label>
                <div class="col-sm-8">
                    <select name="smtp_encryption" id="smpt_ssl" class="selectpicker" data-live-search="true" title="{{trans('mailer.smtp_encryption')}}" autocomplete="off">
                        <option value="0" @if (isset($user->meta_data['smtp_encryption']) && (int) $user->meta_data['smtp_encryption'] === 0) selected="selected" @endif>
                            {{ trans('mailer.disabled') }}
                        </option>

                        <option value="ssl" @if (isset($user->meta_data['smtp_encryption']) && $user->meta_data['smtp_encryption'] === 'ssl') selected="selected" @endif>
                            {{ trans('mailer.ssl') }}
                        </option>

                        <option value="tls" @if (isset($user->meta_data['smtp_encryption']) && $user->meta_data['smtp_encryption'] === 'tls') selected="selected" @endif>
                            {{ trans('mailer.tls') }}
                        </option>

                        <option value="starttls" @if (isset($user->meta_data['smtp_encryption']) && $user->meta_data['smtp_encryption'] === 'starttls') selected="selected" @endif>
                            {{ trans('mailer.starttls') }}
                        </option>

                        <option value="notls" @if (isset($user->meta_data['smtp_encryption']) && $user->meta_data['smtp_encryption'] === 'notls') selected="selected" @endif>
                            {{ trans('mailer.notls') }}
                        </option>
                    </select>
                    <span class="help-block">{!! trans('mailer.smtp_protection_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.email_server_username')}}</label>
                <div class="col-sm-8">
                    <input type="text" name="email_server_username" class="form-control" value="{{ $user->meta_data['email_server_username'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.email_server_username')}}">
                    <span class="help-block">{!! trans('mailer.email_server_username_help') !!}</span>
                </div>
            </div>

            <div class="form-group user_info__input">
                <label class="control-label col-sm-4">{{trans('mailer.email_server_password')}}</label>
                <div class="col-sm-8">
                    <input type="password" name="email_server_password" class="form-control" value="{{ $user->meta_data['email_server_password'] ?? ''}}" autocomplete="off" placeholder="{{trans('mailer.email_server_password')}}">
                    <span class="help-block">{!! trans('mailer.email_server_password_help') !!}</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 text-center">
                    <input type="submit" class="btn button-style1" value="{{ trans('all.save') }}" id="btn-upd-email-service">
                </div>
            </div>

        </form>
    </div>
</div>
