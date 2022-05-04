<!-- Modal -->
<div class="modal fade" id="scanSign" tabindex="-1" role="dialog" aria-labelledby="scanSignLabel" data-document="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="scanSignLabel">Загрузить подпись</h4>
            </div>
            <div class="modal-body">
                <div class="upload-block text-center" style="margin-left: auto; margin-right: auto; margin-top: 20px;">


                    <div class="photo">
                        <input type="file" id="scanDocFile" name="upload_file" class="form-control photo-upload">
                    </div><label for="scanDocFile" class="label-upload control-label">загрузить файл</label>
                </div>
            </div>
            <div class="modal-footer" style="padding: 30px 5% 30px;">
                <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" class="btn button-style1" id="saveScanSign">{{ trans('all.save') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>

        $(document).ready(function () {
            /* EVENTS */
            // Upload files
            $('body').on('change', ".photo-upload", function (e) {

                console.log('photo-upload');

                var $this      = $(this);
                var id         = $this.attr('id');
                var countFiles = $this[0].files.length;
                var imgPath    = $this[0].value;
                var extn       = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

                if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
                    if (typeof (FileReader) !== "undefined") {
                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                $this.parent()
                                    .css({
                                        backgroundImage: 'url(' + e.target.result + ')',
                                        backgroundSize : 'contain',
                                    })
                                    .append('<span class="delete-img"></span>')
                                    .removeClass('hidden');
                            };
                            newFileInput(id);
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    } else {
                        appAlert("", "This browser does not support FileReader.", "error");
                    }
                } else {
                    appAlert("", "Pls select only images", "error");
                }
            });

            function newFileInput(id) {
                var $this = $('[for="' + id + '"]'),
                    attr  = $this.attr('for'),
                    el    = $this.prev().clone(),
                    num   = attr.split('-');

                ++num[1];
                var newId = num.join('-');

                $this.attr('for', newId);
                $(el)
                    .addClass('hidden')
                    .find('#' + attr)
                    .attr('id', newId).val('')
                    .removeAttr('required')
                    .end()
                    .insertBefore($this);
            }

//Delete uploaded file
            $('.image-block').on('click', '.delete-img', function () {
                let $this      = $(this),
                    $parent    = $this.parent(),
                    _countFile = $parent.siblings('.photo:not(.hidden)').length;

                if (_countFile > 0) {
                    $parent.fadeOut(300, function () {
                        $(this).detach();
                    });
                }
                if (_countFile === 0 && $this.siblings('input[type="file"]').val() !== '') {
                    $parent
                        .siblings('.photo.hidden').removeClass('hidden').end()
                        .detach();
                }
            });

            $('#scanSign').on('show.bs.modal', function (e) {
                let document_id = e.relatedTarget.dataset.document;
                $('#scanSign').data('document_id', document_id);
            });

            $('#saveScanSign').on('click', function(e) {

                let file = $('#scanDocFile').val();

                console.log('saveScanSign');

                if (file) {
                    console.log(file);

                    var document_id = $('#scanSign').data('document_id');

                    console.log(document_id);

                    var file_data = $('#scanDocFile').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('document_id', document_id);

                    $.ajax({
                        url     : '{{route('documents.save_scan_sign')}}',
                        type: "post",
                        data: form_data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "cache-control": "no-cache, no-store"
                        },
                        cache: false,
                        contentType: false,
                        processData: false})
                        .done( function (data) {
                            $('#scanSign').modal('hide');
                            window.location.reload();
                        })
                        .fail(function (data) {

                        });
                }
            });

        });



    </script>
@endpush