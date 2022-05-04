<!-- Content graphics lines -->
<div class="draggable content-graphics"  id="pos__2">
    <a class="drag_block_move" style="display: none" draggable="false"></a>
    <div class="row">
        <div class="col-sm-3">
            <div class="inform-content-sum">
                <div class="title-col value">
                    <span>{{trans('all.average_freight')}}</span>
                </div>

                <div class="count-sum">
                    <div class="title-col value"></div>
                    <div class="value-trend-green"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="value-title">{{trans('all.counts.last_week')}}</span></div>
                    <div style="display: none" class="value-trend-red"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="value-title">{{trans('all.counts.last_week')}}</span></div>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <canvas id="myChart" width="700" height="250"></canvas>
        </div>
    </div>
</div>
<!-- End content graphics lines -->