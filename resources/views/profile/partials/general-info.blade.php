<div role="tabpanel" class="tab-pane fade in active transition" id="info">
    <div class="tab-pane__row">
        <form name="edit_user" method="POST">
            <div class="tab-pane__row-description">
                <p>{{isset($user->meta_data['description']) ? $user->meta_data['description'] : ''}}</p>
                <!-- Наша компания - это команда специалистов в сфере ВЭД.Многолетний опыт в транспортной логистике, плодотворная работа с таможенными органами, наличие широких возможностей для улучшенного ведения международного бизнеса. -->
            </div>
            <div class="row">
                <div class="/*tab-pane_col-left*/ col-xs-12 col-sm-6">
                <h2 class="h2 title-block">{{trans('all.company_about')}}</h2>

                <div class="form-horizontal text-left">
                    @if($user->isLogistic())
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.transports')}}</label>
                        <div class="col-sm-8 user_info__text">
                        <span>
                            {{\App\Services\TransportService::getTransports()->count()}} {{trans('all.pcs')}}
{{--                            {{count($user->transports->where('id'))}} {{trans('all.pcs')}}--}}
                        </span>
                        </div>
                    </div>
                    @endif
                    @if( auth()->user()->isLogist())
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.address')}}</label>
                        <div class="col-sm-8 user_info__text">
                        <span>
                        @if(isset($resCompany->address_index))
                                    {{$resCompany->address_index}},
                                @endif

                            @if(isset($resCompany->address_country_code))
                                @php
                                    $address = true;
                                @endphp
                                {{(new App\Services\GeographerService)->getCountryByCode($resCompany->address_country_code)->name}},
                            @endif

                            @if(isset($resCompany->address_region_code))
                                {{(new App\Services\GeographerService)->getStateByCode($resCompany->address_region_code)->name}},
                            @endif

                            @if(isset($resCompany->address_city_code))
                                {{(new App\Services\GeographerService)->getCityByCode($resCompany->address_city_code)->name}},
                            @endif

                            @if(isset($resCompany->address_street))
                                {{$resCompany->address_street}},
                            @endif

                            @if(isset($resCompany->address_number))
                                {{$resCompany->address_number}}
                            @endif

                            @php
                                if(!isset($address)){
                                echo trans('all.empty');
                                }
                            @endphp
                        </span>
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{ trans('all.address') }}</label>
                        <div class="col-sm-8 user_info__text">
                        <span>
                        @if(isset($user->meta_data['address_index']))
                                {{$user->meta_data['address_index']}},
                            @endif

                            @if(isset($user->meta_data['address_country_code']))
                                @php
                                    $address = true;
                                @endphp
                                {{(new App\Services\GeographerService)->getCountryByCode($user->meta_data['address_country_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_region_code']))
                                {{(new App\Services\GeographerService)->getStateByCode($user->meta_data['address_region_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_city_code']))
                                {{(new App\Services\GeographerService)->getCityByCode($user->meta_data['address_city_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_street']))
                                {{$user->meta_data['address_street']}},
                            @endif

                            @if(isset($user->meta_data['address_number']))
                                {{$user->meta_data['address_number']}}
                            @endif


                            @php
                                if(!isset($address)){
                                echo trans('all.empty');
                                }
                            @endphp
                        </span>
                        </div>
                    </div>
                    @endif
                    @if(isset($user->meta_data['type']) && $user->meta_data['type'] == 'company')
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.address_legal')}}</label>
                        <div class="col-sm-8 user_info__text">
                        <span>
                            @if(isset($user->meta_data['address_legal_index']))
                                {{$user->meta_data['address_legal_index']}},
                            @endif

                            @if(isset($user->meta_data['address_legal_country_code']))
                                @php
                                    $address = true;
                                @endphp
                                {{(new App\Services\GeographerService)->getCountryByCode($user->meta_data['address_legal_country_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_legal_region_code']))
                                {{(new App\Services\GeographerService)->getStateByCode($user->meta_data['address_legal_region_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_legal_city_code']))
                                {{(new App\Services\GeographerService)->getCityByCode($user->meta_data['address_legal_city_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_legal_street']))
                                {{$user->meta_data['address_legal_street']}},
                            @endif

                            @if(isset($user->meta_data['address_legal_number']))
                                {{$user->meta_data['address_legal_number']}}
                            @endif

                            @php
                                if(!isset($address)){
                                echo trans('all.empty');
                                }
                            @endphp
                        </span>
                        </div>
                    </div>
                    @endif
                    @if(isset($user->meta_data['address_post_country_code']))
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{ trans('all.address_post') }}</label>
                        <div class="col-sm-8 user_info__text">
                        <span>
                            @if(isset($user->meta_data['address_post_index']))
                                {{$user->meta_data['address_post_index']}},
                            @endif

                            @if(isset($user->meta_data['address_post_country_code']))
                                {{(new App\Services\GeographerService)->getCountryByCode($user->meta_data['address_post_country_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_post_region_code']))
                                {{(new App\Services\GeographerService)->getStateByCode($user->meta_data['address_post_region_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_post_city_code']))
                                {{(new App\Services\GeographerService)->getCityByCode($user->meta_data['address_post_city_code'])->name}},
                            @endif

                            @if(isset($user->meta_data['address_post_street']))
                                {{$user->meta_data['address_post_street']}},
                            @endif

                            @if(isset($user->meta_data['address_post_number']))
                                {{$user->meta_data['address_post_number']}}
                            @endif
                        </span>
                        </div>
                    </div>
                        @endif
                </div>
            </div>

            <div class="/*tab-pane_col-right*/ col-xs-12 col-sm-6">
                {{--<h2 class="h2 title-black">{{trans('all.company_services')}}</h2>--}}
                <h2 class="h2 title-block">{{trans('all.specialization')}}</h2>

                @foreach($user->specializations as $specializations)
                    <div class="form-group">
                        <span class="bg bg-info bg-sp">{{ trans('all.'.$specializations->name )}}</span>
                    </div>
                @endforeach
            </div>
            </div>
        </form>
    </div>
</div>