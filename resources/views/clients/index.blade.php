@extends("layouts.app")

@section("content")
    <div class="content-box clients-page">
        @include('clients.includes.header')

        @include('clients.includes.list-clients')
    </div>
@endsection

@section('modals')
    @include('clients.includes.create-edit')
    @include('clients.partials.modals-tutorial')
@endsection

@push('scripts')
    <script>

        // clients dop info
        // $('.card-order--clients').on('click',function (e){
        //     console.log(e.target);
        //
        //     if ($(this).find('.dop-info').is(":hidden")) {
        //         $(this).find('.dop-info').show()
        //     } else {
        //         $(this).find('.dop-info').hide();
        //     }
        //     return false;
        // });

        $('.content-box__row').on('click', '.card-order--clients', function (event) {
            let target = $(event.target),
                stopped = target.is(".btn-collapse");

            if (!stopped) {
                $(this)
                    .find('.btn-collapse').toggleClass('collapsed').end()
                    .parent().find('.panel-collapse').collapse('toggle');
            }
        });


        var inputPhones = $(".phone");

        inputPhones.intlTelInput({
            initialCountry: "ua",
            nationalMode: false,
            formatOnDisplay: true,
            utilsScript: "{{url('plugins/phone_input/js/utils.js')}}",
        });

        $('.content-box.clients').on('click', '.panel-group', function (event) {
            let target = $(event.target),
                stopped = target.is(".btn-collapse") || target.is(".trash") || target.is(".edit");

            if (!stopped) {
                $(this)
                    .find('.btn-collapse').toggleClass('collapsed').end()
                    .find('.panel-collapse').collapse('toggle');
            }
        });

        function removeClient(id) {
            appConfirm('', '{{ __('all.client_delete_warning') }}', 'question', function () {
                if (id <= 0) return;
                $.ajax({
                    url: '/client/' + id,
                    type: 'DELETE',
                    data: {_token: CSRF_TOKEN}
                })
                    .done(function (res) {
                        if (res.status === 'success') {
                            window.location.reload();
                        }
                    })
                    .fail(function () {
                        swal('Something went wrong... :(', '', 'warning');
                    })
            });
        }

        function sendInvite(clientId) {
            if (clientId > 0) {
                let notify = $.notify('<b>Отправка...</b>', {
                    type: 'info',
                    allow_dismiss: false,
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<span data-notify="message">{2}</span></div>'
                });

                $.get('/client-invite/' + clientId)
                    .done(function (res) {
                        if (res.status === 'success') {
                            // $.notify({message:'Запрос успешно отправлен.'}, {type:'success'});
                            setTimeout(function () {
                                notify.update({message: '<b>Запрос успешно отправлен.</b>', type: 'success'});
                            }, 1000);
                        }
                    })
                    .fail(function () {
                        appLoader(false);
                        swal('Something went wrong... :(', '', 'warning');
                    })
            }
        }
    </script>
@endpush