@extends("layouts.app")

@section("content")
{{--    @inject('helper', '\App\Helpers\Options')--}}

    <div class="content-box profile-page settings-page">

        @include('settings.layouts.header')

        <div class="content-box__body-tabs" data-class="dragscroll">
            <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
                <li role="presentation" class="active transition"><a href="#info" role="tab" data-toggle="tab">{{trans('all.main_info')}}</a></li>
                @if($user->isLogist() === false)
                    <li role="presentation" class="transition"><a href="#documents"role="tab" data-toggle="tab">{{ trans('all.documents') }}</a></li>
                @endif
            </ul>
        </div>

        <div class="content-box__body">

            <form class="form-horizontal" name="edit_user" method="POST" id="edit_user" action="{{route('user.profile.update')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- Tab content: BEGIN -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade in active transition" id="info" style="/*background-color: #FFF;*/">
                    <div class="row">

                            <input type="hidden" name="role" value="{{ $user->getRole() }}">

                            <div class="col-md-6 col-lg-6 general-info">
                                @include('settings.layouts.general-information')
                                @if(profile_filled() && $user->isLogist() === false)
                                        <div class="form-group">
                                            <label class="control-label col-sm-4">{{ trans('all.account_type_change') }}</label>
                                            <div class="col-sm-8">
                                                <button type="button" class="btn button-style2" id="requestChangeType">{{ trans('all.account_type_request') }}</button>
                                            </div>
                                        </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-lg-6 detail-info">
                                @include('settings.layouts.additional-information')
                                @includeWhen($user->isLogistic(), 'settings.layouts.credentials-system')
                            </div>


                    </div>
                </div>

                @if(!$user->isClient())
                    <div role="tabpanel" class="tab-pane fade transitione" id="documents">

                            <input type="hidden" name="role" value="{{ $user->getRole() }}">

                            <input type="hidden" name="document" value="1">
                        @if($user->isLogist() === false)
                        @include('settings.layouts.documents')
                        @endif

                    </div>
                @endif

            </div>
            </form>
            @if($user->isLogist() === false)
            {{-- SUBMIT --}}
            <div class="row">
                <div class="col-sm-12 save-profile text-center">
                    <button type="submit" class="btn button-style1"
                            value="submit" id="btn_upd_profile"><span>{{ trans('all.save') }}</span></button>
                </div>
            </div>
            @endif
            <!-- Tab content: END -->
            <div class="clear"></div>
        </div>
    </div>

    @include('settings.layouts.modals')

    {{-- tutorials --}}
    @include('tutorials.tutorials')

@endsection

