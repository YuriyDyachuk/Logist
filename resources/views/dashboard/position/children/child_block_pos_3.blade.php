<div class="col-sm-4 nested-1" id="childPos__3">
    <div class="workstat_block_sm workstat-green">
        <div class="value-title">{{trans('all.counts.free_auto')}}</div>

        <!-- Content count and percent -->
        <div class="content">
            <div class="title-col value"></div>
            <div class="value-trend-green"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="value-title">{{trans('all.counts.last_week')}}</span></div>
            <div style="display: none" class="value-trend-red"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="value-title">{{trans('all.counts.last_week')}}</span></div>
        </div>
        <!-- -->

    @include('dashboard.__includes.__arrow_square')
    <!-- graph bottom line -->
        @include('dashboard.__includes.__vector_lines')
    </div>
    <div class="drag_block_move" style="display: none"></div>
</div>