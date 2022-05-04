@extends('layouts.app')
@section('content')
    <div class="content-box template-page">
        <form action="{{ route('documents.template.store', ['id' => $id]) }}" method="post">
            {{ csrf_field() }}

            <div class="container-fluid btn-header">
                <div class="row">
                    <div class="col-xs-6 text-left">
                        <?php $tab = '#templates' ?>
                        <a class="btn button-cancel" id="templates" href="{{route('documents.index') . $tab}}">
                            {{trans('all.back_to_templates')}}
                            <i>&times;</i>
                        </a>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a class="btn button-cancel" href="{{route('documents.index')}}"
                                {{--style="border: 1px solid grey;padding-left: 7px; padding-top: 0; padding-right: 5px; text-align: center; padding-bottom: 5px;"--}}>{{trans('all.cancel_btn')}}
                            <i>&times;</i></a>
                    </div>
                </div>
            </div>

            <div id="transport-cargo_tables">

                <div class="content">

                    <table id="table-content" cellpadding="0" cellspacing="0">
                        <tr class="header">
                            <td>
                                <div class="content" style="clear: left">
                                    <div class="content__title">
                                        <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                                        <div class="title-content-fonts">
                                            <div>
                                                {{ trans('all.pdf_transport_service') }}
                                            </div>
                                            <div>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content__qr-logos">
                                        <img class="content__qr-images"
                                             src="http://chart.googleapis.com/chart?chs=230x230&cht=qr&chl=">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="lines font-style" style="margin-top: 60px;">
                                    <div class="customers-cargo lines__cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.customers') }}:</span>
                                        <div class="lines__bottom">
                                        </div>
                                    </div>
                                    <div class="carrier-cargo lines__cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.carrier') }}:</span>
                                        <div class="lines__bottom">
                                        </div>
                                    </div>
                                    <div class="shipper-cargo lines__shipper-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.manager') }}:</span>
                                        <div class="lines__bottom threes">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- block dop-info textarea -->
                                <div class="panel-textarea">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.contract_subject') }}:
                                    </div>
                                    <textarea name="fields[order_subject]"
                                              class="form-control color panel-textarea__style">{{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_subject') }}</textarea>
                                </div>
                                <!-- end block dop-info textarea -->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="panel-textarea" id="orders_inform" style="height: 107px;">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.order_info') }}:
                                    </div>
                                    <div class="inform-two-block">
                                        <div class="info-orders font-style">
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.date_and_time_loading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                            {{----}}
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.date_and_time_loading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                        </div>

                                        <div class="info-orders-right font-style">
                                            <div class="info-orders-right__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.address_loading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>

                                            <div class="info-orders-right__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.address_loading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- block cargo inform-->
                                <div class="panel-textarea" id="inform-cargo">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.cargo_information') }}:
                                    </div>
                                    <div class="info-cargo">
                                        <div class="info-cargo__left">
                                            <div class="info-cargo__plane-tonnage">
                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.cargo') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.weight') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.transport_volume') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>

                                            <div class="info-cargo__plane-length">
                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.transport_width') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.length') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div>
                                                    <span class="fonts-span__color">{{ trans('all.transport_height') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="info-cargo-right">
                                            <div class="info-cargo-right__count-seats">
                                                <span class="fonts-span__color">{{ trans('all.quantity_of_packages_2') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly
                                                       disabled>
                                            </div>

                                            <div class="info-cargo-right__hazard-class">
                                                <span class="fonts-span__color">{{ trans('all.hazard_class') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly
                                                       disabled>
                                            </div>

                                            <div class="info-card">
                                                <div class="info-card__type-packaging">
                                                    <span class="fonts-span__color">{{ trans('all.package_type_2') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div class="info-card__t-mode">
                                                    <span class="fonts-span__color">{{ trans('all.temp_mode') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end block cargo inform-->
                            </td>
                        </tr>
                        <tr style="width: 60%;display: flex;float: left;" class="block-info_trans">
                            <td style="width: 98%;" id="classes">
                                <!-- Block [transport,payments,comments] -->
                                <div class="panel-textarea" id="inform-transport">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.transport_info') }}:
                                        </div>
                                        <div class="driver-inform">
                                            <div class="driver-inform__full-name" style="margin-bottom: 15px;">
                                                <span class="fonts-span__color">{{ trans('all.driver_fio') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>

                                            <div class="driver-inform__full-name driver-inform__number-phone">
                                                <span class="fonts-span__color">{{ trans('all.phone') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                        </div>

                                        <div style="display: flex;" class="types">
                                            <div class="auto-inform">
                                                <div class="auto-inform__type-auto">
                                                    <span class="fonts-span__color">{{ trans('all.type_ps') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div class="auto-inform__number-car">
                                                    <span class="fonts-span__color">{{ trans('all.transport_number_2') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>

                                            <div class="trailer-inform">
                                                <div class="trailer-inform__type-loading">
                                                    <span class="fonts-span__color">{{ trans('all.loading_type') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div class="trailer-inform__numb-trailer">
                                                    <span class="fonts-span__color">{{ trans('all.transport_trailer_number') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        <tr style="width: 40%;display: flex;float: left;" class="pay-com-block">
                            <td style="width: 100%;">
                                <div class="block-fix_inform-pay">
                                    <div class="panel-textarea" id="inform-payment">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.payment_information') }}:
                                        </div>
                                        <div class="inform-payment">
                                            <div class="inform-payment__check">
                                                <span class="fonts-span__color">{{ trans('all.terms_type') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly
                                                       disabled>
                                            </div>

                                            <div class="inform-type-sum">
                                                <div class="inform-type-sum__count-sum">
                                                    <span class="fonts-span__color">{{ trans('all.amount') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div class="inform-type-sum__type-pay">
                                                    <span class="fonts-span__color">{{ trans('all.payment_type') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-textarea" id="inform-comment" style="margin-top: -10px;">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.comment') }}:
                                        </div>
                                        <div class="comments-text">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- block dop-info textarea -->
                                <div class="panel-textarea">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.additional_rules') }}:
                                    </div>
                                    <textarea name="fields[order_extra_rules]"
                                              class="form-control color panel-textarea__style">{{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_extra_rules') }}</textarea>
                                </div>
                                <!-- end block dop-info textarea -->
                            </td>
                        </tr>

                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans1">
                            <td style="width: 100%;">
                                <div id="containers-carrier" style="width: 100%;">
                                    <div class="panel-textarea" id="carrier-1">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.carrier') }}
                                        </div>
                                        <div class="inform-carrier">
                                            <div>
                                                <span class="font-carrier">ФЛ-П</span>
                                            </div>

                                            <div class="inform-carrier__legal_address-nds">
                                                <span class="font-carrier">{{ trans('all.legal_address_short') }}:</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__address_post">
                                                <span class=" font-carrier">{{ trans('all.address_post') }}:</span>
                                                <input class=" inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__rs-phone">
                                                <span class="font-carrier">{{ trans('all.payment_account_min') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code-edrpou">
                                                <span class=" font-carrier">{{ trans('all.code_edrpou') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code_mfo-inn">
                                                <span class="font-carrier">{{ trans('all.code_mfo') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code_mfo-inn">
                                                <span class="font-carrier">{{ trans('all.inn') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__legal_address-nds">
                                                <span class="font-carrier">{{ trans('all.VAT_certificate_short') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__rs-phone">
                                                <span class="font-carrier">{{ trans('all.phone_min') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans2">
                            <td style="width: 100%;">
                                <div id="containers-carrier">
                                    <div class="panel-textarea" id="carrier-2" style="margin-left: 0;">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.customers') }}
                                        </div>
                                        <div class="inform-carrier">
                                            <div>
                                                <span class="font-carrier">ФЛ-П</span>
                                            </div>

                                            <div class="inform-carrier__legal_address-nds">
                                                <span class="font-carrier">{{ trans('all.legal_address_short') }}:</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__address_post">
                                                <span class=" font-carrier">{{ trans('all.address_post') }}:</span>
                                                <input class=" inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__rs-phone">
                                                <span class="font-carrier">{{ trans('all.payment_account_min') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code-edrpou">
                                                <span class=" font-carrier">{{ trans('all.code_edrpou') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code_mfo-inn">
                                                <span class="font-carrier">{{ trans('all.code_mfo') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__code_mfo-inn">
                                                <span class="font-carrier">{{ trans('all.inn') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__legal_address-nds">
                                                <span class="font-carrier">{{ trans('all.VAT_certificate_short') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                            <div class="inform-carrier__rs-phone">
                                                <span class="font-carrier">{{ trans('all.phone_min') }}</span>
                                                <input class="inputs-info__style " type="text" value="" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans3">
                            <td style="width: 100%;">
                                <div id="containers-carrier_2">

                                    <div class="block-carrier_2 panel-textarea" style="margin-left: 0;margin-right: 30px">
                                        <div class="people-success">
                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.document_on_sign_kep') }} {{ trans('all.document_persona') }}:</span>
                                                <span></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.organizations') }}:</span>
                                                <span class=""></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.times') }}:</span>
                                                <span class=""></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.certificate') }}:</span>
                                                <span></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.serial_number') }}: </span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans4">
                            <td style="width: 100%">
                                <div id="containers-carrier_3" style="margin-left: 0;">
                                    <div class="block-carrier_2 panel-textarea" style="margin-left: 0">
                                        <div class="people-success">
                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.document_on_sign_kep') }} {{ trans('all.document_persona') }}:</span>
                                                <span></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.organizations') }}:</span>
                                                <span class=""></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.times') }}:</span>
                                                <span class=""></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.certificate') }}:</span>
                                                <span></span>
                                            </div>

                                            <div>
                                                <span class="span-dont-weight">{{ trans('all.serial_number') }}: </span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="force-break tr-footer">
                            <td>
                                <table style="width: 100%; margin-right: 80px; margin-top:0px !important; padding-top:0px !important;">
                                    <tr>
                                        <td class="panel_item" style="width: 50%;">
                                            <div class="panel panels-body" style="display: flex;">
                                                <div class="container-fluid btn-footer">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <a class="btn button-cancel"
                                                               href="{{route('documents.template.edit', ['id' => $id])}}">{{trans('all.cancel')}}
                                                                <i>&times;</i></a>
                                                            <a id="btn_preview" class="btn button-style1"
                                                               href="{{route('documents.download_document_template', ['id' => $id])}}">{{trans('document.document_template_btn_preview')}}</a>
                                                            <button class="btn button-style1"
                                                                    type="submit">{{trans('all.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="footer_line"
                 style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>

        </form>

        <form id="review-form" action="{{ route('documents.download_document_template', ['id' => $id]) }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="order_subject" value="">
            <input type="hidden" name="order_extra_rules" value="">
        </form>
    </div>

    @push('scripts')

        <script>

            $(function () {
                $('#btn_preview').click(function (e) {
                    e.preventDefault();

                    let order_subject = $('textarea[name=order_subject]').val();
                    $('input[name=order_subject]').val(order_subject);

                    let order_extra_rules = $('textarea[name=order_extra_rules]').val();
                    $('input[name=order_extra_rules]').val(order_extra_rules);


                    $("#review-form").submit();
                });


            });


        </script>

    @endpush
@endsection