@push("scripts")
    <script>

        $('input[name=check]').val(0);

        @if(profile_filled() === false && $user->isLogist() === false)

        $('.company_type_label').on('click', function(e) {
            validation_reset();
            $('.profile_type_block').hide();
            val = $(this).find('input').val();
            $('.'+val+'_block').show();
        });

        @else
        $('#requestChangeType').on('click', function(e) {

            data = {
                'name' : '{{auth()->user()->name}}',
                'email' : '{{auth()->user()->email}}',
                'subject' : 'изменение типа учетной записи',
                'message' : 'изменение типа учетной записи',
            };
            $.ajax({
                url: '{{route('feedback.store')}}',
                type: "post",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
                .done( function (data) {
                    console.log(data);
                    appAlert('', 'Сообщение отправлено', 'success');

                })
                .fail(function (res) {
                    console.log(res);
                    appAlert('', 'Something went wrong... :(', 'warning');
                });
        });

        @endif

        $('#btn_upd_profile').on('click', function (e) {
            e.preventDefault();

            let type = getType();
            console.log(type);

            @if(profile_filled() === false && $user->isLogist() === false)
                if(type === undefined){
                    $('#selectProfile').modal('show');
                    return;
                }
            @endif

            let checked = $('input[name=check]').val();

            $('#btn_confirmInformation').prop('disabled', true);

            if(checked === '0'){
                send_data();
                return;
            }

            confirmInformation();
        });

        $('#btn_confirmInformation').on('click', function(e) {
            e.preventDefault();
            send_data();
        });

        $('#confirmInformation').on('hide.bs.modal', function (e) {
            $('input[name=check]').val(0);
        });

        function confirmInformation(){

            let type = getType();

            $('#confirmInformation').modal('show');

            let inn = $('.'+type+'_block').find('input[name=inn]').val();
            let egrpou = $('.'+type+'_block').find('input[name=egrpou]').val();

            let input_value;
            let input_name;

            $('#confirmInformation .modal-body .row').hide();

            $('.'+type+'_block input').each(function() {
                input_value = $(this).val();
                input_name = $(this).attr('name');

                // except input Logo/Signature
                var iRe = /\[/g;
                var iArray = iRe.exec(input_name);

                if(iArray === null){
                    $('#confirmInformation').find('#confirm_'+input_name).show().find('.val').text(input_value);
                }
            });

            $('.'+type+'_block select').each(function() {
                input_value = $(this).val();
                input_value = $(this).find('option:selected').text();
                input_name = $(this).attr('name');

                // except input Logo/Signature
                var iRe = /\[/g;
                var iArray = iRe.exec(input_name);

                if(iArray === null){
                    $('#confirmInformation').find('#confirm_'+input_name).show().find('.val').text(input_value);
                }
            });

//            console.log(egrpou);
            url = ['fullcompany', egrpou];
//            console.log(url);

            $('.confirm_error').hide();

            if(egrpou !== undefined && egrpou !== ''){
                $.ajax({
                    url: '{{route('opendata.opendatabot')}}',
                    type: "post",
                    data: {url: url},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    }})
                    .done( function (data) {
                        console.log(data);

                        if(data.error !== undefined && data.error !== 'Payment Required'){
                            $('#error_egrpou').show();
                        }
                        else {
                            btn_confirmInformation();
                        }
                    })
                    .fail(function (res) {
                        console.log(res);
                    });
            }
            else {
                btn_confirmInformation();
            }
        }

        function btn_confirmInformation(){
            $('#btn_confirmInformation').prop('disabled', false);
        }

        function send_data(){
            let type = getType();

            validation_reset();

            var data2 = new FormData();

            $.each($('.inputfile'), function(i, files) {
                if(files.files[0] !== undefined){
                    data2.append(files.attributes.name.nodeValue, files.files[0]);
                }
            });

            $.each($('.'+type+'_block :input'), function(i, input) {
                var iRe = /images/g;
                var iArray = iRe.exec(input.name);

                if(iArray === null) {
                    data2.append(input.name, input.value);
                }
            });

            $.each($('.credentials-system :input'), function(i, input) {
                data2.append(input.name, input.value);
            });

            $.ajax({
            url: '{{route('user.profile.update')}}',
            type: "post",
            data: data2,
                processData: false,
                contentType: false,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "cache-control": "no-cache, no-store"
            }})
            .done( function (data) {
//                console.log(data);

                if(data.result !== undefined){
                    $('input[name=check]').val(1);
                    confirmInformation();
                }

                if(data.redirect !== undefined){
                    window.location.replace(data.redirect);
                }
            })
            .fail(function (res) {
                if (res.status === 422)
                    validation(res.responseJSON);
                else if(res.status === 409)
                    appAlert('', res.responseJSON.message, 'warning');
                else
                    appAlert('', 'Something went wrong... :(', 'warning');

                return false;
            });
        }

        function validation(errors){

            $('input[name=check]').val(0);
            $.each(errors, function (k, i) {
                let input   = $('[name="' + k + '"]');
                input.parents('.form-group').addClass('has-error shake');
                input.next('.help-block').html('<strong>' + i[0] + '</strong>').show();
            });
        }

        function validation_reset() {
            $('#edit_user').find('.form-group').removeClass('has-error');
            $('#edit_user').find('.form-group').removeClass('shake');
            $('#edit_user').find('.help-block').hide();
        }

        function getType(){

            let type;

            $( 'input[name=company_type]' ).each(function( index ) {
                if($(this). is(":checked")){
                    type = $(this).val()
                }
            });

            @if(profile_filled() === true)
                if(type === undefined){
                    type = $('input[name=type]').val();
                }
            @endif

            return type;
        }

        $('#edit_user select').on('shown.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            validation_reset();
        });


        //        $("#phone, #phone2, #phone_2").intlTelInput({
//            nationalMode: false,
//            formatOnDisplay: false,
//            utilsScript: "plugins/phone_input/js/utils.js",
//        });
        var inputPhones = $(".phone");

        inputPhones.intlTelInput({
            initialCountry: "ua",
            nationalMode: false,
            formatOnDisplay: false,
            utilsScript: "{{url('plugins/phone_input/js/utils.js')}}",
        });

        inputPhones.blur(function () {
            if ($.trim($(this).val())) {
                var $group = $(this).parents('.form-group');

//                $group.find('.help-block').detach();
                if ($(this).intlTelInput("isValidNumber")) {
                    $group.removeClass("has-error");
                } else {
                    $group.addClass("has-error");
                    $group.find(".help-block").html('<strong>{{ trans('all.phone_user_not_valid') }}</strong>');
                }
            }
        });
    </script>
@endpush