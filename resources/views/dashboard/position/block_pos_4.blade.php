<!-- Content three counts column -->
<div class="draggable row" id="pos__4">
    <a class="drag_block_move" style="display: none" draggable="false"></a>
    @php
        if($positions_child_two === false){
            $blocks_array = ['4', '5', '6'];
        } else {
            $blocks_array = $positions_child_two;
        }
    @endphp

    @foreach($blocks_array as $block)
        @include('dashboard.position.children.child_block_pos_'.$block)
    @endforeach
</div>
<!--  -->