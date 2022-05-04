<!-- Modal -->
<div class="modal centered-modal" id="sms_again" tabindex="-1" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="margin-bottom: 15px">{{trans('all.phone')}}</h4>
            </div>
            <div class="modal-body">
                <p>
                    <input type="tel" name="phone" id="phone_2" class="form-control" value="{{$user->phone}}">
                </p>
            </div>
            <div class="modal-footer">
                <button class="send_again_sms_popup btn btn-success" href="{{route('phone.activate')}}">{{trans('all.send_sms_again')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- The Image Modal -->
<div id="imgModal" class="img-modal">

    <!-- The Close Button -->
    <span class="img-close" onclick="$(this).parent().hide()">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="img-modal-content" id="img">
</div>

<!-- Modal Select Profile Type: BEGIN -->
<div id="confirmInformation" class="modal" role="dialog" data-type="">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">
                    {{ trans('all.information_confirm') }}
                </div>
            </div>
            <div class="modal-body">
                <div class="row" id="confirm_name">
                    <div class="col-xs-5"><span class="title">{{ trans('all.name') }}/{{ trans('all.company') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_delegate_name">
                    <div class="col-xs-5"><span class="title">{{ trans('all.name_delegate') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_phone">
                    <div class="col-xs-5"><span class="title">{{ trans('all.phone') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_email">
                    <div class="col-xs-5"><span class="title">{{ trans('all.email_address') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>

                <div class="row" id="confirm_deviation_notification">
                    <div class="col-xs-5"><span class="title">{{ trans('all.deviation_notification') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_deviation_distance">
                    <div class="col-xs-5"><span class="title">{{ trans('all.deviation_distance') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>

                <div class="row" id="confirm_inn">
                    <div class="col-xs-5"><span class="title">{{ trans('all.inn') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_egrpou">
                    <div class="col-xs-5"><span class="title">{{ trans('all.EDRPOU') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row confirm_error has-error" id="error_egrpou" style="display: none;">
                    <div class="col-xs-5"></div>
                    <div class="col-xs-7"><span class="help-block"><strong>Данные не найдены в открытых источниках</strong></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-12"><strong><span class="title"> {{ trans('all.address') }}</span></strong></div>
                </div>
                <div class="row" id="confirm_address_index">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.index') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_country">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.country') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_region">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.region') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_city">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.city') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_street">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.street') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_number">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.address_number') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-12"><strong><span class="title"> {{ trans('all.address_legal') }} </span></strong></div>
                </div>
                <div class="row" id="confirm_address_legal_index">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.index') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_legal_country">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.country') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_legal_region">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.region') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_legal_city">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.city') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_legal_street">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.street') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_legal_number">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.address_number') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-12"><strong><span> {{ trans('all.address_post') }} </span></strong></div>
                </div>
                <div class="row" id="confirm_address_post_index">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.index') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_post_country">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.country') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_post_region">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.region') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_post_city">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.city') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_post_street">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.street') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
                <div class="row" id="confirm_address_post_number">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.address_number') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>

                <div class="row" id="confirm_site_url">
                    <div class="col-xs-5"><span class="title"> {{ trans('all.site_url') }}</span></div>
                    <div class="col-xs-7"><span class="val"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-cancel transition" data-dismiss="modal">{{ trans('all.cancel') }}
                    <i>×</i>
                </button>
                <button type="submit" class="btn button-style1" id="btn_confirmInformation" value="submit" disabled="disabled"><span>{{ trans('all.save') }}</span></button>
            </div>

        </div>
    </div>
</div>