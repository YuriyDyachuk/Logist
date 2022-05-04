<div class="content-box pdf_template pdf_order_request page-indent">

            <table id="table-content" cellpadding="0" cellspacing="0" class="">
                <tr class="header">
                    <td style="padding-top: 50px;">
                        <table>
                            <tr>
                                <td class="" style="width: 70%">
                                    <img class="content__logos" src="{{ url('img/logo_pdf.png') }}">
                                    <div class="title">
                                        {{ trans('all.pdf_transport_service') }}<br>
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
                                <td style="width: 30%">
                                    <div class="user-signature-top">
                                        <span>{{ trans('all.customers') }}:</span>
                                        <div class="user-signature-top_lines">
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 30%">
                                    <div class="user-signature-top">
                                        <span>{{ trans('all.carrier') }}:</span>
                                        <div class="user-signature-top_lines">
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 30%">
                                    <div class="user-signature-top">
                                        <span>{{ trans('all.manager') }}:</span>
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

                        <!-- block dop-info textarea -->
                        <div class="panel-textarea" style="">
                            <div class="panel-textarea__title">
                                {{ trans('all.contract_subject') }}:
                            </div>
                            <div class="text">{{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_subject', $user) }}</div>
                        </div>
                        <!-- end block dop-info textarea -->
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
                        <div class="panel-textarea">
                            <div class="panel-textarea__title">
                                {{ trans('all.cargo_information') }}:
                            </div>
                            <table>
                                <tr>
                                    <td style="width: 50%;">
                                        <table>
                                            <tr>
                                                <td class="title_col" style="width: 20%"><div>{{ trans('all.cargo') }}:</div></td>
                                                <td class="title_val" style="width: 30%"><div>{{ $order->cargo['name'] ?? '' }}</div></td>
                                                <td class="title_col" style="width: 20%"><div>{{ trans('all.length') }}:</div></td>
                                                <td class="title_val" style="width: 30%"><div>{{ $order->cargo['length'] ?? 0 }}{{ trans('all.cm') }}</div></td>
                                            </tr>
                                            <tr>
                                                <td class="title_col"><div>{{ trans('all.weight') }}:</div></td>
                                                <td class="title_val"><div>{{ $order->cargo['weight'] ?? 0 }} {{ trans('all.kg') }}</div></td>
                                                <td class="title_col"><div>{{ trans('all.width') }}:</div></td>
                                                <td class="title_val"><div>{{ $order->cargo['width'] ?? 0 }}{{ trans('all.cm') }}</div></td>
                                            </tr>
                                            <tr>
                                                <td class="title_col"><div>{{ trans('all.volume') }}:</div></td>
                                                <td class="title_val"><div>{{ $order->cargo['volume'] ?? 0 }} {{ trans('all.m') }}<sup>3</sup></div></td>
                                                <td class="title_col"><div>{{ trans('all.height') }}:</div></td>
                                                <td class="title_val"><div>{{ $order->cargo['height'] ?? 0 }} {{ trans('all.cm') }}</div></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 50%;">
                                        <table>
                                            <tr>
                                                <td class="title_col" style="width: 70%"><div>{{ trans('all.quantity_of_packages_2') }}:</div></td>
                                                <td class="title_val" style="width: 30%"><div>{{ $order->cargo['places'] ?? '-' }}</div></td>
                                            </tr>
                                        </table>

                                        <table>
                                            <tr>
                                                <td class="title_col" style="width: 30%"><div>{{ trans('all.hazard_class') }}:</div></td>
                                                <td class="title_val" colspan="3"><div>@if(isset($order) && $order->cargo->hazardClass)@if(array_key_exists($order->cargo->hazardClass->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->hazardClass->slug)}} @else {{ $order->cargo->hazardClass->name }} @endif @else -@endif</div></td>
                                            </tr>
                                            <tr>
                                                <td class="title_col" style="width: 30%"><div>{{ trans('all.package_type_2') }}:</div></td>
                                                <td class="title_val" style="width: 20%"><div>@if(isset($order) && $order->cargo->packageType) @if(array_key_exists($order->cargo->packageType->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->packageType->slug)}} @else {{ $order->cargo->packageType->name }} @endif @else - @endif</div></td>
                                                <td class="title_col" style="width: 30%"><div>{{ trans('all.temp_mode') }}:</div></td>
                                                <td class="title_val" style="width: 20%"><div>{{ $order->cargo['temperature'] ?? '-' }}</div></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- end block cargo inform-->
                    </td>
                </tr>

                <tr>
                    <td>
                        <!-- Block [transport,payments,comments] -->
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
                                        {{ trans('all.payment_information') }}:
                                    </div>

                                    <table>
                                        <tr>
                                            <td class="title_col" style="width: 30%"><div>{{ trans('all.terms_type') }}:</div></td>
                                            <td class="title_val" style="width: 70%; text-align: left;"><div>{{ isset($order) && $order->payment_term ? trans('all.order_'.$order->payment_term->name) : '-'}}</div></td>
                                        </tr>
                                    </table>

                                    <table>

                                        <tr>
                                            <td class="title_col"><div>{{ trans('all.amount') }}:</div></td>
                                            <td class="title_val"><div>{{ (isset($performer) && $performer !== null && $performer->amount_plan) ? $performer->amount_plan.' '.$order->currency : '0'}}</div></td>
                                            <td class="title_col"><div>{{ trans('all.payment_type') }}:</div></td>
                                            <td class="title_val"><div>{{ (isset($performer) && $performer !== null && $performer->payment_type) ? trans('all.order_'.$performer->payment_type->name) : '-'}}</div></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 2%"></td>
                                <td style="width: 49%">
                                    <div class="row_empty_spacer"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 2%"></td>
                                <td class="panel-textarea" style="width: 49%">
                                    <div class="panel-textarea__title">
                                        {{ trans('all.comment') }}:
                                    </div>
                                    <div class="text">
                                        <span>{{ isset($order) ? $order->comment : '' }}</span>
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
                        <!-- block dop-info textarea -->
                        <div class="panel-textarea" style="min-height: 100px;">
                            <div class="panel-textarea__title">
                                {{ trans('all.additional_rules') }}:
                            </div>

                            <div class="text">
                                {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_extra_rules', $user) }}
                            </div>

                        </div>
                        <!-- end block dop-info textarea -->
                    </td>
                </tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="panel-textarea panel-textarea-col" style="width: 49%">

                                        <div class="panel-textarea__title color_style2">
                                            {{ trans('all.carrier') }}
                                        </div>
                                    <div class="panel-textarea_col_inner">
                                        <div class="line"><span class="company_strong">{{ $users['owner']->name ?? ''}}</span></div>
                                        @if(isset($users['owner']->meta_data['type']) && $users['owner']->meta_data['type'] == 'individual')
                                            <div class="line"><span class="company_strong">{{ trans('all.address') }}:</span>
                                                <span>
                                                @if(isset($users['owner']->meta_data['address_index']))
                                                        {{$users['owner']->meta_data['address_country'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_index'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_region'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_city'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_street'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_number'] ?? ''}}

                                                    @elseif(isset($users['owner']->meta_data['address_legal_index']))
                                                        -
                                                    @endif
                                            </span>
                                            </div>
                                        @else
                                            <div class="line"><span class="company_strong">{{ trans('all.legal_address_short') }}:</span>
                                                <span>
                                                    @if(isset($users['owner']->meta_data['address_legal_index']))
                                                        {{$users['owner']->meta_data['address_legal_country'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_legal_index'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_legal_region'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_legal_city'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_legal_street'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_legal_number'] ?? ''}}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        <div class="line"><span class="company_strong">{{ trans('all.address_post') }}:</span>
                                            <span>
                                                @if(isset($users['owner']->meta_data['address_post_index']))
                                                        {{$users['owner']->meta_data['address_post_country'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_post_index'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_post_region'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_post_city'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_post_street'] ?? ''}},
                                                        {{$users['owner']->meta_data['address_post_number'] ?? ''}}
                                                @else
                                                    -
                                                @endif

                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.payment_account_min') }}:</span>
                                            <span>
                                                {{ (isset($users['owner']) && isset($users['owner']->meta_data['payment_account'])) ? $users['owner']->meta_data['payment_account'] : '' }}
                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.code_edrpou') }}:</span>
                                            <span>
                                                {{ (isset($users['owner']) && isset($users['owner']->meta_data['egrpou'])) ? $users['owner']->meta_data['egrpou'] : '' }}
                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.code_mfo') }}:</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.inn') }}:</span> <span>{{$users['owner']->meta_data['inn'] ?? ''}}</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.VAT_certificate_short') }}:</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.phone_min') }}:</span> <span>{{ $users['owner']->phone ?? ''}}</span></div>
                                        @if(!empty($signatures) && $users['owner'] && isset($signatures[$users['owner']->id]))
                                            <div class="sign"><img src="{{ url('storage/documents/'.($signatures[$users['owner']->id]->filename)) }}"></div>
                                        @endif
                                    </div>
                                </td>
                                <td style="width: 2%;"></td>
                                <td class="panel-textarea panel-textarea-col" style="width: 49%">
                                        <div class="panel-textarea__title color_style2">
                                            {{ trans('all.customers') }}
                                        </div>
                                    <div class="panel-textarea_col_inner">
                                        <div class="line"><span class="company_strong">{{ $users['client']->name ?? ''}}</span></div>
                                        @if(isset($users['client']->meta_data['type']) && $users['client']->meta_data['type'] == 'individual')
                                            <div class="line"><span class="company_strong">{{ trans('all.address') }}:</span>
                                                <span>
                                                @if(isset($users['client']->meta_data['address_index']))
                                                        {{$users['client']->meta_data['address_country'] ?? ''}},
                                                        {{$users['client']->meta_data['address_index'] ?? ''}},
                                                        {{$users['client']->meta_data['address_region'] ?? ''}},
                                                        {{$users['client']->meta_data['address_city'] ?? ''}},
                                                        {{$users['client']->meta_data['address_street'] ?? ''}},
                                                        {{$users['client']->meta_data['address_number'] ?? ''}}
                                                @else
                                                        -
                                                @endif
                                            </span>
                                            </div>
                                        @else
                                            <div class="line"><span class="company_strong">{{ trans('all.legal_address_short') }}:</span>
                                                <span>
                                                    @if(isset($users['client']->meta_data['address_legal_index']))
                                                        {{$users['client']->meta_data['address_legal_country'] ?? ''}},
                                                        {{$users['client']->meta_data['address_legal_index'] ?? ''}},
                                                        {{$users['client']->meta_data['address_legal_region'] ?? ''}},
                                                        {{$users['client']->meta_data['address_legal_city'] ?? ''}},
                                                        {{$users['client']->meta_data['address_legal_street'] ?? ''}},
                                                        {{$users['client']->meta_data['address_legal_number'] ?? ''}}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        <div class="line"><span class="company_strong">{{ trans('all.address_post') }}:</span>
                                            <span>
                                                @if(isset($users['client']->meta_data['address_post_index']))
                                                    {{$users['client']->meta_data['address_post_country'] ?? ''}},
                                                    {{$users['client']->meta_data['address_post_index'] ?? ''}},
                                                    {{$users['client']->meta_data['address_post_region'] ?? ''}},
                                                    {{$users['client']->meta_data['address_post_city'] ?? ''}},
                                                    {{$users['client']->meta_data['address_post_street'] ?? ''}},
                                                    {{$users['client']->meta_data['address_post_number'] ?? ''}}
                                                @else
                                                    -
                                                @endif

                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.payment_account_min') }}:</span>
                                            <span>
                                                {{ (isset($users['client']) && isset($users['client']->meta_data['payment_account'])) ? $users['client']->meta_data['payment_account'] : '' }}
                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.code_edrpou') }}:</span>
                                            <span>
                                                {{ (isset($users['client']) && isset($users['client']->meta_data['egrpou'])) ? $users['client']->meta_data['egrpou'] : '' }}
                                            </span>
                                        </div>
                                        <div class="line"><span class="company_strong">{{ trans('all.code_mfo') }}:</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.inn') }}:</span> <span>{{ (isset($users['client']) && isset($users['client']->meta_data['inn'])) ? $users['client']->meta_data['inn'] : ''}}</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.VAT_certificate_short') }}:</span></div>
                                        <div class="line"><span class="company_strong">{{ trans('all.phone_min') }}:</span> <span> {{ (isset($users['client']) && isset($users['client']->phone)) ? $users['client']->phone : ''}}</span></div>
                                        @if(!empty($signatures) && $users['client'] && isset($signatures[$users['client']->id]))
                                            <div class="line"> <img src="{{ url('storage/documents/'.($signatures[$users['client']->id]->filename)) }}"></div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>


                    </td>
                </tr>
                {{--
                                                <tr class="row_empty_spacer">
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td class="panel-textarea panel-textarea-col" style="width: 49%">
                                                                    <div class="panel-textarea_col_inner" style="margin-top: 20px">
                                                                        <div class="line"><span class="">{{ trans('all.document_on_sign_kep') }} {{ trans('all.document_persona') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.organizations') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.times') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.certificate') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.serial_number') }}:</span></div>

                                                                    </div>
                                                                </td>
                                                                <td style="width: 2%;"></td>
                                                                <td class="panel-textarea panel-textarea-col" style="width: 49%">
                                                                    <div class="panel-textarea_col_inner" style="margin-top: 20px">
                                                                        <div class="line"><span class="">{{ trans('all.document_on_sign_kep') }} {{ trans('all.document_persona') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.organizations') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.times') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.certificate') }}:</span></div>
                                                                        <div class="line"><span>{{ trans('all.serial_number') }}:</span></div>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr class="row_empty_spacer">
                                                    <td></td>
                                                </tr>
                                                <tr class="row_empty_spacer">
                                                    <td></td>
                                                </tr>
                                --}}

            </table>

    <div class="footer_line"
         style="background-color: #007cff; height: 15px; position: fixed; bottom: 0px; width: 100%"></div>
</div>