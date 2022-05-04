{{-- COMPANY INFORMATION --}}

{{-- USER NAME CLIENT --}}
    @if(profile_filled() === false && $user->isLogist() === false)
    <div class="col-xs-12">

        <div class="form-group d-inline-block">
            <label class="container_radio company_type_label">{{trans('all.company_type_individual')}}
                <input class="company_type" name="company_type" type="radio" id="" value="individual" autocomplete="off">
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="form-group d-inline-block">
            <label class="container_radio company_type_label">{{trans('all.company_type_company')}}
                <input class="company_type" name="company_type" type="radio" id="" value="company" autocomplete="off">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    @endif

    <div style="clear: both;"></div>

    @if(profile_filled() === false )
    <div class="individual_block profile_type_block" style="display: none;">
        @include('settings.layouts.includes.individual-block')
    </div>

    <div class="company_block profile_type_block" style="display: none;">
        @include('settings.layouts.includes.company-block')
    </div>
    @endif

    @if(profile_filled() === true )
    <div class="{{$user->meta_data['type']}}_block profile_type_block">
        <div class="form-group ">
            <div class="col-sm-12 text-right">
                <a href="" id="btn_edit_settings_open"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('all.edit') }}</a>
                <a href="" id="btn_edit_settings_close" style="display: none"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('all.hide') }}</a>
            </div>
        </div>
        @include('settings.layouts.includes.'.$user->meta_data['type'].'-block')
    </div>
    @endif


    {{--@endif--}}

    {{--<div class="form-group">--}}
        {{--@unless($user->isActivateEmail())--}}
            {{--<div class="col-sm-8 col-sm-offset-4">--}}
                {{--<button class="reactivate_email btn btn-info"--}}
                        {{--href="{{route('user.profile.email.reactivate')}}">{{trans('all.email_reactivate')}}</button>--}}
            {{--</div>--}}
        {{--@endunless--}}
    {{--</div>--}}

    {{-- PASSWORD --}}
    <div class="form-group{{ $errors->has('password') || isset($userData['new_password'])  ? ' has-error' : '' }}">
        <label class="control-label col-sm-4">{{trans('all.password')}}</label>

        <div class="col-sm-8">
            <button type="button" class="btn button-style2" data-toggle="modal" data-target="#changePsw">
                {{ trans('all.password_to_change') }}
            </button>
        </div>
    </div>

    <div class="form-group">
        {{--<div class="col-xs-12 phone_activation {{ $user->phone == null ? 'visible' : 'hidden' }}">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-4">--}}
                    {{--<input type="text" name="code" id="code_activate_input" class="form-control">--}}
                {{--</div>--}}

                {{--<div class="col-sm-8">--}}
                    {{--<a href="{{route('phone.code')}}" class="btn btn-info btn-prof phone_code_btn">--}}
                        {{--{{trans('all.code_confirm')}}</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-sm-8 col-sm-offset-4">--}}
            {{--@if($user->phoneActivate)--}}
                {{--<button class="btn btn-info btn-prof phone_sms_again">--}}
                    {{--{{trans('all.send_sms_again')}}</button>--}}
            {{--@else--}}
                {{--<a class="btn btn-info phone_activate_btn" href="{{route('phone.activate')}}">--}}
                    {{--{{trans('all.change_phone_number')}}</a>--}}
            {{--@endif--}}
        {{--</div>--}}
    </div>

    {{--@if($user->client)--}}
        {{--<div class="form-group">--}}
            {{--<label class="control-label col-sm-4">Дополнительный номер</label>--}}
            {{--<div class="col-sm-8">--}}
                {{--<input type="tel" name="data[phone2]" id="phone2" class="form-control"--}}
                       {{--value="@if(isset($user->client->data['phone2']) && $user->client->data['phone2']){{$user->client->data['phone2']}}@else+380 @endif">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--@if(isset($user->client->data['phone2']) && $user->client->data['phone2'])--}}
        {{--<div class="form-group" style="">--}}
            {{--<div class="col-sm-8 col-sm-offset-4">--}}
                {{--<button class="btn btn-info btn-prof" id="make_phone_main">Сделать основным</button>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--@endif--}}
    {{--@endif--}}

    @if($user->isLogistic())
        <div class="individual_block company_block profile_type_block" @if(profile_filled() === false) style="display: none;" @endif>
            <div class="form-group">
                <label class="control-label col-sm-4">{{trans('all.logo')}}</label>
                <div class="col-sm-8">
                    <input type="file" name="images[avatar][]" id="LogoUpload" class="inputfile"
                           data-multiple-caption="{count} - {{trans('all.files_selected')}}">
                    <label for="LogoUpload" class="btn btn-sm-create-app-def transition">
                        <span>{{trans('all.upload_file')}}</span>
                    </label>
                </div>
            </div>
            {{--<div class="form-group">--}}
                {{--<label class="control-label col-sm-4">{{trans('all.signature')}}</label>--}}
                {{--<div class="col-sm-8">--}}
                    {{--<input type="file" name="images[signature][]" id="SignatureUpload" class="inputfile"--}}
                           {{--data-multiple-caption="{count} - {{trans('all.files_selected')}}">--}}
                    {{--<label for="SignatureUpload" class="btn btn-sm-create-app-def transition">--}}
                        {{--<span>{{trans('all.upload_file')}}</span>--}}
                    {{--</label>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    @endif

    {{--@if($user->isLogistic())--}}


        <!-- Modal Change Password: BEGIN -->
        <div id="changePsw" class="modal" role="dialog">
            <div class="modal-dialog animated zoomIn">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="h1 title-blue modal-title">
                            {{ trans('all.password_change') }}
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="changePswForm">
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('all.password_old')}}</label>
                            <div class="col-sm-8">
                                <input type="password" name="password_old" class="form-control" placeholder="********">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('all.password')}}</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" placeholder="********">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" style="white-space: normal;">{{trans('all.password_confirm')}}</label>
                            <div class="col-sm-8">
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="********">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                                <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}
                                    <i>×</i>
                                </button>
                                <button type="submit" class="btn button-style1" id="btn_psw_change" value="submit"><span>{{ trans('all.save') }}</span></button>
                    </div>

                </div>
            </div>
        </div>

    {{--@endif--}}

    @push('scripts')
    <script>
        $(function() {

            $('#btn_edit_settings_open').on('click', function (e) {
                e.preventDefault();
                $('.user_info__text').hide();
                $('.user_info__input').show();
                $(this).hide();
                $('#btn_edit_settings_close').show();
            });

            $('#btn_edit_settings_close').on('click', function (e) {
                e.preventDefault();
                $('.user_info__text').show();
                $('.user_info__input').hide();
                $(this).hide();
                $('#btn_edit_settings_open').show();
            });

            $('#btn_edit_credentials_open').on('click', function (e) {
                e.preventDefault();
                $('.user_credentials__text').hide();
                $('.user_credentials__input').show();
                $(this).hide();
                $('#btn_edit_credentials_close').show();
            });

            $('#btn_edit_credentials_close').on('click', function (e) {
                e.preventDefault();
                $('.user_credentials__text').show();
                $('.user_credentials__input').hide();
                $(this).hide();
                $('#btn_edit_credentials_open').show();
            });

            $('#collapseAddressPost').on('show.bs.collapse', function () {
                $('#btn_collapseAddressPost').find('.glyphicon-menu-down').hide();
                $('#btn_collapseAddressPost').find('.glyphicon-menu-up').show();
            });

            $('#collapseAddressPost').on('hide.bs.collapse', function () {
                $('#btn_collapseAddressPost').find('.glyphicon-menu-down').show();
                $('#btn_collapseAddressPost').find('.glyphicon-menu-up').hide();
            });

            $('#btn_psw_change').on('click', function (e) {
                e.preventDefault();

                $('#changePsw').find('.form-group').removeClass('has-error');
                $('#changePsw').find('.form-group').removeClass('shake');
                $('#changePsw').find('.help-block').hide();

                data = {
                    'password_old' : $('#changePsw').find('input[name=password_old]').val(),
                    'password' : $('#changePsw').find('input[name=password]').val(),
                    'password_confirmation' : $('#changePsw').find('input[name=password_confirmation]').val(),
                };

//                console.log(data);

                $.ajax({
                    url: '{{route('password.change')}}',
                    type: "post",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    }})
                    .done( function (data) {
                        if(data.result === true){
                            $('#changePsw').modal('hide');
                            appAlert('', '{{ trans('all.password_changed') }}', 'success');
                        }

                        $('#changePsw').find('input').val('');
                    })
                    .fail(function (res) {

                        if (res.status === 422) {
                            let errors = res.responseJSON;

                            $.each(errors, function (k, i) {
                                let input   = $('[name="' + k + '"]');
                                input.parents('.form-group').addClass('has-error shake');
                                input.next('.help-block').html('<strong>' + i[0] + '</strong>').show();
                            });
                        }
                        else
                            appAlert('', 'Something went wrong... :(', 'warning');
                    });

            });

            <?php //TODO not use
            ?>
            $('#make_phone_main').on('click', function(event){
                event.preventDefault();

                $.ajax({
                    url: '{{route('client.phone.setmain')}}',
                    type: "post",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    }})
                    .done( function (data) {
                        console.log(data);
                        if (data.result === 'ok'){}
                        window.location.href = '{{route('user.setting')}}';
                    })
                    .fail(function (data) {

                    });

                data = {
                    'phone2' : $('#phone2').val(),
                    'phone'  : $('input[name=phone]').val(),
                };

                $.ajax({
                    url: '{{route('client.phone.setmain')}}',
                    type: "post",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    }})
                    .done( function (data) {
                        console.log(data);
                    if (data.result === 'ok'){}
                        window.location.href = '{{route('user.setting')}}';
                    })
                    .fail(function (data) {

                    });

            });


            $('select[name=address_country]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'states','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_region]', result);
            });

            $('select[name=address_region]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'cities','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_city]', result);
            });

            $('select[name=address_legal_country]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'states','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_legal_region]', result);
            });

            $('select[name=address_legal_region]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'cities','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_legal_city]', result);
            });

            $('select[name=address_post_country]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'states','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_post_region]', result);
            });

            $('select[name=address_post_region]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let data, result;
                data = {'type' : 'cities','code'  : $(this).val()};
                result = getGeoData(data);
                appendSelect('select[name=address_post_city]', result);
            });

            function appendSelect(select, data){
                $(select).find('option').remove();
                $.each(data, function(key, value) {
                    $(select)
                        .append($("<option></option>")
                            .attr("value",value.code)
                            .text(value.name));
                });

                $(select).selectpicker('refresh');
            }


            function getGeoData(data){

                let result;

                result =  $.ajax({
                    url: '{{route('dic.geodata')}}',
                    type: "post",
                    data: data,
//                    global: false,
                    async:false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "cache-control": "no-cache, no-store"
                    }}).responseJSON;

                return result;
            }
        });
    </script>
    @endpush
