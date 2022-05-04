<!-- Content orders count rows -->
<div class="draggable row"  id="pos__5" style="margin-bottom: 20px;">
    <a class="drag_block_move" style="display: none" draggable="false"></a>
    <div class="col-sm-12">
        <div class="order-graph">
            <div class="row">
                <div class="col-sm-12">
                    <div class="inform-content-sum">
                        <div class="title-col value">
                            <span>{{trans('all.funnel_orders')}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 block-order__graph">

                    <div class="col-sm-8 block-order__graph" style="flex-direction: column;">

                        <div class="count-graph-percent">
                            <div class="title-col value">
                                <span></span>
                            </div>
                        </div>

                        <div id="trapezium-one">
                            <span></span>
                        </div>
                        <div id="trapezium-two">
                            <span></span>
                        </div>
                        <div id="trapezium-three">
                            <span></span>
                        </div>
                    </div>

                    <div class="col-sm-3 block-order__graph">
                        <div class="circle-one">
                            <div class="round"></div>
                            <div class="value-title">{{trans('all.counts.count_calls')}}</div>
                        </div>
                        <div class="circle-two">
                            <div class="round"></div>
                            <div class="value-title">{{trans('all.counts.count_requests')}}</div>
                        </div>
                        <div class="circle-three">
                            <div class="round"></div>
                            <div class="value-title">{{trans('all.counts.order')}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->