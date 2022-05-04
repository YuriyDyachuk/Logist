@extends('layouts.pdf')
@section('content')
    <div id="order" style="padding:0px !important; margin:0px !important; z-index:1000;">
        <div class="content" style="width:2763px;">
            <table class="persons" style="width:2763px;" cellpadding="0" cellspacing="0">
                <tr class="page tr-header">
                    <td>
                        <div class="header">
                            <div>
                                <div>
                                    <span class="request">{{ trans('all.request') }}</span>
                                    <span class="number"> # </span>
                                    <span class="request"></span>
                                    <span class="from"></span>
                                    <span class="slash">{{ date('d') }} </span>
                                    <span class="slash"> / </span>
                                    <span class="slash">{{ trans('all.month_'.date('n')) }} </span>
                                    <span class="year">{{ date('Y') }} {{trans('all.year_short')}} </span>
                                </div>
                                <div>
                                    <span class="ttn">{{ trans('all.transport_service') }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="page tr-contacts">
                    <td>
                        <table style="margin:0px 25px;">
                            <tr class="page tr-owner">
                                <td class="role">{{ trans('all.carrier') }} :</td>
                                <td class="value"><div class="dashed_bottom"></div></td>
                                <td class="photo" rowspan="3">
                                    {!! trans('all.logo_placeholder') !!}
                                </td>
                            </tr>
                            <tr class="page tr-client">
                                <td class="role">{{ trans('all.client') }} :</td>
                                <td class="value"><div class="dashed_bottom"></div></td>
                                <td></td>
                            </tr>
                            <tr class="page tr-manager">
                                <td class="role">{{ trans('all.manager') }} :</td>
                                <td class="value"><div class="dashed_bottom">-</div></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="page tr-subject">
                    <td class="panel_item">
                        <div class="panel">
                            <div class="title">
                                {{ trans('all.SUBJECT_OF_CONTRACT') }}
                            </div>
                        </div>

                        <div class="panel">
                            <div style="/*height: 80px;*/">
                                @if(isset($fields['order_subject']))
                                    {{$fields['order_subject']}}
                                @else
                                    {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_subject', $user) }}
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="page tr-addresses">
                    <td class="panel_item">
                        <div class="panel">
                            <div class="title">
                                {{ trans('all.order_information') }}
                            </div>
                        </div>

                        <div class="panel panel-body">
                            <table style="width: 100%">
                                    <tr class="row_address">
                                        <td class="label_date label-block">
                                            <div class="img_wrap"><img src="{{ url('img/calendar.png') }}" height="35" alt="img"></div>
                                            {{ trans('all.date_and_time') }}
                                            {{ trans('all.loading_1') }}
                                        </td>
                                        <td class="input_date">
                                            <div class="input input_type_date"></div>
                                        </td>
                                        <td class="label_address label-block">
                                            <div class="img_wrap" style="text-align: right; margin-left:180px"><img src="{{ url('img/address.png') }}" height="35" alt="img"></div>
                                            {{ trans('all.unloading_1') }}
                                        </td>
                                        <td class="input_address">
                                            <div class="input"></div>
                                        </td>
                                    </tr>
                                <tr class="row_address">
                                    <td class="label_date label-block">
                                        <div class="img_wrap"><img src="{{ url('img/calendar.png') }}" height="35" alt="img"></div>
                                        {{ trans('all.date_and_time') }}
                                        {{ trans('all.loading_1') }}
                                    </td>
                                    <td class="input_date">
                                        <div class="input input_type_date"></div>
                                    </td>
                                    <td class="label_address label-block">
                                        <div class="img_wrap" style="text-align: right; margin-left:180px"><img src="{{ url('img/address.png') }}" height="35" alt="img"></div>
                                        {{ trans('all.address') }}
                                    </td>
                                    <td class="input_address">
                                        <div class="input"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr class="page tr-cargo">
                    <td  class="panel_item">
                        <div class="panel">
                            <div class="title">
                                {{ trans('all.cargo_information') }}
                            </div>
                        </div>

                        <table style="width: 100%">
                            <tr>
                                <td style="width: 50%">
                                    <div class="panel panel-body panel-part-1">
                                        <table style="width: 100%">
                                            <tr>
                                                <td class="big">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.cargo') }}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.length') }} ({{ trans('all.cm') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.weight') }} ({{ trans('all.kg') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.height') }} ({{ trans('all.cm') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.volume') }} (м3)</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.width') }} ({{ trans('all.cm') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td style="width: 50%">
                                    <div class="panel panel-body panel-part-2">
                                        <table style="width: 100%">
                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input pack-type"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.package_type_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input temperature_mode"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.temperature_mode') }}</div>

                                                        <div class="input-cargo right input quantity_of_packages"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.quantity_of_packages_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input hazard"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.hazard_class') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="page tr-transport-payment-comment">
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <td class="panel_item" style="width: 50%; padding-right:25px; padding-bottom: 0px;" rowspan="2">
                                    <div class="panel">
                                        <div class="title">
                                            {{ trans('all.transport_info') }}
                                        </div>
                                    </div>

                                    <div class="panel panel-body panel-part-3">
                                        <table style="width: 100%">
                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input transport-trailer-number"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.transport_trailer_number') }}</div>

                                                        <div class="input-cargo right input transport-number"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.transport_number_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="wrapper">

                                                        <div class="input-cargo right input loading_type"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.loading_type') }}</div>

                                                        <div class="input-cargo right input rolling_stock_type">-</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.rolling_stock_type') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input name-1"></div>
                                                        <div class="label-cargo right label-block">{{ trans('all.driver') }} ({{ trans('all.full_name') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input input name-2"></div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input phone">-</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.phone') }}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>

                                </td>
                                <td class="panel_item" style="width: 50%; padding-left:25px; padding-bottom: 0px;">
                                    <div class="panel">
                                        <div class="title">
                                            {{ trans('all.payment_information') }}
                                        </div>
                                    </div>
                                    <div class="panel panel-body panel-part-4">
                                        <table style="width: 100%">
                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input payment_type">-</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.payment_type') }}</div>

                                                        <div class="input-cargo right input amount_plan">0</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.amount') }}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input payment_terms">-</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.terms_type') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="panel_item" style="width: 50%; padding-left:25px; padding-top: 0px;">
                                    <div class="panel" style="margin-top:50px;">
                                        <div class="title">
                                            {{ trans('all.comments') }}
                                        </div>
                                    </div>
                                    <div class="panel panel-body panel-part-5" style="padding-bottom:40px; max-height: 80px; line-height: 30px; overflow: hidden">

                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr class="page tr-additional" style="">
                    <td>
                        <table style="width: 100%; margin-right: 80px;">
                            <tr>
                                <td class="panel_item" style="width: 50%; padding-right:25px; padding-bottom: 0px; padding-top:0px;" >
                                    <div class="panel">
                                        <div class="title">
                                            {{ trans('all.additional_rules') }}
                                        </div>
                                    </div>

                                    <div class="panel panel-body">
                                        <table style="width: 100%; height: 130px;">
                                            <tr>
                                                <td>
                                                    @if(isset($fields['order_extra_rules']))
                                                        {{$fields['order_extra_rules']}}
                                                    @else
                                                        {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_extra_rules',$user) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="force-break tr-footer">
                    <td>
                        <table style="width: 100%; margin-right: 80px; margin-top:0px !important; padding-top:0px !important;">
                            <tr>
                                <td class="panel_item" style="width: 50%; padding-right:25px; padding-bottom: 0px; padding-top:20px !important;" >
                                    <div class="panel panel-body">
                                        <table style="width: 100%; height: 690px;">
                                            <tr>
                                                <td>
                                                    <table style="width: 100%; height: 690px;">
                                                        <tr>
                                                            <td style="width: 50%;">
                                                                <div class="h3 footer-title">{{ trans('all.carrier') }}</div>
                                                                <div class="footer-text">
                                                                    <?php /*
                                                                    <div><strong>{{ $users['owner'] ? $users['owner']->name : ''}}.</strong></div>
                                                                    <div><strong>Юр.   адрес:</strong> {{ $users ? $users['owner']->meta_data['index'] : '' }}, {{ $users ? $users['owner']->meta_data['region'] : '' }}.,</div>
                                                                    <div>
                                                                        {{ $users['owner'] ? $users['owner']->meta_data['city'] : '' }},
                                                                        {{ $users['owner'] ? $users['owner']->meta_data['legal_address'] : '' }}
                                                                    </div>
                                                                    <div><strong>Почт. адрес:</strong> {{ $users['owner'] ? $users['owner']->meta_data['index'] : '' }}, {{ $users['owner'] ? $users['owner']->meta_data['region'] : '' }}.,</div>
                                                                    <div>{{ $users['owner'] ? $users['owner']->meta_data['city'] : '' }}</div>
                                                                    <div>Р/с : -</div>
                                                                    <div>код ЕДРПОУ : {{ $users ? $users['owner']->meta_data['egrpou_or_inn'] : '' }}</div>
                                                                    <div>ИНН: -</div>
                                                                    <div>Св-во НДС: -</div>
                                                                    <div>Тел/факс: {{ $users['owner'] ? $users['owner']->phone : '-' }}</div>
*/?>
                                                                </div>
                                                            </td>
                                                            <td style="width: 50%;">
                                                                <div class="h3 footer-title">{{ trans('all.client') }}</div>
                                                                <div class="footer-text">
                                                                    <?php /*
                                                                    <div>{{ $users['client'] ? $users['client']->name : ''}}</div>
                                                                    <div>Тел/факс: {{ $users['client'] ? $users['owner']->phone : '' }}</div>
                                                                    */?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img src="{{ url('img/logo_pdf.png') }}" style="margin-top:70px;" width="300">
                                                            </td>
                                                            <td style="text-align: right">

                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </div>

        <div class="footer_line" style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>
    </div>
@endsection