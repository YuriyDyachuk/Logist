<div class="draggable row" id="pos__1">
    <a class="drag_block_move" style="display: none" draggable="false"></a>
    @php
        if($positions_child === false){
            $blocks_array = ['1', '2', '3'];
        } else {
            $blocks_array = $positions_child;
        }
    @endphp

    @foreach($blocks_array as $block)
        @include('dashboard.position.children.child_block_pos_'.$block)
    @endforeach
</div>