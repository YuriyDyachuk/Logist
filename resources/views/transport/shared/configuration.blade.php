<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label">{{ trans('all.type_ps') }}</label>
            <select name="{{ $type }}[rolling_stock_type]"
                    id="rollingStock-{{ $type }}"
                    class="form-control selectpicker required"
                    title="{{ trans('all.select_type') }}.."
                    data-live-search="true"
                    data-cancel=""
                    data-size="7">
            </select>
        </div>
        <div class="col-sm-6">
            <label class="control-label">{{ trans('all.loading_type') }}</label>
            <select name="{{ $type }}[type_loading]" class="form-control selectpicker required"
                    title="{{ trans('all.select_type') }}..">
                <option value="1">{{trans('cargo.upper')}}</option>
                <option value="2">{{trans('cargo.lateral')}}</option>
                <option value="3">{{trans('cargo.rear')}}</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-xs-12">
            <label for="">{{ trans('all.transport_dimensions') }} ({{ trans('all.cm') }}
                )</label>
        </div>
        <div class="col-sm-4">
            <input type="text" id="" name="{{ $type }}[length]" class="form-control number required"
                   placeholder="{{trans('all.transport_length')}}" value="">
        </div>
        <div class="col-sm-4">
            <input type="text" id="" name="{{ $type }}[width]" class="form-control number required"
                   placeholder="{{trans('all.transport_width')}}" value="">
        </div>
        <div class="col-sm-4">
            <input type="text" id="" name="{{ $type }}[height]" class="form-control number required"
                   placeholder="{{trans('all.transport_height')}}" value="">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            <label class="control-label">{{trans('all.transport_tonnage')}}</label>
            <input type="text" id="" name="{{ $type }}[tonnage]" class="form-control number required"
                   value="">
        </div>
        <div class="col-sm-4">
            <label class="control-label">{{trans('all.transport_volume')}}
                ({{ trans('all.m') }}3)</label>
            <input type="text" id="" name="{{ $type }}[volume]" class="form-control number required "
                   value="">
        </div>
        <div class="col-sm-4">
            <label class="control-label">{{trans('all.transport_year')}}</label>
            <input type="text" id="" name="{{ $type }}[year]" class="form-control required"
                   maxlength="4" value="">
            <small id="error_{{ $type }}_year" class="text-danger"></small>
        </div>
    </div>
</div>
