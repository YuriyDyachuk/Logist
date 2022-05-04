<div class="row specifications-column">
    {{-- EDITING TOOLS --}}
    @includeWhen($transport, 'transport.partials.tools', ['transport' => $transport, 'status_name' => $status_name])

    <div class="col-xs-12">
        <label for="">{{ $type == 'trailer' ? trans('all.transport_trailer_number') : trans('all.number') }}</label>

        <select name="{{ $type }}" class="form-control truck selectpicker transport-select"
                title="{{ trans('all.no_chosen') }}"
                listen-change="{{ $parentId ? $parentId : 0}}"
                {{ $disabled ? ' disabled':'' }}
        >
            <option value="{{ (isset($transport['id']) && $transport['id']) ? $transport['id'] : 0 }}" selected>
                {{ (isset($transport['number']) && $transport['number']) ? $transport['number'] : '' }}
            </option>
        </select>
    </div>

    <div class="col-xs-6{{ $transport  ? '':' empty-spec mb' }}">
        <label for="">{{ $type == 'trailer' ? trans('all.type_ps') : trans('all.transport_model_ts') }}</label>
        <span class="label-name">
                    @php
                        //$trans = 'handbook.'.$transport['rolling_stock_name'];

                        if(isset($transport['rolling_stock_name']) && \Lang::has('handbook.'.$transport['rolling_stock_name']))
                            $title = trans('handbook.'.$transport['rolling_stock_name']);
                        else
                            $title = '';

                    @endphp

                {{ $type == 'trailer' ? $title : $transport['model'] }}
            </span>
    </div>

    @if($rollingStockType && $type == 'truck')
    <div class="col-xs-6">
        <label for="">{{ trans('all.type_ps') }}</label>
        <span class="label-name">{{ trans('handbook.'.$rollingStockType) }}</span>
    </div>
    @endif


    <div class="col-xs-12{{ $transport && !$transport->isTractor() ? '':' empty-spec' }}">
        @if((isset($rolling_stock_type_id) && $rolling_stock_type_id !== null && $type == "truck") || (!isset($rolling_stock_type_id) && $type != "truck"))
        <div class="spec">
                                    <span><i class="fa fa-cube"></i> {{ $transport ? $transport->volume : 0 }}<span
                                                class="as-unit">м3</span></span>
            <span><i class="fa fa-balance-scale"></i> {{ $transport ? $transport->tonnage : 0 }}<span
                        class="as-unit">{{ trans('all.tons') }}</span></span>
        </div>
        <div class="spec">
            <span class="unit-l">Д</span>{{ $transport ? $transport->length : 0 }}<span
                    class="as-unit after-x">{{ trans('all.cm') }}</span>
            <span class="unit-l">Ш</span>{{ $transport ? $transport->width : 0 }}<span
                    class="as-unit">{{ trans('all.cm') }}</span>
            <span class="unit-l">В</span>{{ $transport ? $transport->height : 0 }}<span
                    class="as-unit after-x">{{ trans('all.cm') }}</span>
        </div>
        @endif
    </div>
</div>