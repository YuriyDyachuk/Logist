<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == null ? ' active in':''   }}" id="documents">
    <div class="documents_list">

        @include('documents.partials.filters')
        @include('documents.partials.list-documents')
    </div>
</div>