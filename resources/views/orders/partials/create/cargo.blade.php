<!-- Step #3: BEGIN -->
<div id="step-2" class="/*content-box__body-tabs*/ content-box__body tab-pane__row animated fadeIn hidden">
    <div class="tab-pane_col-left">
        <h2 class="h2 title-grey"><i class="fa fa-angle-left link-back" data-step="1"></i>2/3</h2>
        <h2 class="h2 title-block">{{ trans('all.cargo_information') }}</h2>
    </div>

    <div class="tab-pane_col-right">
        <div id="formCargo" class="content-box__body-content">
            <div class="form-group group" style="margin-bottom: 30px">
                <label class="control-label" for="cargo_name">{{ trans('all.cargo_name') }}</label>
                <input class="form-control" type="text" name="cargo_name" value="{{isset($user->meta_data['pre_order_cargo']) ? $user->meta_data['pre_order_cargo'] : ''}}" placeholder=""
                       required>
                <small id="error_cargo_name" class="text-danger"></small>
            </div>

            @if(isset($user->meta_data['pre_order_cargo']))
                @php
                    // delete pre order info
                    del_pre_order('pre_order_cargo');
                @endphp
            @endif

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_length">{{ trans('all.length') }} ({{ trans('all.cm') }})</label>
                        <input class="form-control mask-number" type="text" name="cargo_length"
                               value="{{ old('cargo_length') }}"
                               placeholder="" required>
                        <small id="error_cargo_length" class="text-danger"></small>
                    </div>
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_width">{{ trans('all.width') }} ({{ trans('all.cm') }})</label>
                        <input class="form-control mask-number" type="text" name="cargo_width"
                               value="{{ old('cargo_width') }}"
                               placeholder="" required>
                        <small id="error_cargo_width" class="text-danger"></small>
                    </div>
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_height">{{ trans('all.height') }} ({{ trans('all.cm') }})</label>
                        <input class="form-control mask-number" type="text" name="cargo_height"
                               value="{{ old('cargo_height') }}"
                               placeholder="" required>
                        <small id="error_cargo_height" class="text-danger"></small>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 30px">
                <div class="row">
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_weight">{{ trans('all.weight') }}</label>
                        <div class="input-group input-group-order">
                            <input class="form-control mask-number" type="text" name="cargo_weight_input" id="cargo_weight_input"
                                   value="{{ old('cargo_weight') }}"
                                   placeholder="" required>
                            <!-- insert this line -->
                            <span class="input-group-addon"></span>

                            <select id="cargo_weight_type" name="cargo_weight_type" class="form-control selectpicker">
                                <option value="t">{{ trans('all.tons') }}</option>
                                <option value="kg">{{ trans('all.kg') }}</option>
                            </select>

                            <input type="hidden" name="cargo_weight" value="">
                        </div>
                        <small id="error_cargo_weight" class="text-danger"></small>
                    </div>
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_volume">{{ trans('all.volume') }} ({{ trans('all.m') }}3)</label>
                        <input class="form-control mask-number" type="text" name="cargo_volume"
                               value="{{ old('cargo_volume') }}"
                               placeholder="" required>
                        <small id="error_cargo_volume" class="text-danger"></small>
                    </div>
                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_temperature">{{ trans('all.temperature_mode') }}</label>
                        <input class="form-control" maxlength="5" type="text" name="cargo_temperature"
                               value="{{ old('cargo_temperature') }}">
                        <small id="error_cargo_temperature" class="text-danger"></small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-4 select group error-for-selectpicker">
                        <label class="control-label" for="cargo_upload">{{ trans('all.loading_type') }}</label>
                        <select name="cargo_upload[]" class="form-control selectpicker" title="{{trans('cargo.select_cargo_upload_type')}}" required multiple>
                            @foreach($cargo_loading_types as $type)
                                <option value="{{$type->id}}">@if(array_key_exists($type->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$type->slug)}} @else {{ $type->name }} @endif</option>
                            @endforeach
                        </select>
                        {{-- Validation msg --}}
                        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
                        <small id="error_cargo_upload" class="text-danger"></small>
                    </div>

                    <div class="col-xs-4 select group error-for-selectpicker">
                        <label class="control-label" for="cargo_rolling_stock">{{ trans('all.rolling_stock_type') }}</label>
                        <select name="cargo_rolling_stock" class="form-control selectpicker" data-live-search="true" data-size="5"  title="{{trans('all.rolling_stock_type')}}" required >
                            @foreach($cargo_rolling_stock_types as $type)
                                <option value="{{$type->id}}">{{ trans('handbook.'.$type->name) }}</option>
                            @endforeach
                        </select>
                        {{-- Validation msg --}}
                        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
                        <small id="error_cargo_rolling_stock" class="text-danger"></small>
                    </div>

                    <div class="col-xs-4 group">
                        <label class="control-label" for="cargo_hazard">{{ trans('all.hazard_class') }}</label>
                        <select name="cargo_hazard" class="form-control selectpicker" title="{{trans('cargo.select_cargo_hazard_class')}}" data-container="body">
                            @foreach($cargo_hazard_classes as $type)
                                <option value="{{$type->id}}">@if(array_key_exists($type->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$type->slug)}} @else {{ $type->name }} @endif</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="panel-transport">

                <div style="margin-bottom: 10px; cursor: pointer;" data-toggle="collapse"
                     href="#collapse">{{trans('cargo.additional_parameters')}}<div style="display: inline-block" class="btn-collapse collapsed transition" data-toggle="collapse"
                                                                   href="#collapse"></div></div>

            </div>
            <div id="collapse" class="panel-collapse collapse">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6 group">
                                <label class="control-label" for="cargo_pack">{{ trans('all.package_type') }}</label>
                                <select name="cargo_pack" class="form-control selectpicker" title="{{trans('cargo.select_cargo_package_type')}}">
                                    @foreach($cargo_package_types as $type)
                                        <option value="{{$type->id}}">@if(array_key_exists($type->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$type->slug)}} @else {{ $type->name }} @endif</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-6 group">
                                <label class="control-label" for="">{{ trans('all.quantity_of_packages') }}</label>
                                <input class="form-control mask-number" type="text" name="cargo_places"
                                       value="{{ old('cargo_places') }}">
                                <small id="error_cargo_places" class="text-danger"></small>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 group">
						<span class="cargo-rating">
                            <label for="cargo_rating">
                                {{trans('all.rating_level')}}
                                <i class="info-notification transition">?
                                    <span class="info-notification transition">
                                        <em>{{trans('all.rating_warning')}}</em>
                                    </span>
                                </i>
                            </label>
                            <input type="hidden" name="rating" value="0">
                            <label for="stars0"></label>
                            <input type="radio" id="stars5" name="rating" value="5">
                            <label for="stars5" class="transition"></label>
                            <input type="radio" id="stars4" name="rating" value="4">
                            <label for="stars4" class="transition"></label>
                            <input type="radio" id="stars3" name="rating" value="3">
                            <label for="stars3" class="transition"></label>
                            <input type="radio" id="stars2" name="rating" value="2">
                            <label for="stars2" class="transition"></label>
                            <input type="radio" id="stars1" name="rating" value="1">
                            <label for="stars1" class="transition"></label>
				        </span>
                    </div>
                </div>
            </div>

