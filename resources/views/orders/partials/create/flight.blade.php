<!-- Step #2: BEGIN -->
<div id="step-1" class="/*content-box__body-tabs*/ content-box__body tab-pane__row active animated fadeIn">
    {{-- LEFT --}}
    <div class="tab-pane_col-left">
        <h2 class="h2 title-grey">1/3 </h2>
        <h2 class="h2 title-block">{{ trans('all.order_info') }}</h2>
    </div>
    {{-- RIGHT --}}
    <div class="tab-pane_col-right">
        <div class="content-box__body-content col-xs-12" id="formFlight">
            <div class="row">
                <div class="group col-xs-4">
                    <label class="control-label" for="download_date">{{ trans('all.number_order') }}</label>
                    <input type="text" name="order_id" class="number-order" value="{{ $orderId }}" disabled>
                </div>
                <div class="group col-xs-8">
                    <label class="control-label" for="specialization">{{trans('all.order_category')}}</label>

                    <select name="category" class="form-control selectpicker" data-spec
                            title="Выберите категорию услуги"
                            required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    selected>{{ trans('handbook.' . $category->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if(!$user->isClient())
            <div class="row">
                <div class="group col-xs-12 error-for-selectpicker">

                    <label class="control-label"
                           for="client">{{ trans('all.client') }}</label>

                    <select name="client" id="client" class="form-control selectpicker" data-spec
                            title="{{ trans('all.select_client') }}" data-live-search="true" data-size="7">
                        <option disabled="disabled" selected="selected">{{ trans('all.select_client') }}</option>
                        @foreach($clients as $client)
                            @if(!empty($client->client->data['companyName']))
                                <option value="{{ $client->id }}">{{ $client->name . ' - ' . trans('all.company') . ': ' . $client->client->data['companyName'] }}</option>
                            @else
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endif
                        @endforeach
                        <option value="" class="AddNewItem" data-url="{{ url('/client') }}">
                            {{ trans('all.add_client') }}
                        </option>
                    </select>
                    <small id="error_client" class="text-danger"></small>
                </div>
            </div>
            @endif

            {{-- Hidden --}}
            <input type="hidden" name="route_polyline">
            <input type="hidden" name="direction_waypoints">

            <div class="points-container">

                <!-- dop info img -->
                <div class="dop-img"></div>
                <!-- end dop info  -->

                {{-- THE POINT LOADING --}}
                <div class="row point-box with-marker-loading point-box-loading" data-item="0">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="loading_date">{{ trans('all.date_loading') }}</label>
                        <input type="text" class="datetimepickerTime date-start form-control duplicate"
                               name="points[loading][0][date_at]" value=""
                               data-marker-update=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                        <div class="duplicate-error text-danger">{{ trans('all.create_date_duplicate') }}</div>
                        <small id="error_loading_0_date_at" class="text-danger"></small>
                    </div>
                    <div class="group col-xs-8">
                        <label class="control-label" for="">{{ trans('all.loading_address') }}</label>
                        {{-- hidden --}}
                        <input type="hidden" name="points[loading][0][address_id]" class="address_place_id duplicate-address"
                               data-marker-update=""
                               data-address="loading"
                               value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['from_place_id'] : ''}}"
                        >
                        <input type="text" class="form-control autocomplete /*duplicate-address*/"
                               name="points[loading][0][address]" value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['from'] : ''}}"
                               autocomplete="off"
                               onClick="this.select();"
                               placeholder="{{trans('all.placeholder_address')}}" required>
                        <input type="hidden" class="hidden-prev-address">
                        <input type="hidden" class="hidden-prev-place-id">
                        <small class="duplicate-error-address text-danger">{{ trans('all.create_address_duplicate') }}</small>
                        <small id="error_loading_0_address" class="text-danger"></small>
                    </div>
                </div>

                {{--<div class="create-point" data-type="loading">--}}
                    {{--<a href="javascript://">{{ trans('all.create_point_loading') }}</a>--}}
                {{--</div>--}}

                {{-- THE POINT UNLOADING --}}
                <div class="row point-box with-marker-unloading point-box-unloading" data-item="0">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="download_date">{{ trans('all.date_unloading') }}</label>
                        <input type="text" class="datetimepickerTime form-control duplicate"
                               name="points[unloading][0][date_at]" value=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                        <div class="duplicate-error text-danger">{{ trans('all.create_date_duplicate') }}</div>
                        <small id="error_unloading_0_date_at" class="text-danger"></small>
                    </div>
                    <div class="group col-xs-8">
                        <label class="control-label"
                               for="">{{ trans('all.unloading_address') }}</label>
                        {{-- hidden --}}
                        <input type="hidden" name="points[unloading][0][address_id]"  class="address_place_id duplicate-address"
                               data-marker-update=""
                               data-address="unloading"
                               value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['to_place_id'] : ''}}"
                        >
                        <input type="text" class="form-control autocomplete /*duplicate-address*/"
                               name="points[unloading][0][address]" value="{{isset($user->meta_data['pre_order_addresses']) ? $user->meta_data['pre_order_addresses']['to'] : ''}}"
                               autocomplete="off"
                               onClick="this.select();"
                               placeholder="{{trans('all.placeholder_address')}}" required>
                        <input type="hidden" class="hidden-prev-address">
                        <input type="hidden" class="hidden-prev-place-id">
                        <small class="duplicate-error-address text-danger">{{ trans('all.create_address_duplicate') }}</small>
                        <small id="error_unloading_0_address" class="text-danger"></small>
                    </div>
                </div>

                @if(isset($user->meta_data['pre_order_addresses']))
                    @php
                        // delete pre order info
                        del_pre_order('pre_order_addresses');
                    @endphp
                @endif

                {{--<div class="create-point" data-type="unloading">--}}
                    {{--<a href="javascript://">{{ trans('all.create_point_unloading') }}</a>--}}
                {{--</div>--}}

            </div>

            <div class="map-container">
                <div id="map" style="height: 310px"></div>
            </div>

            {{-- FOOTER --}}
            <div class="content-box__body-footer">
                <a href="javascript://" class="btn button-cancel" data-cancel="flight">{{ trans('all.cancel') }}
                    <i>×</i></a>
                <a href="javascript://" class="content-box__body-tabs-btn btn button-style1 transition"
                   data-validate="Flight">{{ trans('all.next') }}<span class="arrow-right"></span></a>
            </div>

            {{--<div class="content-box__body-footer">--}}
                {{--<div>--}}
                    {{--<a href="javascript://" class="btn button-cancel" data-cancel="flight">{{ trans('all.cancel') }}--}}
                        {{--<i>×</i></a>--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<a href="javascript://" class="/*next-tab*/ content-box__body-tabs-btn transition"--}}
                       {{--data-validate="Flight">{{ trans('all.next') }}<span class="arrow-right"></span></a>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- Step #2: END -->
@push('scripts')
<script>
    $(function() {

        $('#client').on('changed.bs.select', function (e) {
            let url = $('option:selected', this).attr("data-url");

            if(url !== undefined)
                window.location.href = url;
        });
    });

</script>
@endpush