<!-- Modal -->
<div class="modal" id="newProgressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title title-blue">Добавить элемент</h2>
            </div>

            <div class="modal-body text-center">
                <div class="btn-group progress_type" data-toggle="buttons">
                    <label class="btn as as-additem">
                        <input type="radio" value="additem" name="type" checked>
                    </label>
                </div>

                <div class="form-group">
                    <input type="text" maxlength="30" class="form-control" name="name" placeholder="{{ trans('all.progress_add_element_name') }}">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" id="addProgress" class="btn button-style1"
                        disabled><span>{{ trans('all.create') }}</span></button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="newLoadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title title-blue">{{ trans('all.progress_add_element') }}</h2>
            </div>

            <div class="modal-body ">
                <input type="hidden" name="position" class="position">
                <input type="hidden" name="type" class="type">
                <input type="hidden" name="address_id" class="address_id" value="">
                <input type="hidden" name="name" class="name">
                <div>
                    <div class="form-group">
                        <span class="label-input">{{trans('all.address')}}</span>
                        <input id="autocomplete" class="form-control autocomplete"
                               onfocus="this.select(); this.parentNode.classList.remove('has-error');"
                               required>
                    </div>
                    <div class="form-group">
                        <span class="label-input">{{ trans('all.date') }}</span>
                        <input type="text" class="form-control date_time" value="221220170835">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" id="createLoad" class="btn button-green xs"><span>{{ trans('all.create') }}</span></button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="checkProgressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title title-blue"></h2>
            </div>

            <div class="modal-body">
                <div>
                    <div class="form-group form-group__autocomplete">
                        <span class="label-input">{{trans('all.address')}}</span>
                        <input id="autocomplete" class="form-control autocomplete" name="autocomplete"
                               onfocus="this.select(); this.parentNode.classList.remove('has-error');" value=""
                               required>
                    </div>
                    <div class="form-group">
                        <span class="label-input">{{ trans('all.date') }}</span>
                        <input type="text" class="form-control date_time" name="date" value="221220170835">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" class="btn button-style1" onclick="checkProgress()"><span>{{ trans('all.save') }}</span></button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var $date = $('.date_time');

        var options     = {
            locale    : 'ru',
            format    : 'DD/MM/YYYY HH:mm',
            sideBySide: true
        };

        $date.datetimepicker(options);
        $date.on("dp.show", function (e) {
            var min = new Date();
            $(this).data("DateTimePicker").minDate(min);
        });

        // $date.val(formatDate(new Date()));
        // $date.mask('00/00/0000 00:00');

        $('#checkProgressModal').on('show.bs.modal', function (e) {
            $date.val(formatDate(new Date()));
        });

        $('#newLoadModal').on('show.bs.modal', function (e) {
            $date.val(formatDate(new Date()));
        });




        function formatDate(date) {

            var dd = date.getDate();
            if (dd < 10) dd = '0' + dd;

            var mm = date.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;

            var yy = date.getFullYear();
            if (yy < 10) yy = '0' + yy;

            var hh = date.getHours();
            if (hh < 10) hh = '0' + hh;

            var min = date.getMinutes();
            if (min < 10) min = '0' + min;

            return dd +'/'+ mm + '/'+ yy + ' '+ hh +':'+ min;
        }

        function checkProgress() {
//            if (!autocomplete.checkValidity()) {
//                autocomplete.parentNode.classList.add('has-error');
//                return;
//            }

            if($('input[name=autocomplete]').val() === ''){
                $('.form-group__autocomplete').addClass('has-error');
                return;
            }

//            progress.check(autocomplete.value, $date.val());

            let d = $('input[name=date]').val();
            let d_ar = d.split(' ');
            d_ar_dates = d_ar[0].split('/');
            let date = d_ar_dates[2] + '-' + d_ar_dates[1] + '-' + d_ar_dates[0] + ' ' + d_ar[1];

            progress.check($('input[name=autocomplete]').val(), date);

            $('#checkProgressModal').modal('hide');
        }
    </script>
@endpush