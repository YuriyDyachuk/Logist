@push('scripts')
@if($clients->count() == 0)
<script>
    $(function() {
        $('.tutorial').modal('show');
    });

</script>
@endif
@endpush

<!-- Modal -->
<div id="tutorial_" style="" class="modal tutorial" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content transition">
            <div class="modal-header">
                {{--<h4 class="modal-title" style="margin-bottom: 15px">Добавление транспорта</h4>--}}
            </div>
            <div class="modal-body">
                <div class="text-center tutorial_image">
                    <img src="/img/icon/tutorial-client.svg" class="img-responsive">
                </div>
                <div class="text-center tutorial_title">{{ trans('all.client') }}</div>
                <div class="text-center">{{ trans('all.add_client_tutorial_text') }}</div>
            </div>
            <div class="modal-footer">
                <a class=" btn button-style1" onclick="event.preventDefault(); $('.tutorial').modal('hide'); $('#addClient').modal('show');" href="#">{{ trans('all.add_client') }}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
