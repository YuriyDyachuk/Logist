<h2 class="h2 title-block">{{ trans('all.cargo_information') }}</h2>

<div class="panel-transport cargo-block">
    @php
        $edit_cargo = false;
    @endphp
    {{--@if($order->hasStatus('planning') && $order->user_id === auth()->id())--}}
    @if(auth()->user()->can('order_edit_cargo', $order))
        @php
            $edit_cargo = true;
        @endphp
    @endif

    <div class="form-group">
        <div class="row spec">
            <div class="col-xs-12">
                <label class="control-label" for="cargo_name">{{ trans('all.cargo') }}</label>
                <input class="form-control" type="text" name="cargo_name" value="{{ $order->cargo['name'] }}" @if(!$edit_cargo) disabled @endif>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row spec">
            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_places">{{ trans('all.quantity_of_packages') }}</label>
                <input class="form-control input_numbers" type="text" name="cargo_places" value="{{ $order->cargo['places'] }}"
                       @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_loading_type">{{ trans('all.loading_type') }}</label>
                @php
                    $cargo_loading_type = \App\Models\Order\CargoLoadingType::all();
                    $loadingType = $order->loadingType;

                    $loadingType = $loadingType->mapWithKeys(function ($item) {
                        return [$item['id'] => $item['slug']];
                    });

                    $loadingType = $loadingType ? $loadingType->toArray() : [];

                //dump($loadingType)
                @endphp
                @if($edit_cargo)
                    <select name="cargo_loading_type[]" class="form-control selectpicker" title="{{trans('cargo.select_cargo_upload_type')}}" data-container="body" multiple>
                        @foreach($cargo_loading_type as $type)
                            <option value="{{$type->id}}" @if(array_key_exists($type->id, $loadingType))  selected @endif >{{ trans('cargo.'.$type->slug) }}</option>
                        @endforeach
                    </select>
                @else
                    @php
                        $str = '';

                        foreach($cargo_loading_type as $type){
                        if(array_key_exists($type->id, $loadingType)) {
                                $str .= trans('cargo.'.$type->slug).', ';
                            }
                        }

                        $str = rtrim($str, ', ');
                    @endphp

                    <input class="form-control" type="text" name="cargo_loading_type"
                           value="{{ $str }}" disabled>

                @endif
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_hazard">{{ trans('all.hazard_class') }}</label>
                @if($edit_cargo)
                    @php
                        $cargo_hazard_classes = \App\Models\Order\CargoHazardClass::all();
                    @endphp
                    <select name="cargo_hazard" class="form-control selectpicker" title="{{trans('cargo.select_cargo_hazard_class')}}" data-container="body">
                        @foreach($cargo_hazard_classes as $type)
                            <option value="{{$type->id}}" @if($order->cargo->hazardClass && $order->cargo->hazardClass->id === $type->id) selected @endif>@if(array_key_exists($type->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$type->slug)}} @else {{ $type->name }} @endif</option>
                        @endforeach
                    </select>
                @else
                <input class="form-control" type="text" name="cargo_hazard"
                       value="@if($order->cargo->hazardClass)@if(array_key_exists($order->cargo->hazardClass->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$order->cargo->hazardClass->slug)}} @else {{ $order->cargo->hazardClass->name }} @endif @endif" disabled>
                @endif
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_package_type">{{ trans('all.package_type') }}</label>
                @if($edit_cargo)
                    @php
                        $cargo_package_types = \App\Models\Order\CargoPackageType::all();
                    @endphp
                    <select name="cargo_package_type" class="form-control selectpicker" title="{{trans('cargo.select_cargo_package_type')}}" data-container="body">
                    @foreach($cargo_package_types as $type)
                        <option value="{{$type->id}}" @if($order->cargo->packageType && $order->cargo->packageType->id === $type->id) selected @endif >@if(array_key_exists($type->slug, trans('cargo', [], app()->getLocale()))){{trans('cargo.'.$type->slug)}} @else {{ $type->name }} @endif</option>
                    @endforeach
                    </select>
                @else
                <input class="form-control" type="text" name="cargo_package_type" value="@if($order->cargo->packageType){{trans('cargo.'.$order->cargo->packageType->slug)}} @endif" disabled>
                @endif
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_temperature">{{trans('all.rolling_stock_type')}}</label>
                @if($edit_cargo)
                    @php
                        $cargo_rolling_stock_types = \App\Models\Transport\RollingStockType::all();
                    @endphp
                    <select name="cargo_rolling_stock_type" class="form-control selectpicker" title="{{trans('all.rolling_stock_type')}}" data-container="body">
                        @foreach($cargo_rolling_stock_types as $type)
                            <option value="{{$type->id}}" @if($order->cargo->rollingStockType && $order->cargo->rollingStockType->id === $type->id) selected @endif>{{ trans('handbook.'.$type->name) }}</option>
                        @endforeach
                    </select>
                @else
                <input class="form-control" type="text" name="cargo_rolling_stock_type"
                       value="{{ $order->cargo->rollingStockType ? trans('handbook.'.$order->cargo->rollingStockType->name) : '' }}" disabled>
                @endif
            </div>

        </div>
        <div class="row spec">

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_length">{{ trans('all.length') }} @if($edit_cargo) ({{ trans('all.cm') }}) @endif</label>
                <input class="form-control input_numbers" type="text" name="cargo_length" value="{{ isset($order->cargo['length']) ? $order->cargo['length'] : 0 }}@if(!$edit_cargo) {{ trans('all.cm') }} @endif" @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_width">{{ trans('all.width') }} @if($edit_cargo) ({{ trans('all.cm') }}) @endif</label>
                <input class="form-control input_numbers" type="text" name="cargo_width" value="{{ isset($order->cargo['width']) ? $order->cargo['width'] : 0 }}@if(!$edit_cargo) {{ trans('all.cm') }} @endif" @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_height">{{ trans('all.height') }} @if($edit_cargo) ({{ trans('all.cm') }}) @endif</label>
                <input class="form-control input_numbers" type="text" name="cargo_height" value="{{ isset($order->cargo['height']) ? $order->cargo['height'] : 0 }}@if(!$edit_cargo) {{ trans('all.cm') }} @endif" @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_weight">{{ trans('all.weight') }} @if($edit_cargo) ({{ trans('all.tons') }}) @endif</label>
                <input class="form-control input_numbers" type="text" name="cargo_weight" value="{{ isset($order->cargo['weight']) ? $order->cargo['weight']/1000 : 0 }}@if(!$edit_cargo) {{ trans('all.tons') }} @endif" @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_volume">{{ trans('all.volume') }} @if($edit_cargo) (м3) @endif</label>
                <input class="form-control input_numbers" type="text" name="cargo_volume" value="{{ isset($order->cargo['volume']) ? $order->cargo['volume'] : 0 }}@if(!$edit_cargo) м3 @endif" @if(!$edit_cargo) disabled @endif>
            </div>

            <div class="col-xs-12 col-4">
                <label class="control-label" for="cargo_temperature">{{ trans('all.temperature_mode') }}</label>
                <input class="form-control input_numbers" type="text" name="cargo_temperature"
                       value="{{ $order->cargo['temperature'] }}" @if(!$edit_cargo) disabled @endif>
            </div>

        </div>
    </div>
</div>


{{--    <label>{{ trans('all.additional_services') }}</label>
    <div class="form-group checkbox">
        <input type="checkbox" name="cargo_services[]" value="1" id="cargo_insurance" disabled>
        <label for="cargo_insurance" class="text-inherit">{{ trans('service.cargo_insurance') }}</label>
    </div>

    <div class="form-group checkbox">
        <input type="checkbox" name="cargo_services[]" value="2" id="customs_services" disabled>
        <label for="customs_services" class="text-inherit">{{ trans('service.customs_brokerage') }}</label>
    </div>

    <div class="form-group checkbox">
        <input type="checkbox" name="cargo_services[]" value="3" id="loader_services" disabled>
        <label for="loader_services" class="text-inherit">{{ trans('service.warehouse_services') }}</label>
    </div>

    <div class="form-group checkbox">
        <input type="checkbox" name="cargo_services[]" value="4" id="express_delivery" disabled>
        <label for="express_delivery" class="text-inherit">{{ trans('service.courier_delivery') }}</label>
    </div>--}}

