<div role="tabpanel" class="tab-pane fade transition clearfix" id="progress">
    <div class="row">
        @if(($order->hasStatus('active') && ($user->isLogistic() || $user->isLogist())) || $order->hasStatus('planning'))
            <div class="col-xs-12">
                <h6 class="h6 title-block">{{trans('all.progress_elements')}}</h6>
            </div>

            <div class="col-xs-12">
                <ul class="progress_type">
                    <li data-progress-type="accepted">
                        <div>
                            <i class="as as-accepted"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_accepted')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="download">
                        <div>
                            <i class="as as-loading"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_loading')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="inway">
                        <div>
                            <i class="as as-inway"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_to_flight')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="upload">
                        <div>
                            <i class="as as-unloading"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_unloading')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="delivered">
                        <div>
                            <i class="as as-delivered"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_delivered')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="signature">
                        <div>
                            <i class="as as-signature"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_signature')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="loaddocs">
                        <div>
                            <i class="as as-loaddocs"></i>
                            <h6 class="h6 title-grayblue" data-name>{{trans('all.progress_document_upload')}}</h6>
                        </div>
                    </li>
                    <li data-progress-type="create">
                        <div>
                            <i class="as as-additem"></i>
                            <h6 class="h6 title-grayblue">{{trans('all.progress_add_element')}}</h6>
                        </div>
                    </li>
                </ul>
            </div>
        @endif

        <div class="col-xs-12">
            <h2 class="h2 title-block">{{trans('all.progress')}}</h2>

            <ul id="progressBox"></ul>
        </div>

        @if($order->hasStatus('completed'))
            <div class="col-xs-12 text-status">
                <p class=""> <img src="/img/icon/order_completed.png">
                </p>
                <p>
                    {{trans('all.order_date_completed')}}: {{($order->completed_at) ? \Carbon\Carbon::parse($order->completed_at)->format('Y/m/d H:i') : \Carbon\Carbon::parse($order->updated_at)->format('Y/m/d H:i')}}
                </p>
            </div>
        @endif

    </div>
</div>

@include('orders.partials.show.includes.new-progress-modal')



