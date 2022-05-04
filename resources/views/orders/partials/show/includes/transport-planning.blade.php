<div role="tabpanel" class="tab-pane fade transition animated fadeIn ddd" id="transport">
    <div class="tab-pane__row row">
        <div class="col-xs-12">
            <h2 class="h2 title-block">{{ trans('all.transport_info') }}</h2>
        </div>

        {{--@if($partner_view_check === false && $order_from_partner === false)--}}
        <div v-if="!orderToPartner && !orderFromPartner && partnerCount">
            <div class="col-xs-12">

                <div class="form-group checkbox filter d-inline-block" style="margin-right: 15px">
                    <input class="chang-transport" @change="setPartner" type="checkbox" id="ownTransport" value="1" v-model="own">
                    <label for="ownTransport" @click="suitable()">
                        {{ trans('all.own_transport') }}
                    </label>
                </div>
                <div class="form-group checkbox filter d-inline-block">
                    <input class="chang-transport"  @change="setPartner" type="checkbox" id="partnerTransport" value="1" v-model="partner">
                    <label for="partnerTransport" @click="suitable()">
                        {{ trans('all.transport_partner') }}
                    </label>
                </div>
            </div>

            <div id="partners_request" style="/*display: none;*/" v-show="selectPartner && partnerCount">
                <div class="col-xs-12 col-sm-4 error-for-selectpicker">
                    <label for="partnerTransport" @click="suitable()">
                        {{trans('all.partner_select')}}
                    </label>
                    {{--@if(!empty($partners))--}}
                    @if($transports_partner->isNotEmpty())
                        <select class="selectpicker selectpicker_transport" multiple name="partner_list[]" data-width="100%">
                            @foreach($transports_partner as $partner)
                                <option value="{{$partner->id}}" selected>{{$partner->name}}</option>
                            @endforeach
                        </select>
                    @endif
                    <small id="error_partner_list" class="text-danger"></small>
                </div>

                <div class="clearfix"></div>

                <div class="col-xs-12 col-sm-4 form-group">
                    <label class="mt-2" for="offer_partner" class="control-label">{{ trans('all.amount_partner') }} ({{ $order->currency }})</label>
                    <input id="offer_partner" type="text" class="form-control" name="offer_partner" value="{{ $order->amount_partner }}">
                    <small id="error_offer_partner" class="text-danger"></small>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-6 vat">
                    <input type="checkbox" value="1" @if($order->partner_vat == 1)checked @endif name="offer_partner_vat" id="is_vat">
                    <label for="is_vat" class="text-inherit">{{trans('all.VAT_with')}}</label>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-xs-12 col-sm-4 error-for-selectpicker">
                    <label class="control-label" for="offer_partner_payment_type">{{trans('all.payment_type')}}</label>
                    <select id="offer_partner_payment_type" class="form-control selectpicker" title="{{trans('all.select_type_payment')}}" name="offer_partner_payment_type" required>
                        @foreach($payment_type as $type)
                            <option value="{{$type->id}}">{{ trans('all.order_'.$type->name) }}</option>
                        @endforeach
                    </select>
                    <small id="error_offer_partner_payment_type" class="text-danger"></small>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-xs-12 col-sm-4 error-for-selectpicker">
                    <label class="control-label" for="offer_partner_payment_terms">{{trans('all.terms_type')}}</label>
                    <select id="offer_partner_payment_term" class="form-control selectpicker" title="{{trans('all.select_payment_terms')}}" name="offer_partner_payment_term" required>
                        @foreach($payment_term as $term)
                            <option value="{{$term->id}}">{{ trans('all.order_'.$term->name) }}</option>
                        @endforeach
                        {{--<option value="Безопасная сделка" disabled="disabled">Безопасная сделка - coming soon</option>--}}
                    </select>
                    <small id="error_offer_partner_payment_term" class="text-danger"></small>
                </div>
            </div>
        </div>

        {{--@endif--}}
        <div v-if="partner">
            @if($transport_partner)
                @include('orders.partials.show.includes.transport-partner')
            @endif
        </div>

        <form id="attachTransport" enctype="multipart/form-data" v-if="own">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ trans('all.transport') }}</label>

                    <input type="hidden" name="transportId" v-model="transport.id">
                    <input type="hidden" name="orderId" value="{{ $order->id }}">
                    <input type="hidden" name="category" value="{{ $order->transport_cat_id }}">
                    <input v-show="!own && !partner" class="form-control" value="{{  trans('handbook.' . $order->category->name) }}"
                           disabled>

                    <div v-show="own || partner" class="box-list-transport">

                        <select  v-model="selected" class="form-control  list-transport"
                                @change="setTransport"
                                title="{{ trans('all.not_selected') }}" data-show-subtext="true">
                            <option v-for="transport in transports"
                                    :value="transport.id"
                                    :selected="transport.id == selected ? true : false"
                                    :data-subtext="transport.typeName + ' [' + transport.rollingStock + ']'">
                                ID @{{ transport.id }} - @{{ transport.number }} - @{{ transport.drivers[0].name }}
                            </option>
                            <option v-show="!partner" class="AddNewItem" data-url="{{ route('transport.create') }}?redirectTo={{ route('orders.show', $order->id) }}">
                                {{ trans('all.add_transport') }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="display: none;">
                    <label for="">{{ trans('all.driver') }}</label>

                    <input v-if="transport.drivers && (!own && !partner)" type="text" class="form-control" name="driver_name"
                           v-model="transport.drivers[0].name" v-bind:disabled="own || partner">

                    <select v-if="transport.drivers" class="form-control selectDriver" title="{{ trans('all.not_selected') }}" data-show-subtext="true">
                        <option v-for="(driver, index) in transport.drivers"
                                :selected="index == 0 ? true : false"
                                disabled>@{{ driver.name }}</option>

                        {{--<option v-show="!partner" class="AddNewItem" data-url="{{ route('user.profile') }}?redirectTo={{ route('orders.show', $order->id) }}#add_staff">--}}
                            {{--{{ trans('profile.add_employee') }}--}}
                        {{--</option>--}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="">{{ trans('all.rolling_stock_type') }}</label>
                    <input v-model="transport.rollingStock" name="rollingStock" class="form-control"
                           v-bind:disabled="own || partner">
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">{{ trans('all.transport_number') }}</label>
                            <input type="text" class="form-control" name="number" v-model="transport.number"
                                   v-bind:disabled="own || partner">
                        </div>
                        <div class="col-sm-6">
                            <label for="">{{ trans('all.transport_trailer_number') }}</label>
                            <input v-model="transport.trailerNumber" name="trailerNumber"
                                   type="text" class="form-control" v-bind:disabled="own || partner">
                        </div>
                    </div>
                </div>

                <div class="driver-box" v-if="transport.drivers">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">{{ trans('all.phone') }}</label>
                                <input type="text" class="form-control" name="driver_phone"
                                       v-model="transport.drivers[0].phone"
                                       v-bind:disabled="own || partner">
                            </div>
                            <div class="col-sm-6">
                                <label for="">{{ trans('all.driver_license') }}</label>
                                <input type="text" class="form-control" name="driver_licence"
                                       v-model="transport.drivers[0].meta_data.driver_licence"
                                       v-bind:disabled="own || partner">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ trans('all.license_driver_photo') }}</label>
                        <div v-if="own && transport.drivers[0].picLicense" class="upload-block text-center">
                            <div v-for="image in transport.drivers[0].picLicense" class="photo animated fadeIn zoom"
                                 @click="zoomImage"
                                 :style="{backgroundImage: 'url('+image+')', backgroundSize: 'contain'}">
                                <a :href="image"></a>
                            </div>
                        </div>

                        <div v-else-if="own && !transport.drivers[0].picLicense" class="upload-block text-center">
                            <div class="photo animated fadeIn"
                                 style="background-image: url({{ url('/img/icon/lines-file.png') }}"></div>
                        </div>

                        <div v-else class="upload-block text-center">
                            <div class="photo animated fadeIn"
                                 style="background-image: url({{ url('/img/icon/lines-file.png') }}">
                                <input type="file" id="doc-0" name="images[driver_licence][]" value
                                       class="form-control photo-upload">
                            </div>
                            <label for="doc-0" class="label-upload">{{ trans('all.upload_file') }}</label>
                        </div>
                    </div>
                </div>

                {{-- Second driver --}}
                @php /*
                @if($user->hasRole('logistic-company'))
                    <div v-show="secondDriver" class="form-group checkbox filter">
                        <input type="checkbox" name="additional_driver" value="1" id="additionalDriver">
                        <label for="additionalDriver">
                            {{ trans('all.second_driver') }}
                            <i v-if="loading" class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i></label>
                    </div>

                    <div v-if="secondDriver" class="driver-box additional hidden animated fadeIn">
                        <div class="form-group">
                            <label for="">{{ trans('all.driver') }}</label>
                            <input v-model="transport.drivers[1].name" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">{{ trans('all.phone') }}</label>
                                    <input class="form-control" v-model="transport.drivers[1].phone" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">{{ trans('all.driver_license') }}</label>
                                    <input class="form-control" v-model="transport.drivers[1].meta_data.driver_licence"
                                           disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ trans('all.license_driver_photo') }}</label>

                            <div class="upload-block text-center">
                                <div v-for="image in transport.drivers[1].picLicense" class="photo animated fadeIn zoom"
                                     @click="zoomImage"
                                     :style="{backgroundImage: 'url('+image+')', backgroundSize: 'contain'}">
                                    <a :href="image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                */
                @endphp

                <div v-show="!own" class="form-group text-center">
                    <button type="button" class="btn btn-primary btn-attach" @click="attachTransport"
                            v-bind:disabled="btnAttach">
                        <i class="fa fa-truck" aria-hidden="true"></i>{{ trans('all.attach') }}</button>
                    <hr>
                </div>
            </div>
        </form>
        <div class="col-sm-6"></div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="{{url('/main_layout/js/transports.js')}}" defer></script>

    <script defer>
        const suitableTrans = JSON.parse(JSON.stringify({!! $transports !!}));

        const isSuitable    = suitableTrans.length > 0 || false;

        let partnerCheckTransfer = JSON.parse(JSON.stringify({!! $order_to_partner_json !!}));
        let partnerCheckOffers = JSON.parse(JSON.stringify({!! $offers_sent_json !!}));

        let orderToPartner = JSON.parse(JSON.stringify({!! $order_to_partner_json !!}));
        let orderFromPartner = JSON.parse(JSON.stringify({!! $order_from_partner_json !!}));

        let defaultTrans = suitableTrans;

        let attachedTrans = JSON.parse(JSON.stringify({!! $attachedTrans !!})),
            selectedTrans = false;

        let partnerCount = JSON.parse(JSON.stringify({!! $transports_partner->count() !!}));
        let partnerCountView = false;

        if(partnerCount > 0){
            partnerCountView = true;
        }

