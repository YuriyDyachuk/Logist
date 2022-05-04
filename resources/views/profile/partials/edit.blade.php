<!-- Modal Add new client: BEGIN -->
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content transition">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">{{ trans('profile.edit_employee') }}</div>
            </div>

            <form action="{{ route('staff.update', $user['id']) }}" method="PUT" enctype="multipart/form-data" id="formUpdateStaff">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{$user['id']}}">
                <div class="modal-body transition">
                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.full_name') }}</label>
                        <input type="text" class="form-control" name="full_name" value="{{$user['name']}}">
                    </div>
                    <div class="form-group">
                        <label for="clientPhone" class="control-label">{{ trans('all.phone') }}</label>
                        <input type="text" class="form-control phone" name="phone[]" placeholder="" value="{{$user['phone']}}">
                    </div>

                    {{--<a href="javascript://" id="addTwoPhone" class="transition">Добавить еще один номер</a>--}}

                    {{--<div class="form-group hidden">--}}
                        {{--<label for="clientPhone2" class="control-label">{{ trans('all.phone') }}</label>--}}
                        {{--<input type="text" name="phone[]" class="form-control phone-2" id="clientPhone2" placeholder="">--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-7">
                                <label for="" class="control-label">{{ trans('all.passport_number') }}</label>
                                <input type="text" class="form-control" name="passport" placeholder="" value="{{ $user['passport'] }}">
                            </div>
                            <div class="col-sm-5">
                                <label for="" class="control-label">{{ trans('all.birthday') }}</label>
                                <input type="text" class="form-control datetimepicker" name="birthday" placeholder="" value="{{ $user['birthday'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.driver\'s_license_number') }}</label>
                        <input type="text" class="form-control" name="driver_licence" placeholder="" value="{{ $user['driver_licence'] }}">
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.email_address') }}</label>
                        <input type="email" class="form-control" name="email" placeholder="" value="{{$user['email']}}">
                    </div>


                    <div class="form-group">
                        <label for="" class="control-label">{{ trans('all.functional_role') }}</label>
                        <input type="text" class="form-control" name="functional_role" placeholder="" value="{{ $user["functional_role"] }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default transition" data-dismiss="modal">Отмена <i>&times;</i>
                    </button>
                    <button id="submitEmployeeSave" type="button" class="btn button-green xs" >{{ trans('all.save') }}<span class="arrow-right"></span></button>
                </div>
            </form>
        </div>
    </div>
<!-- Modal Add new client: END -->