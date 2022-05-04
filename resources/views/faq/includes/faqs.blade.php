<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == 'faqs' ? ' active in':''   }}" id="faqs">
    <div class="instructions_list">


        @foreach($faqs as $faq)
            @include('faq.includes.item', ['item' => $faq, 'current_level' => 1, 'level' => []])
        @endforeach


    </div>
</div>