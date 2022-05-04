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
                                    <span class="request">{{ $order->inner_id }}({{ $order->id }}) </span>
                                    <span class="from">{{ trans('all.from') }} </span>
                                    <span class="slash">{{ date('d', strtotime($order->created_at)) }} </span>
                                    <span class="slash"> / </span>
                                    <span class="slash">{{ trans('all.month_'.date('n', strtotime($order->created_at))) }} </span>
                                    <span class="year">{{ date('Y', strtotime($order->created_at)) }} {{trans('all.year_short')}} </span>
                                </div>
                                <div>
                                    <span class="ttn">{{ trans('all.pdf_transport_service') }}</span>
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
                                <td class="value"><div class="dashed_bottom">{{ $users['owner']->name }}</div></td>
                                <td class="photo" rowspan="3">
                                    @if($users['owner']->getAvatar() != '' && app_avatar_exists($users['owner']->getAvatar()))
                                        <img height="200" width="200" src="{{ app_avatar_url($users['owner']->getAvatar()) }}" alt="img">
                                    @else
                                        {!! trans('all.logo_placeholder') !!}
                                    @endif
                                </td>
                            </tr>
                            <tr class="page tr-client">
                                <td class="role">{{ trans('all.client') }} :</td>
                                <td class="value"><div class="dashed_bottom">{{ $users['client'] ? $users['client']->name : '-'}}</div></td>
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
                                {{ trans('all.contract_subject') }}
                            </div>
                        </div>

                        <div class="panel">
                            <div style="/*height: 80px;*/">
                                {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_subject', $user) }}
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
                            @php
                            $pages = 1;
                            $addresses = $order->addresses()->get();
                            if(count($addresses) > 2)
                            $pages = 2;
                            @endphp


                            <table style="width: 100%">
                                @foreach($addresses as $key => $address)

                                    {{--
                                                                                @if($key >= 2)
                                                                                    @continue
                                                                                @endif
                                    --}}


                                    <tr class="row_address">
                                        <td class="label_date label-block">
                                            <div class="img_wrap"><img src="{{ url('img/calendar.png') }}" height="35" alt="img"></div>
                                            {{ trans('all.date_and_time') }}
                                            @if($address->pivot->type == 'loading')
                                                {{ trans('all.loading_1') }}
                                            @else
                                                {{ trans('all.unloading_1') }}
                                            @endif
                                        </td>
                                        <td class="input_date">
                                            <div class="input input_type_date">{{ $address->pivot->date_at }}</div>
                                        </td>
                                        <td class="label_address label-block">
                                            <div class="img_wrap" style="text-align: right; margin-left:180px"><img src="{{ url('img/address.png') }}" height="35" alt="img"></div>
                                            {{ trans('all.address') }}
                                            @if($address->pivot->type == 'loading')
                                                {{ trans('all.loading_1') }}
                                            @else
                                                {{ trans('all.unloading_1') }}
                                            @endif
                                        </td>
                                        <td class="input_address">
                                            <div class="input">{{ $address->address }}</div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                                        <div class="input-cargo right input">{{ $order->cargo['name'] }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.cargo') }}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input">{{ $order->cargo['length'] ?? 0 }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.length') }} ({{ trans('all.cm') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input">{{ $order->cargo['weight'] ?? 0 }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.weight') }} ({{ trans('all.kg') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input">{{ $order->cargo['height'] ?? 0 }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.height') }} ({{ trans('all.cm') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input">{{ $order->cargo['volume'] ?? 0 }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.volume') }} (м3)</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                                <td class="default">
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input">{{ $order->cargo['width'] ?? 0 }}</div>
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
                                                        <div class="input-cargo right input pack-type">@if($order->cargo->packageType) @if(array_key_exists($order->cargo->packageType->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->packageType->slug)}} @else {{ $order->cargo->packageType->name }} @endif @else - @endif</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.package_type_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input temperature_mode">{{ $order->cargo['temperature'] ?? '-' }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.temperature_mode') }}</div>

                                                        <div class="input-cargo right input quantity_of_packages">{{ $order->cargo['places'] ?? '-' }}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.quantity_of_packages_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input hazard">@if($order->cargo->hazardClass)@if(array_key_exists($order->cargo->hazardClass->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->hazardClass->slug)}} @else {{ $order->cargo->hazardClass->name }} @endif @else -@endif</div>
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
                                                        <div class="input-cargo right input transport-trailer-number">{{ $trailer ? $trailer->number : ''}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.transport_trailer_number') }}</div>

                                                        <div class="input-cargo right input transport-number">{{ $trailer ? $transport->number : ''}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.transport_number_2') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="wrapper">

                                                        <div class="input-cargo right input loading_type">{{ $transport ? '-' : '-'}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.loading_type') }}</div>

                                                        <div class="input-cargo right input rolling_stock_type">{{ $transport ? (isset($transport->rollingStockType()->first()->name) ? trans('handbook.'.$transport->rollingStockType()->first()->name) : '-' ) : '-'}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.rolling_stock_type') }}</div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input name-1">{{ isset($names[0]) ? $names[0] : ''}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.driver') }} ({{ trans('all.full_name') }})</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input input name-2">{{ isset($names[1]) ? $names[1] : ''}}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input phone">{{ $users['owner'] ? $users['owner']->phone : '-'}}</div>
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
                                                        <div class="input-cargo right input payment_type">{{ $order->payment_type ? trans('all.order_'.$order->payment_type->name) : '-'}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.payment_type') }}</div>

                                                        <div class="input-cargo right input amount_plan">{{ $order->amount_plan ? $order->amount_plan.' '.$order->currency : '0'}}</div>
                                                        <div class="label-cargo right label-block">{{ trans('all.amount') }}</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="wrapper">
                                                        <div class="input-cargo right input payment_terms">{{ $order->payment_term ? trans('all.order_'.$order->payment_term->name) : '-'}}</div>
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
                                        {{ $order->comment ? $order->comment : '' }}
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
                                                    {{ App\Models\Document\DocumentValues::getValueBySlug($id, 'order_subject', $user) }}
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
                                                            {{--<td style="width: 50%;">--}}
                                                                {{--<div class="h3 footer-title">{{ trans('all.carrier') }}</div>--}}
                                                                {{--<div class="footer-text">--}}
                                                                    {{--<div><strong>{{ $users['owner'] ? $users['owner']->name : ''}}.</strong></div>--}}
                                                                    {{--<div><strong>{{trans('all.legal_address_short')}}:</strong> {{ ($users['owner'] && isset($users['owner']->meta_data['index'])) ? $users['owner']->meta_data['index'] : '' }}, {{ ($users['owner'] && isset($users['owner']->meta_data['region'])) ? $users['owner']->meta_data['region'] : '' }}.,</div>--}}
                                                                    {{--<div>--}}
                                                                        {{--{{ ($users['owner'] && isset($users['owner']->meta_data['city'])) ? $users['owner']->meta_data['city'] : '' }},--}}
                                                                        {{--{{ ($users['owner'] && isset($users['owner']->meta_data['legal_address'])) ? $users['owner']->meta_data['legal_address'] : '' }}--}}
                                                                    {{--</div>--}}
                                                                    {{--<div><strong>{{trans('all.postal_address_short')}}:</strong> {{ ($users['owner'] && isset($users['owner']->meta_data['index'])) ? $users['owner']->meta_data['index'] : '' }}, {{ ($users['owner'] && isset($users['owner']->meta_data['region']) )? $users['owner']->meta_data['region'] : '' }}.,</div>--}}
                                                                    {{--<div>{{ ($users['owner'] && isset($users['owner']->meta_data['city']) ) ? $users['owner']->meta_data['city'] : '' }}</div>--}}
                                                                    {{--<div>Р/с : -</div>--}}
                                                                    {{--<div>{{trans('all.EDRPOU')}} : {{ ($users['owner'] && isset($users['owner']->meta_data['egrpou_or_inn'])) ? $users['owner']->meta_data['egrpou_or_inn'] : '' }}</div>--}}
                                                                    {{--<div>{{trans('all.inn')}}: -</div>--}}
                                                                    {{--<div>{{trans('all.VAT_certificate_short')}}: -</div>--}}
                                                                    {{--<div>{{trans('all.tel_fax')}}: {{ $users['owner'] ? $users['owner']->phone : '-' }}</div>--}}

                                                                {{--</div>--}}
                                                            {{--</td>--}}
                                                            <td style="width: 50%;">
                                                                <div class="h3 footer-title">{{ trans('all.carrier') }}</div>
                                                                <div class="footer-text">
                                                                    <div><strong>{{ $users['owner']->name ?? ''}}.</strong></div>
                                                                    <div><strong>{{trans('all.legal_address_short')}}:</strong>
                                                                        {{$users['owner']->meta_data['address_country'] ?? ''}},
                                                                        {{$users['owner']->meta_data['address_index'] ?? ''}},
                                                                        {{$users['owner']->meta_data['address_region'] ?? ''}},
                                                                        {{$users['owner']->meta_data['address_city'] ?? ''}},
                                                                        {{$users['owner']->meta_data['address_street'] ?? ''}},
                                                                        {{$users['owner']->meta_data['address_number'] ?? ''}}
                                                                    </div>

                                                                        @if(isset($users['owner']->meta_data['type']) && $users['owner']->meta_data['type'] == 'individual')

                                                                        @endif



{{--                                                                        {{ ($users['owner'] && isset($users['owner']->meta_data['index'])) ? $users['owner']->meta_data['index'] : '' }}, {{ ($users['owner'] && isset($users['owner']->meta_data['region'])) ? $users['owner']->meta_data['region'] : '' }}.,</div>--}}
                                                                    {{--<div>--}}
                                                                        {{--{{ ($users['owner'] && isset($users['owner']->meta_data['city'])) ? $users['owner']->meta_data['city'] : '' }},--}}
                                                                        {{--{{ ($users['owner'] && isset($users['owner']->meta_data['legal_address'])) ? $users['owner']->meta_data['legal_address'] : '' }}--}}
                                                                    {{--</div>--}}
                                                                    @if(isset($users['owner']->meta_data['type']) && $users['owner']->meta_data['type'] == 'company')

                                                                        @if(isset($users['owner']->meta_data['legal_address_country']))
                                                                        <div><strong>{{trans('all.legal_address')}}:</strong>
                                                                            {{$users['owner']->meta_data['legal_address_country'] ?? ''}},
                                                                            {{$users['owner']->meta_data['legal_address_index'] ?? ''}},
                                                                            {{$users['owner']->meta_data['legal_address_region'] ?? ''}},
                                                                            {{$users['owner']->meta_data['legal_address_city'] ?? ''}},
                                                                            {{$users['owner']->meta_data['legal_address_street'] ?? ''}},
                                                                            {{$users['owner']->meta_data['legal_address_number'] ?? ''}}
                                                                        </div>
                                                                        @endif

                                                                    @if(!isset($users['owner']->meta_data['address_country']))
                                                                            <div><strong>{{trans('all.address')}}:</strong>
                                                                                {{$users['owner']->meta_data['address_country'] ?? ''}},
                                                                                {{$users['owner']->meta_data['address_index'] ?? ''}},
                                                                                {{$users['owner']->meta_data['address_region'] ?? ''}},
                                                                                {{$users['owner']->meta_data['address_city'] ?? ''}},
                                                                                {{$users['owner']->meta_data['address_street'] ?? ''}},
                                                                                {{$users['owner']->meta_data['address_number'] ?? ''}}
                                                                            </div>

                                                                    @endif

                                                                        <div><strong>{{trans('all.postal_address_short')}}:</strong>
                                                                            {{$users['owner']->meta_data['post_address_country'] ?? ''}},
                                                                            {{$users['owner']->meta_data['post_address_index'] ?? ''}},
                                                                            {{$users['owner']->meta_data['post_address_region'] ?? ''}},
                                                                            {{$users['owner']->meta_data['post_address_city'] ?? ''}},
                                                                            {{$users['owner']->meta_data['post_address_street'] ?? ''}},
                                                                            {{$users['owner']->meta_data['post_address_number'] ?? ''}}
                                                                        </div>



                                                                    @endif

                                                                    {{--<div>{{ ($users['owner'] && isset($users['owner']->meta_data['city']) ) ? $users['owner']->meta_data['city'] : '' }}</div>--}}
                                                                    <div>Р/с : {{$users['owner']->meta_data['payment_account'] ?? '-'}}</div>
                                                                    <div>{{trans('all.EDRPOU')}} : {{ ($users['owner'] && isset($users['owner']->meta_data['egrpou_or_inn'])) ? $users['owner']->meta_data['egrpou_or_inn'] : '' }}</div>
                                                                    <div>{{trans('all.inn')}}: {{$users['owner']->meta_data['inn'] ?? ''}}</div>
{{--                                                                    <div>{{trans('all.VAT_certificate_short')}}: -</div>--}}
                                                                    <div>{{trans('all.tel_fax')}}: {{ $users['owner']->phone ?? '-' }}</div>
                                                                    @if(!empty($signatures) && isset($signatures[$users['owner']->id]))
                                                                        <img src="{{ url('storage/documents/'.($signatures[$users['owner']->id]->filename)) }}">
                                                                    @endif

                                                                </div>
                                                            </td>
                                                            <td style="width: 50%;">
                                                                <div class="h3 footer-title">{{ trans('all.client') }}</div>
                                                                <div class="footer-text">
{{--                                                                    {{var_dump($users['client'])}}--}}
                                                                    <div>{{ $users['client'] ? $users['client']->name : ''}}</div>
                                                                    <div>{{trans('all.tel_fax')}}: {{ $users['client'] ? $users['owner']->phone : '' }}</div>
                                                                    @if(isset($users['client']))
                                                                        <div><strong>{{trans('all.legal_address_short')}}:</strong>
                                                                            {{$users['client']->meta_data['address_country'] ?? ''}},
                                                                            {{$users['client']->meta_data['address_index'] ?? ''}},
                                                                            {{$users['client']->meta_data['address_region'] ?? ''}},
                                                                            {{$users['client']->meta_data['address_city'] ?? ''}},
                                                                            {{$users['client']->meta_data['address_street'] ?? ''}},
                                                                            {{$users['client']->meta_data['address_number'] ?? ''}}
                                                                        </div>
                                                                        @if(!empty($signatures) && isset($signatures[$users['client']->id]))
                                                                            <img src="{{ url('storage/documents/'.($signatures[$users['client']->id]->filename)) }}">
                                                                        @endif

                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img src="{{ url('img/logo_pdf.png') }}" style="margin-top:70px;" width="300">
                                                            </td>
                                                            <td style="text-align: right">
                                                                <img src="http://chart.googleapis.com/chart?chs=230x230&cht=qr&chl={{ url('/order/'.$order->id) }}">
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