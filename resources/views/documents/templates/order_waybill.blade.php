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

                    <table id="table-content" class="" cellpadding="0" cellspacing="0">
                        <tr class="header">
                            <td>
                                <div class="content" style="clear: left">
                                    <div class="content__title">
                                        <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                                        <div class="title-content-fonts">
                                            <div>
                                                {{ trans('all.transport_titles') }}
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
                                <div class="lines-cargos font-style" style="margin-top: 60px;">
                                    <div class="customers-cargo cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.customers') }}:</span>
                                        <div class="lines-cargos__bottom">

                                        </div>
                                    </div>
                                    <div class="carrier-cargo cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.carrier') }}:</span>
                                        <div class="lines-cargos__bottom">

                                        </div>
                                    </div>
                                    <div class="carrier-cargo cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.shipper') }}:</span>
                                        <div class="lines-cargos__bottom">

                                        </div>
                                    </div>
                                    <div class="carrier-cargo cargo-width">
                                        <span id="color-cargo" class="fonts-span__color">{{ trans('all.consignee') }}:</span>
                                        <div class="lines-cargos__bottom">

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td id="maps-info">
                                <div class="panel-textarea" id="orders_inform" style="height: 107px;">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.info_maps_title') }}:
                                    </div>
                                    <div class="inform-two-block" id="templates4">
                                        <div class="info-orders font-style">
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.address_loading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                            {{----}}
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.address_unloading') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                        </div>

                                        <div class="info-orders-right font-style">
                                            <div class="info-orders-right__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.address_cargo_refresh') }}:</span>
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

                        <tr style="width: 40%;display: flex;float: left;" class="block-info_trans" id="cons">
                            <td style="width: 98%;" id="classes">
                                <!-- Block [transport,payments,comments] -->
                                <div class="panel-textarea inform-transport-template4" id="inform-transport">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.transport_info') }}:
                                    </div>
                                    <div class="driver-inform">
                                        <div class="driver-inform__full-name" style="margin-bottom: 15px;">
                                            <span class="fonts-span__color">{{ trans('all.driver_fio') }}:</span>
                                            <input class="inputs-info__style" type="text" value="" readonly disabled>
                                        </div>

                                        <div class="driver-inform__full-name driver-inform__number-phone">
                                            <span class="fonts-span__color">{{ trans('all.automobile') }}:</span>
                                            <input class="inputs-info__style" type="text" value="" readonly disabled>
                                        </div>

                                        <div class="driver-inform__full-name driver-inform__number-phone">
                                            <span class="fonts-span__color">{{ trans('all.trailer') }}:</span>
                                            <input class="inputs-info__style" type="text" value="" readonly disabled>
                                        </div>

                                        <div class="driver-inform__full-name driver-inform__number-phone">
                                            <span class="fonts-span__color">{{ trans('all.view_cargo') }}:</span>
                                            <input class="inputs-info__style" type="text" value="" readonly disabled>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr style="width: 60%;display: flex;float: left;" class="pay-com-block" id="pay-com-block">
                            <td style="width: 100%;">
                                <div class="block-fix_inform-pay" id="inform-payment-template4">
                                    <div class="panel-textarea" id="inform-payment">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.transport_condition_cargo') }}:
                                        </div>
                                        <div class="inform-payment">

                                            <div class="inform-payment__check">
                                                <div>
                                                    <span>{{ trans('all.title_condition_cargo') }}</span>
                                                </div>
                                                <div class="radio-button">
                                                    <label class="radio">
                                                        <input type="radio" name="radio" value="1" checked>
                                                        <span>Отвечает</span>
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="radio" value="2">
                                                        <span>Не отвечает</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="three-template4-block">
                                                <div class="inform-payment__check">
                                                    <span class="fonts-span__color">{{ trans('all.number_seal') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                                <div class="inform-type-sum">
                                                    <div class="inform-type-sum__count-sum">
                                                        <span class="fonts-span__color">{{ trans('all.quantity_of_sum') }}:</span>
                                                        <input class="inputs-info__style" type="text" value="" readonly
                                                               disabled>
                                                    </div>

                                                    <div class="inform-type-sum__type-pay">
                                                        <span class="fonts-span__color">{{ trans('all.gross_weight') }}:</span>
                                                        <input class="inputs-info__style" type="text" value="" readonly
                                                               disabled>
                                                    </div>
                                                </div>

                                                <div class="inform-driver">
                                                    <span class="fonts-span__color">{{ trans('all.driver_fio_got') }}:</span>
                                                    <input class="inputs-info__style" type="text" value="" readonly
                                                           disabled>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td id="template_1">
                                <div class="panel-textarea" id="orders_inform" style="height: 107px;">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.bookkeeping') }}:
                                    </div>
                                    <div class="inform-two-block" id="block-templates4">
                                        <div class="info-orders font-style">
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.bookkeeping_man_cargo') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                            {{----}}
                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.summa_all') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>

                                            <div class="info-orders__length_block font-style__dop">
                                                <span class="fonts-span__color">{{ trans('all.VAT') }}:</span>
                                                <input class="inputs-info__style" type="text" value="" readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans1">
                            <td style="width: 100%;">
                                <div id="containers-carrier" style="width: 100%;">
                                    <div class="panel-textarea">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.title_transport_service_cargo') }}:
                                        </div>
                                        <textarea name="fields[order_services]" class="form-control color panel-textarea__style">{{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_services') }}</textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="width: 50%;display: flex;float: left;" class="block-info_trans2">
                            <td style="width: 100%;">
                                <div id="containers-carrier">
                                    <div class="panel-textarea" style="margin-left: 0;">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.documents_title_cargo') }}:
                                        </div>
                                        <div class="comments-text">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr style="width: 33.3%;display: flex;float: left;" class="block-info_trans3 one-block">
                            <td style="width: 100%;">
                                <div id="containers-carrier_2">
                                    <div class="block-carrier_2">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.title_confirm') }}
                                        </div>
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
                        <tr style="width: 33.3%;display: flex;float: left;" class="block-info_trans4">
                            <td style="width: 100%" class="cargo-confirm">
                                <div id="containers-carrier_3">
                                    <div class="panel-textarea two-block" id="carrier-2">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.title_confirm_cargo') }}
                                        </div>
                                        <div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="width: 33.3%;display: flex;float: left;" class="block-info_trans4">
                            <td style="width: 100%" class="cargo-confirm">
                                <div id="containers-carrier_3" style="margin-left: 0;">
                                    <div class="panel-textarea three-block" id="carrier-2" style="width: 100%;margin-right: 14px;">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.title_confirm_cargo_step') }}
                                        </div>
                                        <div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="force-break tr-footer" style="display: none">
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

            {{-- Templates waybill_2 documents --}}

            <div id="transport-cargo_tables" style="margin-top: 40px">
                <div class="content">

                    <table id="table-content" cellpadding="0" cellspacing="0">
                        <tr class="header">
                            <td>
                                <div class="content" style="clear: left">
                                    <div class="content__title">
                                        <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                                        <div class="title-content-fonts">
                                            <div>
                                                {{ trans('all.transport_titles') }}
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
                                <div class="panel-textarea" style="height: auto;padding-bottom: 10px;">
                                    <div class="center-block">
                                        <div class="">
                                            <span class="attribute-title">{{trans('all.messages.headers')}}&nbsp;</span>
                                            <span id="border_bottoms" class="attribute-title">&nbsp;</span>
                                            <span class="attribute-title">&nbsp;{{trans('all.messages.headers_view')}}&nbsp;</span>
                                            <span id="border_bottoms2"></span>
                                        </div>
                                        <div class="">
                                            <span class="attribute-title">{{trans('all.messages.headers_transport_')}}&nbsp;</span>
                                            <span id="border_bottoms2">&nbsp</span>
                                            <span class="attribute-title">{{trans('all.messages.headers_transport_number')}}.</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-container-table border-content panel-textarea" id="table-template5" style="height: auto;min-height: 130px;">
                                    <div class="flex-item" id="tables-detection" style="width: 100%">
                                        <?php $num = 1; ?>
                                        <table role="table" class="resize">
                                            <div class="panel-textarea__title">
                                                {{ trans('all.about_info_cargo') }}:
                                            </div>
                                            <thead role="rowgroup">
                                            <tr role="row">
                                                <th role="columnheader" class="number-row">№</th>
                                                <th role="columnheader" class="rows__tables1">{{ trans('all.cargo_full_name') }}</th>
                                                <th role="columnheader" class="rows__tables2">{{ trans('all.documents_titles_cargo') }}</th>
                                                <th role="columnheader" class="rows__tables1">{{ trans('all.package_type_2') }}</th>
                                                <th role="columnheader" class="rows__tables2">{{ trans('all.units') }}</th>
                                                <th role="columnheader" class="rows__tables3">{{ trans('all.whole_time_minute') }}</th>
                                                <th role="columnheader" class="rows__tables1">{{ trans('all.quantity_of_sum') }}</th>
                                                <th role="columnheader" class="rows__tables2">{{ trans('all.gross_weight') }}</th>
                                                <th role="columnheader" class="rows__tables2">{{ trans('all.price_not_nds_all') }}</th>
                                                <th role="columnheader" class="rows__tables4">{{ trans('all.summa_nds') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody role="rowgroup">
                                            <tr role="row" id="table-row">
                                                <td role="cell">1  {{--$num++--}}</td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell">2</td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell">3</td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell">Всего:</td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex-container-table border-content panel-textarea" id="table-template" style="height: auto;min-height: 130px;">
                                    <div class="flex-item" id="tables-detection" style="width: 100%">
                                        <div class="panel-textarea__title">
                                            {{ trans('all.name_services_cargo') }}:
                                        </div>
                                        <table role="table" class="resize">
                                            <thead role="rowgroup">
                                            <tr role="row">
                                                <th role="columnheader">{{ trans('all.name_operations') }}</th>
                                                <th role="columnheader">{{ trans('all.name_arrival') }}</th>
                                                <th role="columnheader">{{ trans('all.name_departure') }}</th>
                                                <th role="columnheader">{{ trans('all.name_plain') }}</th>
                                                <th role="columnheader">{{ trans('all.gross_weight') }}</th>
                                                <th role="columnheader">{{ trans('all.name_responsible_persons') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody role="rowgroup">
                                            <tr role="row" id="table-row">
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                                <td role="cell"></td>
                                            </tr>
                                            <tr role="row" id="table-row">
                                                <td role="cell" style="text-align: inherit;">Всего:</td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role=""></td>
                                                <td role="cell"></td>
                                                <td role=""></td>
                                            </tr>
                                            </tbody>
                                        </table>
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
            {{-- end templates waybill_2 documents --}}
            <div class="footer_line" style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>

        </form>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
        // $(window).resize(function() {

            let rows = document.querySelectorAll('td [role=""]');
            if ($(window).width() < 1000) {
                rows.forEach(el => {
                   el.style.display = "none";
                });
                // remove raz class from all elements
                let res = document.querySelectorAll('table [role="table"]').forEach(function (el){
                    el.classList.remove("resize");
                });
            } else {
                // add class 'raz' to last element
                document.querySelectorAll('table [role="table"]').forEach(function (el){
                    el.classList.add("resize");
                });
            }
        // });
        });
    </script>
@endpush