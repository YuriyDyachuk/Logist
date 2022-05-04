@if(checkPaymentAccess('partners'))
<!-- Modal -->
<div id="partner-tutorial-modal" style="" class="modal tutorial" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content transition">
            <div class="modal-header">
                {{--<h4 class="modal-title" style="margin-bottom: 15px">Добавление транспорта</h4>--}}
            </div>
            <div class="modal-body">
                <div class="text-center tutorial_image">
                    <img src="/img/icon/tutorial-partner.svg" class="img-responsive">
                </div>
                <div class="text-center tutorial_title">{{ trans('all.partner') }}</div>
                <div class="text-center">
                    {{ trans('all.partner_add_first') }}
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn button-style1" onclick="event.preventDefault(); $('.tutorial').modal('hide'); $('#addPartner').modal('show');" href="#">{{ trans('all.partner_add') }}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
