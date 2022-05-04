<div class="draggable" id="pos__1">
    <a href="#" class="drag_block_move" draggable="false"></a>

    <div class="">
        <div class="sub-title">
            {{ trans('all.information') }} :
        </div>
    </div>
    <div class="title-cargo-info modal-info-block">
        <div class="mb-1 modal-with-order">
            <div class="info-row">
                <span class="title-row">{{trans('all.cargo')}}:</span>
                <span id="value_cargo" class="value primary"></span>
            </div>
        </div>
        <div class="mb-1">
            <div class="info-row">
                <span class="title-row">{{trans('all.transport')}}:</span>
                <span class="primary">
                                        <span id="value_transport" class="value"></span>
                                        (ID <span id="value_transport_id" class="value"></span>)
                                    </span>
            </div>
        </div>
        <div class="mb-1">
            <div class="info-row">
                <span class="title-row">{{trans('all.driver')}}:</span>
                <span id="value_driver"  class="value primary"></span>
            </div>
        </div>
        <div class="mb-2 modal-with-order">
            <div class="info-row">
                <span class="title-row">{{trans('all.payment_sum')}}:</span>
                <span id="value_amount_plan" class="value primary">
                                        <span class="value"></span>
                                        <span class="modal-with-order">{{trans('all.UAH')}}</span>
                                    </span>
            </div>
        </div>
    </div>

    <div class="modal-info-block-separated">
        <div class="address-wrap">
            <div class="address-block mb-2">
            </div>
        </div>
        <div class="col-xs-2 col-xs-offset-1">
        </div>
        <div class="clearfix"></div>
    </div>

</div>