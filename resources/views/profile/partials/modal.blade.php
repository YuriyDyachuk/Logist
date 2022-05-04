<!-- Modal Add new client: BEGIN -->
<div id="addEmployee" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content transition">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">{{ trans('profile.add_employee') }}</div>
                <div class="label label-status label-success status-on-flight" style="display:none;">{{ trans('all.on_the_road') }}</div>
            </div>

            <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" id="formCreateStaff"
                  name="formCreateStaff">
                {{ csrf_field() }}
                <input type="hidden" value="0" name="id">
                <div class="hidden">
                    <input type="hidden" name="redirectTo" class="hidden" value="{{ \Request::get('redirectTo') }}">
                </div>
                <div class="modal-body transition">
                    {{--<div class="alert alert-danger" id="form_validation_error" role="alert" style="display: none;">В форме есть ошибки заполнения</div>--}}
                    <div class="form-group addon-file">
                        <label for="" class="control-label">{{ trans('all.full_name') }}</label>
                        <input type="text" class="form-control" name="full_name">
                        <small id="error_full_name" class="text-danger"></small>

                        <label for="avatar" class="control-label addon-file-label">{{ trans('all.photo') }}</label>
                        <input id="avatar" type="file" name="images[avatar]" class="skipUpdate">
                        <small id="error_avatar" class="text-danger pull-right" style="margin-top: 3px;"></small>
                    </div>
                    <div class="form-group">
                        <label for="clientPhone" class="control-label">{{ trans('all.phone') }}</label>
                        <input type="text" class="form-control phone" name="phone" placeholder="">
                        <small id="error_phone" class="text-danger"></small>
                    </div>

                    {{--{{var_dump($roles->toArray())}}--}}
                    <div class="form-group error-for-selectpicker" style="display: none;">
                        <label for="functional_role" class="control-label">{{ trans('all.functional_role') }}</label>
                        <select name="functional_role" class="form-control selectpicker" title="{{ trans('all.functional_role') }}">
                            @foreach($roles as $role)
                                @if($role->id == 1)
                                        <option value="{{ $role->id }}"> {{ trans('all.role.' . $role->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                        <small id="error_functional_role" class="text-danger"></small>
                    </div>

                    <div class="form-group error-for-selectpicker position-picker">
                        <label for="position" class="control-label">{{ trans('all.staff_position') }}</label>
                        <select name="position" id="position" class="form-control selectpicker"
                                title="{{ trans('all.select_position') }}">
                            @foreach($roles as $role)
                                @if($role->id == 1)
                                    @foreach($role->children as $child)
                                    <option value="{{ $child->id }}"> {{ $child->name }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" value="1" name="is_admin" id="is_admin" disabled="">
                        <label for="is_admin" class="text-inherit">{{trans('all.admin')}}</label>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-7">
                                <label for="" class="control-label">{{ trans('all.passport_number') }}</label>
                                <input type="text" class="form-control" name="passport" placeholder="">
                                <small id="error_passport" class="text-danger"></small>
                            </div>
                            <div class="col-sm-5">
                                <label for="" class="control-label">{{ trans('all.birthday') }}</label>
                                <input type="text" class="form-control datetimepicker" name="birthday" placeholder="" autocomplete="off">
                                <small id="error_birthday" class="text-danger"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.inn_number') }}</label>
                        <input type="text" class="form-control" name="inn_number" placeholder="">
                        <small id="error_inn_number" class="text-danger"></small>
                    </div>

                    <div class="form-group addon-file license">
                        <label for="" class="control-label">{{ trans('all.driver\'s_license_number') }}</label>
                        <input type="text" class="form-control" name="driver_licence" placeholder="">
                        <small id="error_driver_licence" class="text-danger"></small>

                        <label for="license" class="control-label addon-file-label">{{ trans('all.photo') }}</label>
                        <input id="license" type="file" name="images[license]" class="skipUpdate">
                        <small id="error_license" class="text-danger pull-right"></small>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.email_address') }}</label>
                        <input type="email" class="form-control" name="email" placeholder="">
                        <small id="error_email" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-7 error-for-selectpicker">
                                <label for="" class="control-label">{{ trans('all.payment_type') }}</label>
                                <select id="payment_type" name="payment_type" class="form-control select-payment selectpicker skipUpdate"
                                        title="{{ trans('all.select_type_payment') }}">
                                    @foreach($paymentTypes as $type)
                                        <option value="{{ $type->id }}">{{ trans('handbook.' . $type->name) }}</option>
                                    @endforeach
                                </select>
                                <small id="error_payment_type" class="text-danger"></small>
                            </div>
                            <div class="col-sm-5">
                                <label for="" class="control-label">{{ trans('all.date_start_working') }}</label>
                                <input type="text" name="work_start" class="form-control datetimepicker skipUpdate"
                                       placeholder="" autocomplete="off">
                                <small id="error_work_start" class="text-danger"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="control-label">{{ trans('all.rate') }}</label>
                                <input type="text" class="form-control skipUpdate" name="rate" placeholder="0"
                                       disabled="true">
                                <small id="error_rate" class="text-danger"></small>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="control-label">{{ trans('all.percent') }}</label>
                                <input type="text" class="form-control skipUpdate" name="percent" placeholder="0"
                                       disabled="true">
                                <small id="error_percent" class="text-danger"></small>
                            </div>
                        </div>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="" class="control-label">{{ trans('all.functional_role') }}</label>--}}
{{--                        <input type="text" class="form-control skipUpdate" name="functional_role" placeholder="">--}}
{{--                    </div>--}}


                    <div class="form-group panel-transport field-password">
                        <label for="">{{ trans('all.password') }}</label>
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-6">
                                <i class="fa fa-refresh pass-refresh" style="top: 6px;" onclick="refreshPass($(this))"
                                   title="Сгенерировать пароль"></i>
                                <input class="form-control "
                                       name="password"
                                       value="">
                                <small id="error_password" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}
                        <span>&times;</span>
                    </button>
                    <button id="submitEmployee" type="button" class="btn button-style1"
                            data-add="{{ trans('all.add') }}" data-edit="{{ trans('all.save') }}">{{ trans('all.add') }}
                        <span class="arrow-right"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add new client: END -->
@push('scripts')
    <script>
        var positions = $.parseJSON(JSON.stringify({!! json_encode($roles) !!}));
    </script>
@endpush