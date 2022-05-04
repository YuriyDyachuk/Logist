@extends('layouts.app')

@section('content')
    <div class="content-box">

        @include('mailer.layouts.includes.tabs')

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') === null ? ' active in':''   }}" id="message">
                <div class="panel-group content-box__body">
                    @if ($incomeMailClient->connection !== false)
                        <div class="row">
                            @include('mailer.layouts.includes.folders-block')
                            @include('mailer.layouts.includes.message-body')
                        </div>
                    @else
                        @include('mailer.layouts.includes.errors')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ url('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $('#btn-send-email').on('click', function (e) {
            e.preventDefault();
            let data = new FormData();

            $.each($('.user_info__input input'), function(i, input) {
                data.append(input.name, input.value);
            });

            data.append('message', CKEDITOR.instances.message_body.getData());

            $.each($('.inputfile'), function(i, files) {
                Array.from(files.files).forEach(function(item, i, arr) {
                    data.append(files.attributes.name.nodeValue, item, item.name);
                });
            });

            $.ajax({
                url: '{{ route('mailer.send') }}',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
            .done( function (data) {
                if(data.redirect !== undefined) {
                    window.location.replace(data.redirect);
                }
            })
            .fail(function (res) {
                if (res.status === 422) {
                    let msg = '';
                    $.each(res.responseJSON.errors, (index, value) => {
                        msg += '<p>' + index + ' : ' + value + '</p>';
                    });
                    appAlert('', msg, 'warning');
                } else {
                    let msg = '';
                    $.each(res.responseJSON.errors, (index, value) => {
                        msg += '<p>' +  value + '</p>';
                    });
                    appAlert('', msg, 'warning');
                }

                return false;
            });
        });

        $('.mailer-reply-message').on('click', function (e) {
            e.preventDefault();
            let reply = $(this).data('reply');
            let to;

            if (reply === 'one') {
                to = $('#to_one').val();
                $('#to').val(to);
            } else if (reply === 'all') {
                to = $('#to_all').val();
                $('#to').val(to);
            } else if (reply === 'forward') {
                to = $('#to_one').val();
                $('#to').val(to);
                let message = $('#forward').val().replace(/\n/g, "<br />");
                let editor = CKEDITOR.instances.message_body;

                editor.setData(message.toString());
            }

            $('#reply-buttons').hide();
            $('#reply-block').show();
        });

        $( document ).ready(function() {
            CKEDITOR.replace( 'message_body' );
        });
    </script>
@endpush
