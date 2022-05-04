<div class="content-box pdf_template pdf_waybill page-indent">

    <table id="table-content" cellpadding="0" cellspacing="0" class="">
        <tr class="header">
            <td style="padding-top: 50px;">
                <table>
                    <tr>
                        <td class="" style="width: 70%">
                            <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                            <div class="title">
                                {{ trans('all.transport_titles') }}<br>
                                @if(isset($order))
                                    # {{ $order->inner_id }} {{ trans('all.from') }} {{ date('d.m.Y', strtotime($order->created_at)) }}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="content__qr-logo" style="">
                                <img class="content__qr-images" src="http://chart.googleapis.com/chart?chs=230x230&cht=qr&chl=">
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td style="width: 25%">
                            <div class="user-signature-top">
                                <span>{{ trans('all.customers') }}:</span>
                                <div class="user-signature-top_lines">
                                </div>
                            </div>
                        </td>
                        <td style="width: 25%">
                            <div class="user-signature-top">
                                <span>{{ trans('all.carrier') }}:</span>
                                <div class="user-signature-top_lines">
                                </div>
                            </div>
                        </td>
                        <td style="width: 25%">
                            <div class="user-signature-top">
                                <span>{{ trans('all.shipper') }}:</span>
                                <div class="user-signature-top_lines">
                                </div>
                            </div>
                        </td>
                        <td style="width: 25%">
                            <div class="user-signature-top">
                                <span>{{ trans('all.consignee') }}:</span>
                                <div class="user-signature-top_lines">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="panel-textarea">


                    <div class="panel-textarea__title">
                        {{ trans('all.order_info') }}:
                    </div>
                    <table>

                        @if(isset($order))
                            @php
                                $addresses = $order->addresses()->get();
                            @endphp

                            @foreach($addresses as $key => $address)
                                <tr>
                                    <td class="title_col" style="width: 20%">
                                        <div>
                                            @if($address->pivot->type == 'loading')
                                                {{ trans('all.date_and_time_loading') }}:
                                            @else
                                                {{ trans('all.date_and_time_unloading') }}:
                                            @endif
                                        </div>
                                    </td>
                                    <td class="title_val" style="width: 20%">
                                        <div>
                                            {{ Carbon\Carbon::parse($address->pivot->date_at)->format('d.m.Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="title_col" style="width: 20%;">
                                        <div>
                                            {{ trans('all.address') }}
                                            @if($address->pivot->type == 'loading')
                                                {{ trans('all.loading_1') }}:
                                            @else
                                                {{ trans('all.unloading_1') }}:
                                            @endif
                                        </div>
                                    </td>
                                    <td class="title_val" style="width: 40%;">
                                        <div>
                                            {{ $address->address }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="title_col" style="width: 20%">
                                    <div>
                                    </div>
                                </td>
                                <td class="title_val" style="width: 20%">
                                    <div>
                                    </div>
                                </td>
                                <td class="title_col" style="width: 20%;">
                                    <div>
                                        {{ trans('all.address') }}
                                    </div>
                                </td>
                                <td class="title_val" style="width: 40%;">
                                    <div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    </table>

                </div>
            </td>
        </tr>


        <tr>
            <td>
                <!-- Block [transport,cargo] -->
                <table>
                    <tr>
                        <td rowspan="3" class="panel-textarea" style="width: 49%;">
                            <div class="panel-textarea__title">
                                {{ trans('all.transport_info') }}:
                            </div>

                            <table>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.driver_fio') }}:</div></td>
                                    <td colspan="3" class="title_val"><div>{{ isset($driverInfo['name']) ? $driverInfo['name'] : '-'}}</div></td>
                                </tr>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.phone') }}:</div></td>
                                    <td colspan="3" class="title_val"><div>{{ isset($driverInfo['phone']) ? $driverInfo['phone'] : '-'}}</div></td>
                                </tr>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.type_ps') }}:</div></td>
                                    <td class="title_val"><div>{{ isset($transport) && $transport !== null ? ($transport->rollingStock ? $transport->rollingStock : '-' ) : '-'}}</div></td>
                                    <td class="title_col"><div>{{ trans('all.loading_type') }}:</div></td>
                                    <td class="title_val"><div>{{ isset($transport) && $transport !== null ? ($transport->loadingType ? $transport->loadingType : '-' ) : '-'}}</div></td>
                                </tr>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.transport_number_2') }}:</div></td>
                                    <td class="title_val"><div>{{ isset($trailer) && $trailer ? $transport->number : '-'}}</div></td>
                                    <td class="title_col"><div>{{ trans('all.transport_trailer_number') }}:</div></td>
                                    <td class="title_val"><div>{{ isset($trailer) && $trailer ? $trailer->number : '-'}}</div></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 2%"></td>
                        <td class="panel-textarea" style="width: 49%">
                            <div class="panel-textarea__title">
                                {{ trans('all.transport_condition_cargo') }}:
                            </div>

                            <table>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.title_condition_cargo') }}</div></td>
                                    <td class="title_val"><div>-</div></td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.number_seal') }}:</div></td>
                                    <td class="title_val"><div>-</div></td>
                                    <td class="title_col"><div></div></td>
                                    <td class="title_val"><div></div></td>
                                </tr>
                                <tr>
                                    <td class="title_col"><div>{{ trans('all.quantity_of_sum') }}:</div></td>
                                    <td class="title_val"><div>-</div></td>
                                    <td class="title_col"><div>{{ trans('all.gross_weight') }}:</div></td>
                                    <td class="title_val"><div>-</div></td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td class="title_col" style="width: 50%"><div>{{ trans('all.driver_fio_got') }}:</div></td>
                                    <td class="title_val" style="width: 50%"><div>-</div></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td><div class="row_empty_spacer"></div></td>
        </tr>
        <tr>
            <td class="panel-textarea" style="height: 150px;">
                <div class="panel-textarea__title">
                    {{ trans('all.bookkeeping') }}:
                </div>

                <table>
                    <tr>
                        <td class="title_col"><div>{{ trans('all.bookkeeping_man_cargo') }}:</div></td>
                        <td class="title_val"><div>-</div></td>
                        <td class="title_col"><div>{{ trans('all.summa_all') }}:</div></td>
                        <td class="title_val"><div>-</div></td>
                        <td class="title_col"><div>{{ trans('all.VAT') }}:</div></td>
                        <td class="title_val"><div>-</div></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><div class="row_empty_spacer"></div></td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="panel-textarea" style="width: 49%">
                            <div class="panel-textarea__title">
                                {{ trans('all.title_transport_service_cargo') }}:
                            </div>
                            <div class="text">
                                {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_services', $user) }}
                            </div>

                        </td>
                        <td style="width: 2%"></td>
                        <td class="panel-textarea" style="width: 49%">
                            <div class="panel-textarea__title">
                                {{ trans('all.documents_title_cargo') }}:
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><div class="row_empty_spacer"></div></td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="panel-textarea" style="width: 32%; height: 250px;">
                            <div class="panel-textarea__title">
                                {{ trans('all.title_confirm') }}
                                @if(isset($fake_sign) && $fake_sign === true || 1==1)
                                    <p>Подписано КЕП. Подписант: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::DRIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::DRIVER]->commonName_1 : '-' }}</p>
                                    <p>Организация: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::DRIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::DRIVER]->organizationName : '-' }}</p>
                                    <p>Сертификат выдан:  {{ isset($signatures_roles[\App\Enums\UserRoleEnums::DRIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::DRIVER]->commonName : '-' }}</p>
                                @endif
                            </div>
                        </td>
                        <td style="width: 2%"></td>
                        <td class="panel-textarea" style="width: 32%">
                            <div class="panel-textarea__title">
                                {{ trans('all.title_confirm_cargo') }}
                                @if(isset($fake_sign) && $fake_sign === true || 1==1)
                                    <p>Подписано КЕП. Подписант: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]->commonName_1 : '-' }}</p>
                                    <p>Организация: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]->organizationName : '-' }}</p>
                                    <p>Сертификат выдан:  {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_LOADER]->commonName : '-' }}</p>
                                @endif
                            </div>
                        </td>
                        <td style="width: 2%"></td>
                        <td class="panel-textarea" style="width: 32%">
                            <div class="panel-textarea__title">
                                {{ trans('all.title_confirm_cargo_step') }}
                                @if(isset($fake_sign) && $fake_sign === true || 1==1) 
                                    <p>Подписано КЕП. Подписант: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]->commonName_1 : '-' }}</p>
                                    <p>Организация: {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]->organizationName : '-' }}</p>
                                    <p>Сертификат выдан:  {{ isset($signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]) ? $signatures_roles[\App\Enums\UserRoleEnums::CARGO_RECEIVER]->commonName : '-' }}</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>

    <div class="page-break"></div>

