@forelse ($transports as $key=>$transport)
    {{--{{var_dump($transport->rollingStockType ? $transport->rollingStockType->name : 'ttt')}}--}}
    @php $typeName = $transport->getTypeName() @endphp
    <div class="panel-group transition" id="transport{{ $transport->id }}">
        <div class="panel panel-transport">
            <div class="panel-heading panel-heading-trans">
                <div class="row">
                    {{-- FIRST COLUMN --}}
                    <div class="col-sm-3 col-type-transport br">
                        <div class="row">

                                <div class="col-xs-12 no-padding">

                                    <h3 class="clearfix">
                                        <span class="block-id" style="display: inline-block; max-width: 60px">
                                            <span class="num-trans">{{ '#' .($transports->firstItem() + $key) }}</span>
                                        </span>
                                        <span>{{ trans('handbook.' . $transport->category_name) }}</span>
                                    </h3>

                                    @if($partner_transport != 0 && isset($transport->user->meta_data['delegate_name']))
                                        <p>{{$transport->user->name}}</p>
                                    @endif

                                    @if($transport->isTrailer && $transport->status_name == 'inactive')
                                        <span class="label label-status label-danger">{{ trans('all.inactive') }}</span>

                                    @elseif($transport->isTrailer && $transport->status_name == 'free')
                                        <span class="label label-status label-warning">{{ trans('all.free') }}</span>

                                    @elseif($transport->isTrailer && $transport->status_name == 'on_flight')
                                        <span class="label label-status label-success">{{ trans('all.on_the_road') }}</span>

                                    @elseif(!$transport->isTrailer && $transport->status_name == 'on_flight' && $transport->getAttachedOrder() !== null)
                                        <a href="{{route('orders.show', $transport->getAttachedOrder()->id)}}" class="label label-status label-success">{{ trans('all.on_the_road') }}</a>
                                    @elseif(!$transport->isTrailer)
                                        <div class="dropdown status-dropdown">
                                            <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                            <span class="label label-status label-{{ $transport->status_class }}"
                                                  data-status="{{ $transport->status_id }}"
                                            >{{ trans('all.' . $transport->status_name) }}</span><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                @foreach($statuses as $status)
                                                    @if($status->id != $transport->status_id)
                                                        <li><span class="label label-status label-{{$status->name == 'free'?'primary':'warning'}}"
                                                                  data-trans-status="{{ $transport->id.'-'.$status->id }}"
                                                            >
                                                    {{ trans("all.{$status->name}") }}</span></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>

                                <div class="col-xs-12 no-padding img-block ">

                                    <div>
                                    @php
                                        $fileName = ($typeName == 'tractor' && $transport->isTrailer) ? 'coupling' : $typeName;
                                    @endphp

                                    @if($typeName == 'truck' || $typeName == 'tractor' || $typeName == 'special_machinery')
                                        <span class="id-trans" >{{ 'ID ' .  $transport->inner_id }}</span>
                                    @endif


                                    @if($transport->isConnected())
                                        <!--<div style="line-height: 12px; color:#008d4c; display: inline-block" >{{ trans("all.traced") }}&nbsp;</div>-->
                                    @else
                                        <!--<div style="line-height: 12px; color:#ff2222; display: inline-block">{{ trans("all.not_traced") }}&nbsp</div>-->
                                    @endif

                                    </div>

                                    <div>
                                        @if($typeName == 'truck' && $transport->trailer)
                                            @if(!is_null($transport->rolling_stock_type_id))
                                                <div class="img-trans img-truck-trailer" style="display: inline-block;"></div>
                                            @else
                                                <div class="img-trans coupling"
                                                     style="display: inline-block; background-image: url({{ url('/main_layout/images/svg/coupling.svg') }})"></div>
                                            @endif
                                        @else
                                            @if($transport->trailer === null && $transport->rolling_stock_type_id === null)
                                                <div class="img-trans"
                                                     style="vertical-align: middle; display: inline-block; background-image: url({{ url('/main_layout/images/svg/tractor.svg') }})"></div>
                                            @else
                                            <div class="img-trans{{ $fileName == 'coupling' ? ' coupling' : '' }}"
                                                 style="vertical-align: middle; display: inline-block; background-image: url({{ url('/main_layout/images/svg/' . $fileName . '.svg') }})"></div>
                                            @endif
                                        @endif

                                        @if(!$transport->isTrailer)
                                            {{--@if($transport->isConnected())--}}
                                            {{--    <div style="vertical-align: bottom; padding-bottom: 10px; line-height: 12px; color:#008d4c; display: inline-block" >{{ trans("all.traced") }}</div>--}}
                                            {{--@else--}}
                                            {{--    <div style="vertical-align: bottom; padding-bottom: 10px; line-height: 12px; color:#ff2222; display: inline-block">{{ trans("all.not_traced") }}</div>--}}
                                            {{--@endif--}}
                                        @endif
                                    </div>

                                </div>
                                @if($transport->status_name === 'free' && !$transport->isTrailer)
                                    <div class="asd" style="">
                                        <div class="center">
                                            <input data-toggle="none" class="transport-active" name="active{{ $loop->index }}"
                                                   type="checkbox" listen-change="{{ $transport->id }}"
                                                   id="transport-active--{{ $loop->index }}" @if($transport->active) checked @endif
                                                   style="display:none"/>
                                            <label for="transport-active--{{ $loop->index }}" class="toggle"><span class="transport-active-span"></span></label>
                                        </div>
                                    </div>
                                @endif

                        </div>
                    </div>

                    {{-- SECOND COLUMN --}}
                    <div class="col-xs-3 br">
                        @php
                            $temp = $transport->isTrailer ? $transport->truck : $transport;
                            $rollingStockType = $transport->rollingStockType ? $transport->rollingStockType->name : null;
                            $disabled = !$transport->isTrailer || $transport->status_name == 'on_flight'/* || $partner_transport*/; // select of transport
                        @endphp

                        @include('transport.partials.specifications', ['transport' => $temp, 'type' => 'truck', 'parentId' => $transport->id, 'disabled' => $disabled, 'status_name' => $transport->status_name, 'rolling_stock_type_id' => $transport->rolling_stock_type_id, 'rollingStockType' => $rollingStockType])
                    </div>

                    {{-- THIRD COLUMN --}}
                    <div class="col-xs-3">
                        @php
                            $temp = !$transport->isTrailer ? $transport->trailer : $transport;
                            $disabled = $transport->isTrailer || $transport->hasStatus('on_flight') || $partner_transport; // select of transport
                        @endphp
                        @include('transport.partials.specifications', ['transport' => $temp, 'type' => 'trailer', 'parentId' => $transport->id, 'disabled' => $disabled, 'status_name' => $transport->status_name, 'rollingStockType' => $rollingStockType])
                    </div>

                    {{-- FOURTH COLUMN --}}
                    <div class="col-xs-3 driver-info">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="">{{ trans('all.driver') }}</label>
                                @if(!$transport->isTrailer/* && !\Auth::user()->isLogistic()*/)

                                    <select class="form-control drivers selectpicker"
                                            name="driver"
                                            title="{{ trans('all.no_chosen') }}"
                                            listen-change="{{ $transport->id }}"
                                            {{ $transport->hasStatus('on_flight') || $partner_transport ? ' disabled' : '' }}
                                    >
                                        @isset($transport->_driver)
                                            <option value="{{ $transport->_driver->id }}"
                                                    selected>{{ $transport->_driver->name }}</option>
                                        @endisset
                                    </select>
                                @else
                                    <span class="label-name">{{ ($transport->_driver) ? $transport->_driver->name : trans('all.no_chosen')}}</span>
                                @endif
                            </div>

                            <div class="col-xs-12 phone{{ isset($transport->_driver) ? '' : ' hidden' }}">
                                <label for="">{{ trans('all.phone') }}</label>
                                <span class="label-name">{{ isset($transport->_driver) ? $transport->_driver->phone : '' }}</span>
                            </div>

                            <div class="col-xs-12 license{{ isset($transport->_driver) ? '' : ' hidden' }}">
                                <label for="">{{ trans('all.driver\'s_license') }}</label>
                                @if(isset($transport->_driver))
                                    <span class="label-name">{{ isset($transport->_driver) ? $transport->_driver->meta_data['driver_licence'] : '' }}</span>
                                @else
                                    <span class="label-name"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- loader --}}
                <span class="as-loader hidden"></span>

                {{-- collapse --}}
                <div class="btn-collapse collapsed transition" data-toggle="collapse"
                     href="#collapse{{ $loop->index }}"></div>

                {{-- EDITING TOOLS --}}
                {{--@includeWhen(!$transport->trailer || !$transport->truck, 'transport.partials.tools')--}}
            </div>

            {{-- Collapse --}}
            @if($partner_transport == 0)
            <div id="collapse{{ $loop->index }}" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row bt">
                        <div class="col-sm-3">
                            <div class="padding-0">
                                @if(!$transport->isTrailer)
                                    <label for="">{{ trans('all.monitoring_system') }}</label>
                                    <div class="radio">
                                        <input type="radio" id="radio--{{ $loop->index }}"
                                               value="gps"
                                               @if(isset($gps_receive) && $gps_receive->contains('regId', $transport->gps_id))    checked    @endif
                                                disabled
                                               listen-change="{{ $transport->id }}"
                                               name="monitoring{{ $loop->index }}">
                                        <label for="radio--{{ $loop->index }}">GPS</label>

                                        <input type="radio" id="radio-{{ $loop->index }}"
                                               value="app"
                                               listen-change="{{ $transport->id }}"
                                               name="monitoring{{ $loop->index }}" disabled >
                                        <label class="label-auto  @if($transport->isConnected()) green @else red @endif" for="radio-{{ $loop->index }}">AUTO APP</label>
                                    </div>
                                @endif
                            </div>
                            <!-- <div class="padding-0">
                                <label for="">&nbsp;</label>
                                <div class="connection_status">
                                @if($transport->isConnected())
                                    <span style="color:#008d4c">{{ trans('all.traced') }}</span>
                                @else
                                    <span style="color:#ff2222">{{ trans('all.not_traced') }}</span>
                                @endif
                                </div>
                            </div> -->
                        </div>

                        <div class="col-xs-3 auth-transport">
                            @if(!$transport->isTrailer)
                                <label for="">{{ trans('all.credentials') }}</label>
                                <div class="row" style="margin-top: 15px">
                                    <div class="col-xs-6" style="padding-right: 2px">
                                        <span class="error-text hidden">Обязательное поле</span>
                                        <input class="form-control login-trans"
                                               name="login"
                                               listen-change="{{ $transport->id }}"
                                               value="{{ $transport->login ? $transport->login : trans('all.empty')}}">
                                        <small class="text-danger error_login"></small>
                                    </div>

                                    <div class="col-xs-6" style="padding-left: 3px">
                                        <i class="fa fa-refresh pass-refresh" onclick="refreshPass($(this))"
                                           title="Сгенерировать пароль"></i>
                                        <input class="form-control login-trans"
                                               name="password"
                                               listen-change="{{ $transport->id }}"
                                               value="{{ $transport->password }}">
                                        <small class="text-danger error_password"></small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn-link sendDriverSMS{{ $transport->isTrailer ? ' hidden' : '' }}" data-id="{{ $transport->id }}" data-text-success="{{trans('sms.success')}}"
                                    style="margin-top: 30px">{{trans('all.send_sms_to_driver')}}
                            </button>
                        </div>
                        <div class="col-xs-3 photo-column">
                            <label for="">{{ trans('all.photos') }}</label>

                            @include('transport.partials.images')
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@empty
    @if($partner_transport == 0)
        <div class="content-box__body text-center col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 empty-panel">
            <div class="row tab-pane">
                <div class="col-xs-12 br">
                    <h3>{{  trans('all.empty_transport') }}</h3>
                </div>
                <div class="col-xs-12 br">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="col-xs-12 text-center">
                    @can('create-transport')
                        @if(\App\Services\SubscriptionService::checkAutoLimit())
                        <a href="{{ route('transport.create') }}" class="btn button-style1 transition">
                            <i class="fa fa-truck"></i>
                            <span>{{ trans('all.add_transport') }}</span>
                        </a>
                        @else
                            <button type="button" class="btn button-block transition" disabled><span>{{ trans('all.add_transport') }}</span></button>
                        @endif
                    @endcan
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    @else
        <div class="content-box__body text-center col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 empty-panel">
            <div class="row tab-pane">
                <div class="col-xs-12 br">
                    <h3>{{  trans('profile.add_partner') }}</h3>
                </div>
                <div class="col-xs-12 br">
                    <i class="fa fa-male"></i>
                </div>
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn button-style1 transition" data-toggle="modal"
                            data-target="#addPartner">
                        {{ trans('profile.add_partner') }}
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    @endif

@endforelse

<!-- Pagination -->
{{ $transports->appends( ['filters' => $filters])->links() }}
