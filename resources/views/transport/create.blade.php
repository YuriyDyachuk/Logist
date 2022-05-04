@extends('layouts.app')

@section('content')
    <div class="content-box transport-page create">
        <h1 class="title-blue">{{trans('all.vehicle_new')}}</h1>

        <div class="content-box__body">
            <form enctype="multipart/form-data"
                  action="{{ route('transport.store') }}"
                  class="container-fluid"
                  id="newTransport">

                <input type="hidden" name="redirectTo" value="{{ \Request::get('redirectTo') }}">

                <div class="row flex">
                    {{-- LEFT CARD --}}
                    <div class="col-xs-12 col-sm-6 card sub-form-data" data-form="auto">
                        {{-- Type transport --}}
                        <div class="form-group type-transport-box new-transport" id="transport">

                            <input id="truckType" type="radio" name="selected" value="truck" checked>
                            <label for="truckType" class="transition tooltipItem" data-title="{{trans('tooltips.truck_header')}}" data-body="{{trans('tooltips.truck_body')}}"></label>


                            <input id="couplingType" type="radio" name="selected" value="coupling">
                            <label for="couplingType" class="transition tooltipItem" data-title="{{trans('tooltips.coupling_header')}}" data-body="{{trans('tooltips.coupling_body')}}"></label>

                            <input id="roadTrainType" type="radio" name="selected" value="train">
                            <label for="roadTrainType" class="transition tooltipItem" data-title="{{trans('tooltips.roadTrain_header')}}" data-body="{{trans('tooltips.roadTrain_body')}}"></label>
                        </div>

                        {{-- Category transport --}}
                        <div class="form-group">
                            <label for="" class="control-label">{{ trans('all.transport_category') }}</label>
                            <select name="category" id="category" class="form-control selectpicker"
                                    title="Выберите категорию" required>
                                @foreach($categories as $item)
                                    <option value="{{ $item['id'] }}"
                                            selected>{{ trans("handbook.{$item['name']}") }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="form-group hidden">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="" class="control-label">{{ trans('all.status') }}</label>
                                    <select name="status" id="status" class="form-control selectpicker" readonly="">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status['id'] }}"{{ $status['name'] == 'free'
                                                                ? ' selected'
                                                                :''}}>{{ trans('all.'.$status['name']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Condition --}}
                        <div class="form-group hidden">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="control-label"
                                           for="">{{trans('all.transport_condition')}}</label>
                                    <select name="condition" id="" class="form-control selectpicker">
                                        <option value="great" selected>{{ trans('handbook.condition_great') }}</option>
                                        <option value="good">{{ trans('handbook.condition_good') }}</option>
                                        <option value="bad">{{ trans('handbook.condition_bad') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Monitoring && Insurance --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 hidden">
                                    <div class="checkbox input-inside">
                                        <input id="gpsCheck" type="checkbox" name="gps">
                                        <label for="gpsCheck" class="text-inherit"></label>
                                    </div>
                                    <label class="control-label" for="">GPS ID</label>
                                    <input type="text" id="" name="gps_id" class="form-control" disabled>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label" for="">{{trans('all.tracker_imei')}}</label>
                                    <input type="text" name="tracker_imei" class="form-control"/>
                                </div>
                                <div class="col-sm-4 hidden">
                                    {{--<div class="checkbox input-inside">--}}
                                        {{--<input id="insuranceCheck" type="checkbox" name="insurance">--}}
                                        {{--<label for="insuranceCheck" class="text-inherit"></label>--}}
                                    {{--</div>--}}
                                    <label class="control-label" for="">{{trans('all.insurance')}}</label>
                                    <input type="text" name="insurance_id" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        {{-- Credentials --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label" for="" style="line-height: 17.15px;">{{ trans('all.user_login') }}
                                        <i class="info-notification transition">?
                                            <span class="info-notification transition">
                                        <em>Добавьте здесь Google Account для использования приложения для водителей</em>
                                    </span>
                                        </i>
                                    </label>
                                    <input type="text" id=""
                                           name="login"
                                           value="{{ old('login') }}"
                                           class="form-control required">
                                    <small id="error_login" class="text-danger"></small>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label" style="line-height: 17.15px;"
                                           for="">{{trans('all.password')}}</label>
                                    <input type="text" id="password" name="password"
                                           class="form-control required">
                                    <small id="error_password" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT CARD --}}
                    <div class="col-xs-12 col-sm-6 card">
                        {{-- Automobile --}}
                        <div class="card-auto sub-form-data" data-form="auto">
                            <div class="title">
                                <h3 class="title-blue">{{ trans('all.vehicles') }}</h3>
                                <button class="btn btn-sm-create-app-def transition hidden" title="{{ trans('all.add_car_only') }}"
                                        type="button"
                                        data-toggle-form="coupling-train"
                                        create-trans="auto">
                                    {{ trans('all.add_car') }}
                                </button>
                            </div>

                            {{-- hidden --}}
                            @php($index = array_search('truck', array_column($types, 'name')))
                            <input type="hidden" name="auto[type]" value="{{ isset($types[$index]['id']) ? $types[$index]['id'] : 0 }}"/>
                            <input type="radio" id="autoRadio" name="only_selected" value="auto"/>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{trans('all.transport_model')}}</label>
                                        <input type="text" id="" name="auto[model]" class="form-control required"
                                               value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{trans('all.number')}}</label>
                                        <input type="text" id="" name="auto[number]" class="form-control required"
                                               value="">
                                    </div>
                                </div>
                            </div>

                                <div class="hidden sub-form-data" data-form="trailer" data-toggle-form="coupling">
                                    @include('transport.shared.coupling', ['type' => 'auto'])
                                </div>

                            <div class="sub-form-data" data-form="auto" data-toggle-form="truck-train">
                                @include('transport.shared.configuration', ['type' => 'auto'])
                            </div>

                            @include('transport.shared.upload-images', ['type' => 'auto'])
                        </div>

                        {{-- Trailer --}}
                        <div class="card-trailer hidden sub-form-data" data-form="trailer"
                             data-toggle-form="coupling-train">
                            <div class="title">
                                <h3 class="title-blue">{{ trans('all.trailer') }}</h3>
                                <button class="btn btn-sm-create-app-def transition" type="button"
                                        title="{{trans('all.trailer_add_only')}}"
                                        create-trans="trailer">
                                    {{ trans('all.trailer_add') }}
                                </button>
                            </div>

                            {{-- hidden --}}
                            @php($index = array_search('semitrailer', array_column($types, 'name')))
                            <input type="hidden" name="trailer[type]" value="{{ isset($types[$index]['id']) ? $types[$index]['id'] : 0 }}"/>
                            <input type="radio" id="trailerRadio" name="only_selected" value="trailer"/>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{trans('all.transport_model')}}</label>
                                        <input type="text" id="" name="trailer[model]" class="form-control required"
                                               value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{trans('all.number')}}</label>
                                        <input type="text" id="" name="trailer[number]" class="form-control required"
                                               value="">
                                    </div>
                                </div>
                            </div>

                            @include('transport.shared.configuration', ['type' => 'trailer'])

                            @include('transport.shared.upload-images', ['type' => 'trailer'])
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="row">
                    <div class="col-sm-12 footer">
                        <a href="{{ route('transport.index') }}"
                           class="btn button-cancel">{{ trans('all.cancel') }} <i>&times;</i></a>
                        <button type="button"
                                class="btn button-style1"
                                create-trans="all"><span>{{ trans('all.create_transport') }}</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{url('/main_layout/js/transports.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            generate($('#password'), 8);

            createHandbook($('.card-auto [name="auto[type]"]').val(), 'rollingStock-auto');

            //Toggle type transport
            $('[name="selected"]').click(function () {
                var type = $(this).val();

                createHandbook($('.card-trailer [name="trailer[type]"]').val(), 'rollingStock-trailer');
                resetError();
                $('[data-toggle-form]').each(function () {
                                                 var $this = $(this);
                                                 if ($this.attr('data-toggle-form').search(type) !== -1) {
                                                     $this.removeClass('hidden');
                                                 } else {
                                                     $this.addClass('hidden');
                                                 }
                                             }
                );
            });

            $('[type="checkbox"]').click(function () {
                var _name = $(this).attr('name');
                $(`[name="${_name}_id"]`).attr('disabled', !$(this).prop('checked'))
            });

            $('[create-trans]').click(function (e) {
                var form  = $(this)[0].form,
                    $btn  = $(this),
                    type  = $btn.attr('create-trans'),
                    valid = validate(form, type);


                if (type !== 'all') {
                    $('#' + type + 'Radio').prop("checked", true);
                } else {
                    $('[name="only_selected"]').prop("checked", false)
                }

                if (valid) {
                    var formData = new FormData(form);

                    btnLoader($btn);

                    if (formData.get('only_selected') === 'trailer') {
                        formData.delete('login');
                        formData.delete('auto[number]');
                    }
                    if (formData.get('only_selected') === 'auto') {
                        formData.delete('trailer[number]');
                    }

                    $.ajax({
                               url: form.action,
                               data: formData,
                               type: 'POST',
                               processData: false,
                               contentType: false
                           })
                     .done(function (res) {
                          if (res.status === 'OK')
                             window.location.href = res.redirectTo;
                     })
                     .fail(function (res) {
                         if (res.status === 422)
                             showError(res.responseJSON);
                         else if(res.status === 409)
                             appAlert('', res.responseJSON.message, 'warning');
                         else
                             appAlert('', 'Something went wrong... :(', 'warning');
                     })
                     .always(function (res) {
                         btnLoader('hide');
                     });
                }
            });

            function resetError() {
                $('#newTransport').find('.has-error').removeClass('has-error');
            }

            function showError(errors) {
                var msg = '';

                $('.text-danger').hide();
                $('.has-error').removeClass('has-error');

                $.each(errors, function (k, i) {
                    var _name = k;

                    if (k.indexOf('.') !== -1) {
                        _name = k.replace('.', '[') + ']';
                    }

                    var $this   = $('[name="' + _name + '"]'),
                        $parent = $this.is('select') ? $this.parents('.form-group') : $this.parent();

                    $parent.addClass('has-error shake');



                    let keys = k.split('.');

                    if(keys.length > 1){
                        console.log('#error_'+keys[0]+'_'+keys[1]);
                        $('#error_'+keys[0]+'_'+keys[1]).text(i);
                        $('#error_'+keys[0]+'_'+keys[1]).show();
                    }
                    else {
                        $('#error_'+k).text(i);
                        $('#error_'+k).show();
                    }



                    if (/*k === 'login' || (*/k.indexOf('number') !== -1)
                        msg += '<p>' + i + '</p>';
                });

                if (msg !== '')
                    appAlert('', msg, 'warning');

                resetShake();
            }

            function validate(form, type) {
                var valid = true;

                $.each(form.elements, function (k, field) {
                    var $this    = $(this),
                        $parent  = $this.parent(),
                        $subForm = $this.parents('.sub-form-data');

                    if (!$subForm.hasClass('hidden') && ($subForm.attr('data-form') === type || type === 'all') && !$parent.hasClass('hidden')) {
                        if ($this.is('select')) {
                            $parent = $this.parents('.bootstrap-select').parent();
                        } else if ($this.is('input[type="file"]')) {
                            $parent = $this.parents('.image-block');
                        }

                        if ($this.val() === '' && $this.hasClass('required') && $this.parents('.form-group').css('display') !== 'none') {
                            $parent.addClass('has-error shake');
                            valid = false;
                        } else {
                            $parent.removeClass('has-error');
                        }
                    }
                });
                resetShake();

                return valid;
            }

            function resetShake() {
                setTimeout(function () {
                    $('.shake').removeClass('shake')
                }, 1000);
            }
        });
    </script>
@endpush