@push('scripts')
    @if(($order->hasStatus('active') && ($user->isLogistic() || $user->isLogist())) || $order->hasStatus('planning'))
        <script src="{{ url('bower-components/jquery-ui-sortable/jquery-ui-sortable.min.js') }}"></script>
        <script>
            var $progressBox = $('#progressBox');
            var $modal       = $('#newProgressModal');
            var $LoadModal       = $('#newLoadModal');


            $modal.find('input[name="name"]').keyup(function () {
                if ($(this).val() !== '')
                    $('#addProgress').prop('disabled', false);
                else
                    $('#addProgress').prop('disabled', true);
            });

            $progressBox.sortable({
                                      opacity: 0.8,
                                      update: function (event, ui) {
                                          progress.save();
                                      }
                                  });

            $('[data-progress-type]').click(function () {

                var type = $(this).data('progress-type');

                if (type === 'create') {
                    $modal.modal('show');
                } else if(type == 'download' || type == 'upload'){

                    $LoadModal.modal('show');
                    $LoadModal.find('.type').val(type);
                    $LoadModal.find('.position').val(0);
                    var name = $(this).find('[data-name]').text();
                    $LoadModal.find('.name').val(name);

                } else {
                    var data = {
                        type: $(this).data('progress-type'),
                        name: $(this).find('[data-name]').text(),
                        date_at: '__/__/____',
                        address: '---',
                        completed: 0,
                        position: progress.getNewPosition(),
                    };

                    progress.create(data);
                    progress.save();
                }
            });

            $('#createLoad').click(function () {

                var address_id = $LoadModal.find('.address_id').val();
                var position_id = $LoadModal.find('.position').val();
                if(address_id != '') {

                    let date_full = $LoadModal.find('.date_time').val();
                    date_full = date_full.split(' ');
                    let date = date_full[0].split('/');
                    let time = date_full[1];
//
                    let d = date[2]+'-'+date[1]+'-'+date[0]+' '+time;

                    let data = {
                        type: $LoadModal.find('.type').val(),
                        name: $LoadModal.find('.name').val(),
                        date_at: d,
                        address: $LoadModal.find('.autocomplete').val(),
                        address_id: $LoadModal.find('.address_id').val(),
                        completed: 0,
                        position: progress.getNewPosition(),
                    };

                    if(position_id == 0) {
                        progress.create(data);
                    } else {
                        $('data-progress').each(function( index ) {
                            let data_current   = $.parseJSON($(this).text());
                            if(data_current.position == position_id){
                                data.position = data_current.position;
                                $(this).text(JSON.stringify(data));
                                $(this).parent().find('.address').html(data.address);
                                console.log(data.date_at);
                                $(this).parent().find('.p-date').html(data.date_at);
                            }
                        });
                    }

                    progress.save();
                    $LoadModal.find('.address_id').val('')
                    $LoadModal.find('.autocomplete').val('');
                    $LoadModal.find('.date_time').val('');
                    $LoadModal.find('.name').val('');
                    $LoadModal.modal('hide');
                    $LoadModal.find('.autocomplete').parent().removeClass('has-error');
                } else {
                    $LoadModal.find('.autocomplete').parent().addClass('has-error');
                }
            });


            $LoadModal.on('click', '.autocomplete-result a', function () {
                let $_parent = $(this).parent().parent(),
                        placeId  = $(this).attr('data-place');

                $_parent.find('input.autocomplete').val($(this).text());


                $.get('{{ url('address/details') }}', {place_id: placeId}).done((data) => {
                        if (!$.isEmptyObject(data)) {
                        let $_input = $LoadModal.find('.address_id');
                        $_input.val(data.id);
                    }
                })


            });


            $('#addProgress').click(function () {
                let data = {
                    type: $modal.find('[name="type"]:checked').val(),
                    name: $modal.find('[name="name"]').val(),
                    date_at: '__/__/____',
                    address: '---',
                    completed: 0,
                    position: progress.getNewPosition(),
                };

                $modal.modal('hide');
                progress.create(data);
                progress.save();
            });

            $progressBox.on('click', '.as-del', function () {
                progress.delete($(this));
            });


            $progressBox.on('click', '.completed', function () {
                progress.completed(this);
            });


            $progressBox.on('click', '.fa-edit', function () {
                progress.elem = $(this);

                if ($(this).hasClass('fa-ban')) {
                    progress.check();
                    return;
                }

                let $modal  = $('#checkProgressModal'),
                    title   = progress.elem.data('name'),
                    address = progress.elem.siblings('.body').find('.address').text();

                let $item  = progress.elem.siblings('data-progress');
                let data   = $.parseJSON($item.text());

                if (address === '---') {
                    address = '';
                }

                if(data.type == 'upload' || data.type == 'download'){
                    $LoadModal.find('.address_id').val(data.address_id);
                    $LoadModal.find('.autocomplete').val(data.address);
                    $LoadModal.find('.date_time').val(data.date_at);
                    $LoadModal.find('.name').val(data.name);
                    $LoadModal.find('.position').val(data.position);
                    $LoadModal.modal('show');
                } else {
                    $modal.find('.modal-title').text(title);
                    $modal.find('#autocomplete').val(address);
                    $modal.modal('show');
                    progress.elem = $(this);
                }
            });

        </script>

    @endif
    <script>
        var arr         = $.parseJSON(JSON.stringify({!! json_encode($order->progress) !!}));
        var progress    = new Progress(arr, $('#progressBox'));
        var statusOrder = '{{ $order->getStatus()->name }}';
        var isLogistic  = +'{{ ($user->isLogistic() || $user->isLogist()) ? true : false  }}';

        progress.init();

        function Progress(data, $box) {

            this.data = data;
            this.elem = null;

            this.save = function () {
                let data       = [],
                    url        = '{{ url('/progress', $order->id) }}',
                    disableBtn = false;

                $box.find('.item').each(function () {
                    if (!$(this).hasClass('check'))
                        disableBtn = true;
                    data.push($.parseJSON($(this).find('data-progress').text()));
                });

                disableBtnCompleted(disableBtn);
                this.data = data;

                $.ajax({
                           url: url,
                           type: 'PUT',
                           data: {_token: CSRF_TOKEN, data: data}
                       })
                 .done(function (data) {
                     if (data.status === 'success')
                         $.notify(
                             {
                                 title: 'Сохранено'
                             },
                             {
                                 template:
                                 '<div data-notify="container" class="alert alert-{0}" role="alert">' +
                                 '<span data-notify="icon"></span>' +
                                 '<span data-notify="title"> {1}</span>' +
                                 '</div>'
                             });
                 })
                 .fail(function (data) {
                     console.log(data);
                     appAlert('', 'Something went wrong... :(', 'warning');
                 });
            };

            this.delete = function ($this) {
                let _this = this;

                appConfirm('', 'Подтвердите удаление элемента', 'question', function () {
                    $this.parent().detach();
                    _this.save();
                });
            };

            this.init = function () {
                let _this = this;
                $.each(this.data, function (key, item) {
                    if (item.completed == '0')
                        disableBtnCompleted(true);
                    $box.append(_this.template(item));
                })
            };

            this.create = function (data) {
                $box.prepend(this.template(data));
            };

            this.completed = function(el){

                progress.elem = $(el);

                let $item  = progress.elem.siblings('data-progress');
                let data   = $.parseJSON($item.text());
                let completed = data.completed == '0' ? 'fa-check-square-o' : 'fa-ban';
                let date = new Date();
                let dateFormat = date.getFullYear()+ '/' + (date.getMonth() < 10 ? '0'+date.getMonth() : date.getMonth())+ '/' + (date.getDate() < 10 ? '0'+date.getDate() : date.getDate())+ ' ' + date.getHours()+ ':' + date.getMinutes();

                if(data.completed == 1) {
                    data.completed = 0;
                    data.date_update = 0;
                    $item.parent().removeClass('check');
                    progress.elem.removeClass('fa-ban');
                    progress.elem.addClass('fa-check-square-o');
                    progress.elem.parent().find('.update-date').text('');
                } else {
                    data.completed = 1;
                    data.date_update = dateFormat;
                    $item.parent().addClass('check');
                    progress.elem.removeClass('fa-check-square-o');
                    progress.elem.addClass('fa-ban');
                    progress.elem.parent().find('.update-date').text(dateFormat);
                }

                $item.text(JSON.stringify(data));
                this.save();

            };

            this.getNewPosition = function(){
                let data   = [];
                var position = 0;
                var max = null;

                $box.find('.item').each(function () {
                    data.push($.parseJSON($(this).find('data-progress').text()));
                });


                console.log(data);

                data.forEach(function(element) {
                    if(typeof element.position == 'number' || typeof element.position == 'string') {
                        var current = parseInt(element.position);
                        if(max == null || current>max){
                            position = current + 1;
                            max = current;
                        }
                    }
                });

                return position;
            };

            this.check = function (address, date) {
                let $item  = this.elem.siblings('data-progress');
                let data   = $.parseJSON($item.text());
                let parent = this.elem.parents('.item');

                data.completed = data.completed;
                data.address   = address;
                data.date_at   = date;

                let d= new Date(date);
                let date_format_at =
                    (d.getDate()<10?'0':'') + d.getDate()+'/'+
                    ((d.getMonth() + 1)<10?'0':'') + (d.getMonth()+1)+'/'+
                    d.getFullYear()+' '+
                    (d.getHours()<10?'0':'') + d.getHours()+':'+
                    (d.getMinutes()<10?'0':'') + d.getMinutes();

                $(parent)
                        .find('.address').text(address).end()
                        .find('.p-date').text(date_format_at);

                $item.text(JSON.stringify(data));

                this.save();
            };

            this.template = function (data) {
                let completed = data.completed == '0' ? 'fa-check-square-o' : 'fa-ban';
                let checkItem = data.completed == '0' ? '' : ' check';

                let date_format_at;

                if(data.date_at == '__/__/____'){
                    date_format_at = data.date_at;
                }
                else {
                    let d= new Date(data.date_at);
                    date_format_at =
                        (d.getDate()<10?'0':'') + d.getDate()+'/'+
                        ((d.getMonth() + 1)<10?'0':'') + (d.getMonth()+1)+'/'+
                        d.getFullYear()+' '+
                        (d.getHours()<10?'0':'') + d.getHours()+':'+
                        (d.getMinutes()<10?'0':'') + d.getMinutes();
                }

                let html      =
                        '<li class="item' + checkItem + '">' +
                        '<data-progress style="display: none;">' + JSON.stringify(data) + '</data-progress>' +
                        '<div class="body clearfix">' +
                        '<i class="as as-' + data.type + '"></i>' +
                        '<div class="description">' +
                        '<h3><span>' + data.name + '</span></h3>' +
                        '<div class="address">' + (data.address || '---')+ '</div>' +
                        '<div class="p-date">' + date_format_at + '</div>' +
                        '<div class="update-date">' + ((data.date_update !== '0' && data.date_update !== undefined) ? data.date_update : '') + '</div>' +
                        '</div>' +
                        '</div>';

                switch (statusOrder) {
                    case 'active':
                        if (isLogistic) {
                            html += '<i class="fa ' + completed + ' completed" aria-hidden="true" data-completed="0" data-name="' + data.name + '"></i>' +
                                '<i class="fa fa-edit"></i>' +
                                '<i class="as as-del"></i>';


                        }
                        break;

                    case 'planning':
                        html += '<i class="as as-del"></i>';
                        break;
                }

                return html += '</li>';
            };
        }

        function disableBtnCompleted(disabled) {
            if (disabled) {
                $('#completed').attr('dis', 'disabled');
            } else {
                $('#completed').removeAttr('dis');
            }
        }

    </script>
@endpush
