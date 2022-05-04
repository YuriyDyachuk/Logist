<!-- Content calendar and maps -->
<div class="draggable calendar-maps"  id="pos__3">
    <a class="drag_block_move" style="display: none" draggable="false"></a>
    <div class="row">
        <div class="col-sm-6">

            <!-- header rows -->
            <div class="workstat_block_sm" id="date-time_rows">
                @include('dashboard.__includes.__arrow_square')
            </div>
            <!-- -->

            <!-- Content count and percent -->
            <div class="map-container">
                <div id="map" class="map-item"></div>
            </div>
            <!-- -->
        </div>
        <div class="col-sm-6">
            <!-- Content date time rows -->
            <div class="workstat_block_sm" id="date-time_rows">
                <div class="calendars-title">
                    <div class="row" style="display: flex;align-items: center;">
                        <div class="col-sm-3">
                            <span class="title-col value">{{trans('all.counts.calendar')}}</span>
                        </div>
                        <div class="col-sm-8">
                            <span class="time-date title-col value"><?php echo date('Y-m-d') ?></span>
                        </div>
                    </div>
                </div>

                @include('dashboard.__includes.__arrow_square')
            </div>
            <!-- End content date time rows -->

            <!-- Content calendar block -->
            <div class="line-content workstat_block_sm" style="height: 450px;overflow: hidden;">
                <div class="row bt">
                    <div id='calendar'></div>
                </div>
            </div>
            <!-- End content calendar block -->
        </div>
    </div>
</div>
<!-- End content calendar and maps -->