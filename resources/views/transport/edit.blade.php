@extends("layouts.app")

@section("content")
    <div class="content-box transport-page edit">
        <h1 class="title-blue" style="margin-bottom: 26px">{{ trans('all.vehicle_edit') }} - <?php echo $transport->isTrailer ? trans('all.trailer') : trans('all.vehicles') ?> </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="content-box__body">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('transport.update', $transport->id) }}"
                  class="container-fluid"
                  id="newTransport">

                {{-- Hidden --}}
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <input type="hidden" name="order" value="{{ \Request::get('order', 0) }}">
                <input type="hidden" name="only_selected" value="{{ $transport->isTrailer ? 'trailer' : 'auto' }}">
                <div class="row">
                    <div class="col-sm-6">
                        {{-- Category --}}
                        <div class="form-group ">
                            <label for=""
                                   class="control-label">{{ trans('all.transport_category') }}</label>
                            <input type="text" name="category" class="form-control"
                                   value="{{ trans('handbook.'.$transport->category) }}" readonly>
                        </div>

                        {{-- Type --}}
                        <div class="form-group">
                            <label for="" class="control-label">{{ trans('all.transport_type') }}</label>

                            <input type="text" name="type" class="form-control"
                                   value="{{ trans('handbook.'.$transport->type) }}" readonly>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    {{-- Rolling Stock --}}
                                    @if($transport->rollingStock)
                                        <div class="form-group">
                                            <label for="" class="control-label">{{ trans('all.rolling_stock_type') }}</label>
                                            <input type="text" class="form-control"
                                                   value="{{  trans('handbook.'.$transport->rollingStock) }}" readonly/>
                                        </div>
                                    @else
                                        <div class="">
                                            <label class="control-label">{{ trans('all.rolling_stock_type') }}</label>
                                            <select name="cargo_rolling_stock_types" class="form-control selectpicker required"
                                                    title="{{ trans('all.select_type') }}..">
                                                @foreach($cargo_rolling_stock_types as $type)
                                                    <option value="{{ $type->id }}">{{ trans('handbook.'.$type->name )}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">{{ trans('all.loading_type') }}</label>
                                    <select name="type_loading" class="form-control selectpicker required"
                                            title="{{ trans('all.select_type') }}..">
                                        <option value="1">{{trans('cargo.upper')}}</option>
                                        <option value="2">{{trans('cargo.lateral')}}</option>
                                        <option value="3">{{trans('cargo.rear')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Specifications --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label">{{trans('all.transport_number')}}</label>
                                    <input type="text" id="" name="number" class="form-control"
                                           value="{{ old('number', $transport->number) }}"
                                           readonly
                                           required
                                           data-value-missing="This field is required!">
                                </div>

                                <div class="col-sm-6">
                                    <label class="control-label">{{trans('all.transport_model')}}</label>
                                    <input type="text" id="" name="model" class="form-control"
                                           value="{{ old('model', $transport->model) }}" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label">{{trans('all.transport_year')}}</label>
                                    <input type="text" id="" name="year" class="form-control number"
                                           maxlength="4"
                                           value="{{ old('year', $transport->year) }}" @if($transport->year) readonly @endif required>
                                </div>

                                <div class="col-sm-6">
                                    <label class="control-label">{{trans('all.transport_condition')}}</label>
                                    <select name="condition" id="" class="form-control selectpicker">
                                        <option value="great"{{ $transport->condition == 'great' ? ' selected': ''}}>
                                            {{ trans('handbook.condition_great') }}
                                        </option>
                                        <option value="good"{{ $transport->condition == 'good' ? ' selected': ''}}>
                                            {{ trans('handbook.condition_good') }}
                                        </option>
                                        <option value="bad"{{ $transport->condition == 'bad' ? ' selected': ''}}>
                                            {{ trans('handbook.condition_bad') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if(!$transport->isTrailer)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="" class="control-label">{{ trans('all.driver') }}</label>
                                        <select name="driver" id="driver" class="form-control selectpicker"
                                                title="{{ trans('all.driver_not_installed') }}">
                                            @if(!$transport->hasStatus('on_flight'))
                                                <option value="0">{{ trans('all.driver_not_installed') }}</option>
                                            @endif
                                            @empty(!$transport->driver))
                                            <option value="{{ $transport->driver->id }}"
                                                    selected>{{ $transport->driver->name }}</option>
                                            @endempty

                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver['user_id'] }}">{{ $driver['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">{{trans('all.transport_tachograph')}}</label>
                                        <input type="text" id="" name="tachograph" class="form-control"
                                               value="{{ old('tachograph', $transport->tachograph) }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="row">
                                @if(!$transport->isTrailer)
                                    <div class="col-sm-6">
                                        <label for="" class="control-label">{{ trans('all.status') }}</label>
                                        <select name="status" id="status" class="form-control selectpicker"
                                                {{ (!$transport->verified || $transport->hasStatus('on_flight')) ? 'disabled' : '' }}
                                        >
                                            @if(!$transport->verified)
                                                <option value="{{ $transport->status_id }}"
                                                        selected>{{ trans('all.inactive') }}</option>
                                            @elseif($transport->hasStatus('on_flight'))
                                                <option value="{{ $transport->status_id }}" readonly
                                                        selected>{{ trans('all.on_the_road') }}</option>
                                            @else
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}"
                                                            {{ $transport->status_id === $status->id ? ' selected':''}}>
                                                        {{ trans('all.'.$status->name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($transport->hasStatus('on_flight'))
                                            <input type="hidden" name="status" value="{{ $transport->status_id }}">
                                        @endif
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="" class="control-label">{{ trans('all.trailer_add') }}</label>
                                        <select name="trailer" id="trailer" class="form-control selectpicker"
                                                title="{{ trans('all.trailer_not_attach') }}" @if($transport->hasStatus('on_flight')) disabled @endif>
                                            @if(!$transport->hasStatus('on_flight'))
                                                <option value="reset">{{ trans('all.trailer_not_attach') }}</option>
                                            @endif

                                            @forelse($transport->trailers as $trailer)
                                                @if($trailer->parent_id == null)
                                                    <option value="{{ $trailer->id }}">{{ $trailer->model . ' (' . $trailer->number . ')'}}</option>
                                                @elseif($trailer->parent_id == $transport->id)
                                                    <option value="{{ $trailer->id }}"
                                                            selected>{{ $trailer->model . ' (' . $trailer->number . ')'}}</option>
                                                @endif
                                            @empty
                                                <option disabled>Нет свободных прицепов</option>
                                            @endforelse
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="status" value="{{ $transport->status_id }}">
                                    <div class="col-sm-12">
                                        <label for="" class="control-label">Привязать к ТС</label>
                                        <select name="truck" id="truck" class="form-control selectpicker"
                                                title="ТС не установлено">
                                            <option value="reset">ТС не установленo</option>
                                            @foreach($transport->trucks as $truck)
                                                <option value="{{ $truck->id }}"
                                                        {{ $transport->parent_id == $truck->id ? ' selected' : '' }}>{{ $truck->number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(/*$transport->type != 'tractor'*/ !is_null($transport->rolling_stock_type_id))

                            {{-- if not coupling --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label"
                                               for="">{{trans('all.transport_tonnage')}}</label>
                                        <input type="text" id="" name="tonnage" class="form-control number"
                                               value="{{ old('tonnage', $transport->tonnage) }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{trans('all.transport_volume')}}
                                            ({{ trans('all.m') }}3)</label>
                                        <input type="text" id="" name="volume" class="form-control number"
                                               value="{{ old('volume', $transport->volume) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="">{{trans('all.transport_length')}}
                                            ({{ trans('all.cm') }})</label>
                                        <input type="text" id="" name="length" class="form-control number"
                                               value="{{ old('length', $transport->length) }}" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label" for="">{{trans('all.transport_width')}}
                                            ({{ trans('all.cm') }})</label>
                                        <input type="text" id="" name="width" class="form-control number"
                                               value="{{ old('width', $transport->width) }}" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label" for="">{{trans('all.transport_height')}}
                                            ({{ trans('all.cm') }})</label>
                                        <input type="text" id="" name="height" class="form-control number"
                                               value="{{ old('height', $transport->height) }}" required>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @unless($transport->isTrailer())
                            {{-- Monitoring && Insurance --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="checkbox input-inside">
                                            <input id="gpsCheck" type="checkbox"
                                                   name="gps" {{ $transport->monitoring == 'gps' ?' checked' : '' }}>
                                            <label for="gpsCheck" class="text-inherit"></label>
                                        </div>
                                        <label class="control-label" for="">GPS ID</label>
                                        <input type="text" id="" name="gps_id"
                                               class="form-control"
                                               value="{{ $transport->gps_id }}"
                                                {{ $transport->monitoring == 'app' ?' readonly' : '' }}>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label" for="">{{trans('all.tracker_imei')}}</label>
                                        <input type="text" name="tracker_imei" class="form-control"
                                               value="{{ $transport->tracker_imei }}"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label" for="">{{trans('all.insurance')}}</label>
                                        <input type="text" name="insurance_id" class="form-control"
                                               value="{{ $transport->insurance }}"/>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group" data-account>--}}
                            {{--<div class="row">--}}
                            {{--<div class="col-xs-12">--}}
                            {{--<label for="car_registration">{{trans('all.monitoring_system')}}</label>--}}
                            {{--<div class="radio">--}}
                            {{--<input type="radio" id="carreg2" name="monitoring"--}}
                            {{--value="app"--}}
                            {{--{{ $transport->monitoring == 'app' ?' checked':''}}>--}}
                            {{--<label for="carreg2">APP</label>--}}

                            {{--<input type="radio" id="carreg1" name="monitoring"--}}
                            {{--value="gps"{{ $transport->monitoring == 'gps'?' checked':''}}>--}}
                            {{--<label for="carreg1">GPS</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group" data-account>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">{{ trans('all.user_login') }}</label>
                                        <input type="text" id="" name="login" class="form-control"
                                               value="{{ old('login', $transport->login) }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label"
                                               for="">{{trans('all.password')}}</label>
                                        <input type="text" id="password" name="password"
                                               class="form-control"
                                               value="{{ old('password', $transport->password) }}" required>
                                    </div>
                                </div>
                            </div>
                        @endunless
                    </div>

                    {{-- IMAGES BLOCK --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 image-block">
                                    <label class="control-label"
                                           for="">{{trans('all.transport_photo')}}</label>

                                    <div class="upload-block text-center">
                                        @forelse ($transport->images as $image)
                                            <div class="photo"
                                                 style="background-size:cover; background-image: url({{ \Image::getPath('transports', $image->filename) }}">
                                                <input type="hidden" id="trans-{{ $loop->index }}" name=""
                                                       class="form-control photo-upload">
                                                <span id="{{$image->id}}" class="delete-img delete-save img"></span>
                                            </div>
                                            @if ($loop->last)
                                                <div class="photo hidden">
                                                    <input type="file" id="trans-{{ $loop->index + 1 }}"
                                                           name="images[transport][]"
                                                           class="form-control photo-upload">
                                                    <span class="delete-img delete-save-img"></span>
                                                </div>
                                                <label for="trans-{{ $loop->index + 1 }}"
                                                       class="label-upload">{{ trans('all.upload_file') }}</label>
                                            @endif
                                        @empty
                                            <div class="photo"
                                                 style="background-image: url({{ url('/img/icon/car.png') }}">
                                                <input type="file" id="trans-0" name="images[transport][]"
                                                       class="form-control photo-upload" required>
                                            </div>
                                            <label for="trans-0"
                                                   class="label-upload">{{ trans('all.upload_file') }}</label>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-sm-6 image-block">
                                    <label class="control-label"
                                           for="">{{trans('all.transport_teh_passport_photo')}}</label>

                                    <div class="upload-block text-center">
                                        @forelse ($transport->getPassport() as $image)
                                            <div class="photo"
                                                 style="background-size:cover; background-image: url({{ \Image::getPath('documents', $image->filename) }}">
                                                <input type="hidden" id="doc-{{ $loop->index }}" name=""
                                                       class="form-control photo-upload">
                                                <span id="{{$image->id}}" class="delete-img delete-save doc"></span>

                                            </div>
                                            @if ($loop->last)
                                                <div class="photo hidden">
                                                    <input type="file" id="doc-{{ $loop->index + 1 }}"
                                                           name="images[documents][]"
                                                           class="form-control photo-upload">
                                                </div>
                                                <label for="doc-{{ $loop->index + 1 }}"
                                                       class="label-upload control-label">{{ trans('all.upload_file') }}</label>
                                            @endif
                                        @empty
                                            <div class="photo"
                                                 style="background-image: url({{ url('/img/icon/lines-file.png') }}">
                                                <input type="file" id="doc-0" name="images[documents][]"
                                                       class="form-control photo-upload" required>
                                            </div>

                                            <label for="doc-0"
                                                   class="label-upload">{{ trans('all.upload_file') }}</label>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="row">
                    <div class="col-sm-6 footer">
                        @if(\Request::has('order'))
                            <a href="{{ route('orders.show', ['id' => \Request::get('order'), 'tab' => 'transport']) }}"
                               class="btn button-cancel">{{ trans('all.cancel') }} <i>&times;</i></a>
                        @else
                            <a href="{{ route('transport.index') }}"
                               class="btn button-cancel">{{ trans('all.cancel') }} <i>&times;</i></a>
                        @endif
                        <button id="submit" type="submit"
                                class="btn button-style1">{{ trans('all.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{url('/main_layout/js/transports.js')}}"></script>

    <script type="text/javascript">
        $('#driver').change(function () {
            generate($('#password'), 8);
        });

        $('[type="checkbox"]').click(function () {
            var _name = $(this).attr('name');
            $(`[name="${_name}_id"]`).attr('readonly', !$(this).prop('checked'))
        });

        $('#submit').click(function (e) {
            var form  = $(this)[0].form,
                valid = validate(form),
                $btn  = $(this);

            if (valid) {
                btnLoader($btn);
                if (+form.order.value > 0) {
                    $(form).submit();
                } else {
                    e.preventDefault();
                    $.ajax({
                               url        : form.action,
//                               data       : $(form).serializeArray(),
                               data       : new FormData(form),
                               type       : 'post',
                               processData: false,
                               contentType: false
                           })
                     .done(function (res) {
                         if (res.status === 'success')
                             window.location.href = res.redirectTo
                     })
                     .fail(function (res) {
                         if (res.status === 422)
                             showError(res.responseJSON);
                         else
                             appAlert('', 'Something went wrong... :(', 'warning');
                     })
                     .always(function (res) {
                         btnLoader('hide');
                     });
                }
            }
        });

        function showError(errors) {
            var msg = '';

            $.each(errors, function (k, i) {
                var $this   = $('[name="' + k + '"]'),
                    $parent = $this.is('select') ? $this.parents('.form-group') : $this.parent();

                $parent.addClass('has-error shake');

                if (k === 'login' || k === 'number')
                    msg += '<p>' + i + '</p>';
            });

            if (msg !== '')
                appAlert('', msg, 'warning');

            resetShake();
        }

        function validate(form) {
            var valid = true;

            $.each(form.elements, function (k, field) {
                var $this   = $(this),
                    $parent = $this.parent();

                if ($this.is('select')) {
                    $parent = $this.parents('.form-group')
                } else if ($this.is('input[type="file"]')) {
                    $parent = $this.parents('.image-block')
                }

                if ($this.val() === '' && $this.attr('required') && $this.parents('.form-group').css('display') !== 'none') {
                    $parent.addClass('has-error shake');
                    valid = false;
                } else {
                    $parent.removeClass('has-error');
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
    </script>
@endpush