{{--            <div class="form-group radio">--}}
{{--                <label for="car_registration" class="control-label">Регистрация транспорта</label>--}}

{{--                <input type="radio" id="carreg1" name="register_transport" value="1" checked>--}}
{{--                <label for="carreg1">Обязательная</label>--}}

{{--                <input type="radio" id="carreg2" name="register_transport" value="0">--}}
{{--                <label for="carreg2">Необязательная</label>--}}
{{--            </div>--}}
            <input type="hidden" name="register_transport" value="1">
        </div>

        <div class="content-box__body-footer">
            <div>
                <a href="javascript://" class="btn button-cancel"
                   data-cancel="flight">{{ trans('all.cancel') }} <i>×</i></a>
            </div>
            <div>
                <a href="javascript://" class="content-box__body-tabs-btn btn button-style1 transition"
                   data-validate="Cargo">{{ trans('all.next') }}
                    <span class="arrow-right"></span></a>
            </div>
        </div>

        {{--<div class="content-box__body-footer">--}}
            {{--<div>--}}
                {{--<a href="javascript://" class="btn btn-default transition"--}}
                   {{--data-cancel="flight">{{ trans('all.cancel') }} <i>×</i></a>--}}
            {{--</div>--}}
            {{--<div>--}}
                {{--<a href="javascript://" class="next-tab content-box__body-tabs-btn transition"--}}
                   {{--data-validate="Cargo">{{ trans('all.next') }}--}}
                    {{--<i>–›</i></a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
<!-- Step #3: END -->
@push('scripts')
<script>
    $(function() {
        $('input[name=cargo_weight_input]').on('change', function(e) {
            cargoWeight();
        });

        $('#cargo_weight_type').on('change', function() {
            cargoWeight();
        });

        function cargoWeight(){

            let val = $('input[name=cargo_weight_input]').val().replace(/,/g,'.');
            val = parseFloat(val).toFixed(3);
            let weight;

            if(isNaN(val)){
                $('input[name=cargo_weight_input]').val('');
                return;
            }

            let type = $('#cargo_weight_type').val();
            if(type === 't'){
                weight = 1000 * val;
            } else {
                val = parseFloat(val).toFixed(0);
                weight = val;
            }

            $('input[name=cargo_weight_input]').val(val);

            $('input[name=cargo_weight]').val(weight);
        }

        setInputFilter(document.getElementById("cargo_weight_input"), function(value) {
            return /^-?\d*[.,]?\d*$/.test(value); });

        // Restricts input for the given textbox to the given inputFilter.
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        }
    });
</script>
@endpush
