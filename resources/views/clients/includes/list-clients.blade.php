@forelse ($clients as $key=>$client)
    <div class="content-box__row">
        {{--<a href="" class="link-order">--}}

        <div class="card-order card-order--clients">
            <div class="row flex">

                <div class="col-xs-3 br-2 flex align-content-between">
                    <div class="row">
                        <div class="col-xs-12">
{{--                            <div class="">--}}
{{--                                <h4 class="title-black label-card">--}}
{{--                                    <b>{{ $client->company_name ? $client->company_name : $client->name }}</b></h4>--}}
{{--                            </div>--}}
                            <div class="client">
                                @php
                                    $avatar = $client->user->getAvatar();
                                @endphp
                                <div style="background-image: url('{{ $avatar ? \Image::getPath('users', $avatar) : url('/img/default-profile.jpg') }}')"
                                     class="client__image client__image--online"></div>
                                <div class="client__description">

                                    @if(isset($client->user->meta_data['type']) && ($client->user->meta_data['type'] == 'individual' || $client->user->meta_data['type'] == 'company'))
                                        <div class="client-info">
                                            <h5 class="title-grey label-card">{{ trans('all.full_name') }}</h5>
                                            <div class="client-info__details">
                                                <span class="semibold">{{ $client->user->isCompany() && isset($client->data['delegate_name']) ? $client->user->data['delegate_name'] : $client->user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title-grey label-card">{{ trans('all.company_name') }}</h5>
                                            <div class="client-info__details">
                                                <span class="semibold">{{ isset($client->data['companyName']) ? $client->data['companyName'] : $client->data['name'] }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="client-info">
                                            @if(!empty($client->data['companyName']))
                                                <h5 class="title-grey label-card">{{ trans('all.company_name') }}</h5>
                                            @else
                                                <h5 class="title-grey label-card">{{ trans('all.full_name') }}</h5>
                                            @endif
                                            <div class="client-info__details">
{{--                                                    <span class="semibold">{{ $client->company_name ? $client->company_name : $client->user->name }}</span>--}}
                                                <span class="semibold">{{ isset($client->data['companyName']) ? $client->data['companyName'] : ($client->data['name'] ?? '') }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="">
                                        @if($client->user->invited)
                                            {{--<span class="marker-pending transition">{{trans('all.status_client_offline')}}</span>--}}
                                            <span class="label label-status marker-pending marker-active marker-status">{{trans('all.status_client_offline')}}</span>
                                        @else
                                            {{--<span class="marker-active transition">{{trans('all.status_client_online')}}</span>--}}
                                            <span class="label label-status label-success marker-active marker-status transition">{{trans('all.status_client_online')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-3 br-2 flex">
                    <div class="row">
                        <div class="col-xs-6 col-sm-12">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{ trans('all.phone') }}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ $client->user->phone ? $client->user->phone : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12">
                            <div class="client-info">
                                <h5 class="title-grey label-card">email</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ $client->user->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xs-3 br-2 flex">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.city')}}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ isset($client->data['city']) ? $client->data['city'] : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.country')}}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ isset($client->data['country']) ? $client->data['country'] : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.address_zip')}}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ isset($client->data['index']) ?  $client->data['index'] : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.street')}}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ isset($client->data['street']) ? $client->data['street'] : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xs-3 br-2 flex">
                    <div class="row">
                        <div class="col-xs-6 col-sm-12">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.position')}}</h5>
                                <div class="client-info__details">
                                    <span class="semibold">{{ $client->position ? $client->position : trans('all.empty') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12">
                            <div class="client-info">
                                <h5 class="title-grey label-card">{{trans('all.order_lat_and_date')}}</h5>
                                <div class="client-info__details">
                                    @if(isset($client->data['latest_order']))
                                        <span class="semibold">
                                                #{{ $client->data['latest_order'] }}
                                            </span>
                                        <span>
                                                {{ $client->data['date'] }}
                                            </span>
                                    @else
                                        <span class="semibold">
                                                {{isset($client->data['order']['number']) ? '#' . $client->data['order']['number'] : trans('all.empty') }}
                                            </span>
                                        <span>{{ isset($client->data['order']['date']) ? $client->data['order']['date'] : '' }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--</a>--}}

        <div id="collapse" class="panel-collapse collapse">
            <div class="client-box">
                <div class="row bt">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-xs-3">
                        <div class="client-info">
                            <h5 class="title-grey label-card">skype</h5>
                            <div class="client-info__details">
                                <span class="semibold">{{ isset($client->data['skype']) ? $client->data['skype'] : trans('all.empty') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                    </div>
                    <div class="col-xs-3">
                        <div class="client-info">
                            <h5 class="title-grey label-card">{{trans('all.special_conditions')}}</h5>
                            <div class="client-info__details">
                                <span class="semibold">{{ isset($client->data['condition']) ? $client->data['condition'] : trans('all.empty') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arrow clients -->
        <div class="client-history">
            <a href="{{ route('client.history', $client->user->id) }}"></a>
        </div>
        <!-- End arrow clients -->

        <div class="panel panel-client">
            <div class="btn-collapse transition collapsed" data-toggle="collapse" href="#collapse_{{$client->id}}"
                 aria-expanded="false"></div>

            <div id="collapse_{{$client->id}}" class="panel-collapse collapse" aria-expanded="false"
                 style="height: 0px;">
                <div class="panel-body">
                    @if($client->user->invited)
                        <div class="editing-tools transition panel-client__icon">
                            <span class="invitation" title="{{trans('all.invite_to_system')}}"
                                  onclick="sendInvite({{ $client->id }})"></span>
                        </div>
                    @endif

                    @if($client->user->invited)
                        <div class="editing-tools transition panel-client__icon">
                            <a href="#" class="edit" onclick="edit($(this))"
                               data-client="{{ json_encode($client) }}"></a>
                        </div>
                    @endif

                    <div class="editing-tools transition panel-client__icon">
                        <a href="#" onclick="removeClient({{ $client->user->id }})" class="trash"
                           title="{{trans('all.client_remove')}}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="content-box__body text-center col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 empty-panel">
        <div class="row tab-pane">
            <div class="col-xs-12">
                <h3>{{  trans('all.empty_clients') }}</h3>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-users"></i>
            </div>
            <div class="row form-group"></div>
            <div class="col-xs-12 text-center padding-y-sm">
                <button type="button" class="btn button-style1 transition" data-toggle="modal" data-target="#addClient">
                    <i class="as as-addclient"></i>
                    <span>{{ trans('all.add_client') }}</span>
                    <span class="hidden">{{ trans('all.client') }}</span>
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
@endforelse

{{ $clients->links() }}