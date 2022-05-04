<!-- Modal -->
<div class="modal fade" id="graphSign" tabindex="-1" role="dialog" aria-labelledby="graphSignLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="graphSignLabel">Добавить подпись</h4>
            </div>
            <div class="modal-body" style="border: 1px solid gray; margin: 10px 20px; vborder-radius: 7px;">
                <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>

            </div>
            <div class="modal-footer" style="padding: 30px 5% 30px;">
                <button type="button" class="btn button-style1" id="clearGraphSign">{{ trans('all.clean') }}</button>
                <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" class="btn button-style1" id="saveGraphSign">{{ trans('all.save') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <script>
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });
        var saveButton = document.getElementById('saveGraphSign');
        var cancelButton = document.getElementById('clearGraphSign');

        saveButton.addEventListener('click', function (event) {
            var sign = signaturePad.toDataURL('image/png');

            var document_id = $('#graphSign').data('document_id');

            $.ajax({
                url     : '{{route('documents.save_graph_sign')}}',
                type    : 'post',
                data    : {'document_id' : document_id, 'file' : sign},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (data) {
                    signaturePad.clear();
                    $('#graphSign').modal('hide');
                    window.location.reload();
                    console.log(data);
                },
                error   : function (data) {
                    console.log(data)
                }
            });
        });

        cancelButton.addEventListener('click', function (event) {
            signaturePad.clear();
        });

        $('#graphSign').on('show.bs.modal', function (e) {
            let document_id = e.relatedTarget.dataset.document;
            $('#graphSign').data('document_id', document_id);
            signaturePad.clear();
        })
    </script>
@endpush