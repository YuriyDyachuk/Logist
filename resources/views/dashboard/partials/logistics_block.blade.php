<div role="tabpanel" class="row  tab-pane fade in active transition"  id="logistics">
    <div class="col-xs-12 col-sm-12 col-md-9" id="scrollbarAddress">

        @php
            if($positions === false){
                $blocks_array = ['1', '2', '3', '4', '5'];
            } else {
                $blocks_array = $positions;
            }
        @endphp

        @foreach($blocks_array as $block)
            @include('dashboard.position.block_pos_'.$block)
        @endforeach

    </div>

    <!-- Vue components message dashboard -->
    <div class="col-xs-12 col-sm-12 col-md-3" id="push">
        @include('dashboard.partials.message-push')
    </div>
    <!-- End vue components message dashboard -->

</div>