<div class="footer_line" style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>

</div>

<div class="content-box pdf_template pdf_waybill page-indent">
    <table id="table-content" cellpadding="0" cellspacing="0" class="">
        <tr class="header">
            <td style="padding-top: 50px;">
                <table>
                    <tr>
                        <td class="" style="width: 70%">
                            <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                            <div class="title">
                                {{ trans('all.transport_titles') }}<br>
                                @if(isset($order))
                                    # {{ $order->inner_id }} {{ trans('all.from') }} {{ date('d.m.Y', strtotime($order->created_at)) }}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="content__qr-logo" style="">
                                <img class="content__qr-images" src="http://chart.googleapis.com/chart?chs=230x230&cht=qr&chl=">
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="panel-textarea">
                <div class="panel-textarea_col_inner" style="margin-top: 20px;">
                    <span>{{trans('all.messages.headers')}}&nbsp;</span>
                    <span class="text_underline">tttttttttttttttttttttttttt</span>
                    <span >&nbsp;{{trans('all.messages.headers_view')}}&nbsp;</span>
                    <span class="text_underline">tttttttttttttttttttttttttt</span>
                    <span>&nbsp;{{trans('all.messages.headers_transport_')}}&nbsp;</span>
                    <span class="text_underline">tttttttttttt</span>
                    <span>{{trans('all.messages.headers_transport_number')}}.</span>
                </div>
            </td>
        </tr>
        <tr>
            <td><div class="row_empty_spacer"></div></td>
        </tr>
        <tr>
            <td class="panel-textarea">
                <div class="panel-textarea__title">
                    {{ trans('all.about_info_cargo') }}:
                </div>

                <table class="panel-textarea_col_inner">
                    <thead>
                        <tr class="row-padding-bottom-head">
                            <th>#</th>
                            <th>{{ trans('all.cargo_full_name') }}</th>
                            <th>{{ trans('all.documents_titles_cargo') }}</th>
                            <th>{{ trans('all.package_type_2') }}</th>
                            <th>{{ trans('all.units') }}</th>
                            <th>{{ trans('all.whole_time_minute') }}</th>
                            <th>{{ trans('all.quantity_of_sum') }}</th>
                            <th>{{ trans('all.gross_weight') }}</th>
                            <th>{{ trans('all.price_not_nds_all') }}</th>
                            <th>{{ trans('all.summa_nds') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($order) && $order)
                        <tr class="row-padding-bottom">
                            <td class="text-center" style="padding-bottom: 1em;"></td>
                            <td class="text-center">{{ $order->cargo['name'] ?? '' }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        @endif
                    <tr>
                        <td colspan="10" style="height: 30px;"></td>
                    </tr>
                        <tr>
                            <td colspan="6" class="text-strong">{{ trans('all.counts_all') }}</td>
                            <td class="text-center text-strong">0</td>
                            <td class="text-center text-strong">0</td>
                            <td class="text-center text-strong">0</td>
                            <td class="text-center text-strong">0</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td><div class="row_empty_spacer"></div></td>
        </tr>
        <tr>
            <td class="panel-textarea">
                <div class="panel-textarea__title">
                    {{ trans('all.name_services_cargo') }}:
                </div>

                <table class="panel-textarea_col_inner">
                    <thead>
                        <tr class="row-padding-bottom-head">
                            <th>{{ trans('all.name_operations') }}</th>
                            <th>{{ trans('all.name_arrival') }}</th>
                            <th>{{ trans('all.name_departure') }}</th>
                            <th>{{ trans('all.name_plain') }}</th>
                            <th>{{ trans('all.gross_weight') }}</th>
                            <th>{{ trans('all.name_responsible_persons') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row-padding-bottom">
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 30px;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-strong">{{ trans('all.counts_all') }}</td>
                            <td class="text-center text-strong">0</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </td>
        </tr>
    </table>
</div>