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
        <table id="tables-container" style="width: 100%!important;">
            <tr class="header">
                <td>
                    <div class="content" style="clear: left">
                        <div class="content__title">
                            <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                            <div class="title-content-fonts">
                                <div>
                                    {{ trans('all.payment_invoice') }}
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
                    <div class="flex-container-table border-content panel-textarea" style="height: auto;min-height: 130px;margin-top: 60px;">
                        <div class="flex-item" id="tables-detection" style="width: 100%">
                            <?php $num = 1; ?>
                            <table role="table" class="resize">
                                <thead role="rowgroup">
                                    <tr role="row">
                                        <th role="columnheader">№</th>
                                        <th role="columnheader">{{ trans('all.name_services') }}</th>
                                        <th role="columnheader">{{ trans('all.units') }}</th>
                                        <th role="columnheader">{{ trans('all.count_') }}</th>
                                        <th role="columnheader">{{ trans('all.price_not_nds') }}</th>
                                        <th role="columnheader">{{ trans('all.summa_nds') }}</th>
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
                                    </tr>
                                    <tr role="row" id="table-row">
                                        <td role="cell">2</td>
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
                                    </tr>
                                </tbody>
                            </table>
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
                                <div class="panel panels-body" style="display: flex">
                                    <div class="container-fluid btn-footer">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <a class="btn button-cancel" href="{{route('documents.template.edit', ['id' => $id])}}">{{trans('all.cancel')}} <i>&times;</i></a>
                                                <a style="display: none;" id="btn_preview" class="btn button-style1" href="{{route('documents.download_document_template', ['id' => $id])}}">{{trans('document.document_template_btn_preview')}}</a>
                                                <button class="btn button-style1" type="submit">{{trans('all.save')}}</button>
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
    <div class="footer_line" style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>

</form>

</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // $(window).resize(function() {
                if ($(window).width() < 595) {
                    // remove raz class from all elements
                    let res = document.querySelectorAll('table [role="table"]').forEach(function (el){
                        el.classList.remove("resize");
                    });
                    console.log(res)
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