//        console.log(attachedTrans);

        // todo: the debugger
        //console.log('SuitableTrans:', suitableTrans);
        //console.log('AttachedTrans:', attachedTrans);

        if (attachedTrans.length !== 0) {
            selectedTrans = attachedTrans;
        }

        if (isSuitable && !selectedTrans) {
            selectedTrans = suitableTrans[0];
        }

        if(selectedTrans.drivers !== undefined && selectedTrans.drivers.length === 0){
            selectedTrans.drivers = getDefaultData().drivers;
        }

        var selectPartner = false;
        var viewParnterTransport = false;

        if(partnerCheckTransfer === 'true'){
            selectPartner = true;
            viewParnterTransport = true;
        }

        const transport = new Vue(
            {
                el: '#transport',

                data: {
                    transports  : defaultTrans,
                    transport   : selectedTrans || getDefaultData(), //
                    drivers     : [],
                    btnAttach   : false,
                    selected    : selectedTrans.id,
                    own         : !partnerCheckTransfer,
                    partner     : partnerCheckTransfer,
                    partnerCount : partnerCountView,
//                    partnerViewCheck     : partnerViewCheck,
                    orderToPartner   : orderToPartner,
                    orderFromPartner : orderFromPartner,
                    partnerCheckOffers: partnerCheckOffers,
                    secondDriver: false,
                    loading     : false,
                    errors      : false,
                    selectPartner: false,
                },

                mounted: function () {

                    if (isSuitable || attachedTrans) {
                        $('.list-transport')
                            .find('option[value="' + this.selected + '"]').attr('selected', true).end()
                            .selectpicker();
                        if (!this.own) {
//                            initPopover(suitableTransPartner);
                        }else {
                            initPopover(suitableTrans);
                        }
                    }

                    if($('.selectDriver').length)
                        $('.selectDriver').selectpicker();
                },

                methods: {
                    suitable: function () {
                        if (!this.own) {
                            this.partner = false;
                            this.transports = suitableTrans || [];
                            this.transport  = selectedTrans || getDefaultData();

                        }else if(!this.partner){
                            this.own = false;
//                            this.transports = suitableTransPartner || [];
                            this.transports = [];
                            this.transport  = selectedTrans || getDefaultData();

                        } else {
                            this.transports = [];
                            this.transport  = getDefaultData();
                            this.btnAttach  = false;
                        }

                        this.$nextTick(function () {
                            $('.list-transport').selectpicker('refresh');
//                            if (!this.own) {
//                                initPopover(suitableTransPartner);
//                            }else {
//                                initPopover(suitableTrans);
//                            }
                        });
                    },

                    setTransport: function (e) {
                        var $index = e.target.options.selectedIndex;
                        var $el = e.target.options[$index];
                        var is_new = $el.classList.contains('AddNewItem');

                        if(is_new){
                            window.location.href = $el.getAttribute('data-url');
                            return true;
                        }

                        let transId    = this.selected;
                        this.transport = this.transports.filter((transport) => {
                            return transport.id === this.selected;
                        })[0];

                        $.get('/transport/attach/' + currentOrderId + '/' + transId)
                         .done(function (res) {

                         })
                         .fail(function (res) {
                             appAlert('', 'Something went wrong... :(', 'warning');
                         });

                        this.$nextTick(function () {
                            $('.selectDriver').selectpicker('refresh');
                        });

                        // this.$nextTick(function () {
                        //     $('.list-transport').selectpicker('refresh');
                        //     initPopover();
                        // });
                    },

                    setPartner: function (e) {

//                        let check = 0;

                        if (this.partner) {
//                            check = 1;
//                            console.log(check);

                            this.selectPartner = true;
                        }
                        else {
                            this.selectPartner = false;
                        }
//                        $.get('/order-partner-change/' + currentOrderId + '/' + check)
//                            .done(function (res) {
//
//                            })
//                            .fail(function (res) {
//                                appAlert('', 'Something went wrong... :(', 'warning');
//                            })

                    },

                    zoomImage: function (event) {
                        let lightbox = $(event.target).find('a').simpleLightbox();

                        lightbox.open();
                    },

                    attachTransport: function () {
                        let data  = new FormData($('#attachTransport')[0]);
                        let _this = this;

                        data.append('_token', CSRF_TOKEN);
                        btnLoader($('.btn-attach'));

                        $.ajax({
                                   url        : '/transport-own',
                                   type       : 'POST',
                                   data       : data,
                                   cache      : false,
                                   processData: false,
                                   contentType: false
                               })
                         .done((data) => {

                             if (data.status === 'success') {
                                 // _this.transport = data.transport;
                                 _this.transport.id = data.transport.id;
                                 _this.btnAttach    = true;
                             }
                             else
                                 appAlert('', data.msg, 'warning');
                         })
                         .fail((data) => {

                             if (data.status === 422) {
                                 let msg = '';
                                 $.each(data.responseJSON, (index, value) => {
                                     msg += '<p>' + value + '</p>';
                                 });
                                 appAlert('', msg, 'warning');
                             } else {
                                 appAlert('', 'Something went wrong... :(', 'warning');
                             }
                         })
                         .always(() => {
                             btnLoader('hide');
                         });
                    },
                }
            }
        );

        function getDefaultData() {
            return {
                id           : 0,
                drivers      : [
                    {
                        name      : '',
                        phone     : '',
                        meta_data : {
                            driver_licence: ''
                        },
                        picLicense: ''
                    }
                ],
                number       : '',
                trailerNumber: '',
                rollingStock : ''
            };
        }

        function initPopover(trans) {
            $('.box-list-transport').find('li').each(function (index) {
                if(!$(this).find('a').hasClass('addNewItem')) {
                    let $this = $(this);
                    // let transport = suitable.transports[index];
                    let transport = trans[index];

                    if(typeof transport != 'undefined') {
                        $(this).popover({
                            container: $(this),
                            html: true,
                            placement: 'auto right',
                            title: '#' + transport.id + ' - ' + transport.number,
                            content: getPropoverContent(transport),
                            trigger: 'hover'
                        });
                    }

                }
            })
        }


        $('.AddNewItem').click(function (event) {
            event.preventDefault();

            $option = $(this).parents('.bootstrap-select').find('select .AddNewItem');
            $url    = $option.data('url');

            window.location.href = $url;
        });


        function getPropoverContent(transport) {
            let html,
                length  = transport.length || (transport.trailer.length > 0 ? transport.trailer[0].length : ''),
                height  = transport.height || (transport.trailer.length > 0 ? transport.trailer[0].height : ''),
                width   = transport.width || (transport.trailer.length > 0 ? transport.trailer[0].width : ''),
                tonnage = transport.tonnage || (transport.trailer.length > 0 ? transport.trailer[0].tonnage : ''),
                volume  = transport.volume || (transport.trailer.length > 0 ? transport.trailer[0].volume : '');

            html = '<p><strong>{{ trans('all.driver') }}</strong><span><i class="glyphicon glyphicon-user"></i>' + transport.drivers[0].name + '</span></p>';

            html += '<p><strong>{{ trans('all.transport') }}</strong>';
            html += '<span><i class="fa fa-truck"></i>' + transport.model + '</span>';
            html += '<span><i class="fa fa-calendar"></i>' + transport.year + '</span>';
            html += '<span><i class="as-trailer"></i>' + transport.trailerNumber + '</span>';
            html += '<span><i class="fa fa-wrench"></i>' + transport.condition + '</span></p>';

            html += '<p><strong>Габариты</strong>';
            html += '<span style="width: 100%"><i class="fa fa-arrows-alt"></i>' +
                'Д ' + length + '<small>см</small><span class="as-x">x</span>' +
                'B ' + height + '<small>см</small><span class="as-x">x</span>' +
                'Ш ' + width + '<small>см</small></span>';
            html += '<span><i class="fa fa-cube"></i>' + volume + '<small>м3</small></span>';
            html += '<span><i class="fa fa-balance-scale"></i>' + tonnage + '<small>т</small></span></p>';

            if (transport.user_id) {
                html += '<a href="' + window.location.origin + '/transport/' + transport.id + '/edit?order={{ $order->id }}" class="edit-trans" onclick="redirectTo(event)"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }

            return html;
        }

        function redirectTo(e) {
            e.stopPropagation();
            // window.location.href = $this.attr('href');
        }
    </script>
@endpush
