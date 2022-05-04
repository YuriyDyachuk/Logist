<!-- Modal -->
<div id="driver-tutorial-modal" style="" class="modal tutorial" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content transition">
            <div class="modal-header">
                {{--<h4 class="modal-title" style="margin-bottom: 15px">Добавление транспорта</h4>--}}
            </div>
            <div class="modal-body">
                <div class="text-center tutorial_image">
                    <img src="/img/icon/tutorial-driver.svg" class="img-responsive">
                </div>
                <div class="text-center tutorial_title">{{ __('all.driver') }}</div>
                <div class="text-center">
                    {{ __('all.add_client_driver_text') }}
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn button-style1" onclick="event.preventDefault(); $('.tutorial').modal('hide'); $('#addEmployee').modal('show');" href="#">{{ __('all.add') }}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
