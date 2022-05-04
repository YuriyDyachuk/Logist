<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == null ? ' active in':''   }}" id="instructions">
    <div class="instructions_list">
        @foreach($instructions as $instruction)
            @include('faq.includes.item', ['item' => $instruction, 'current_level' => 1, 'level' => []])
        @endforeach
    </div>
</div>