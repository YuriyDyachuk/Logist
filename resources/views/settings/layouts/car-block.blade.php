@inject('helper', '\App\Helpers\Options')

<form class="form-horizontal" action="{{route('car', ['id' => $car->id])}}" method="POST"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="panel-group accordion-caret" id="accordion">
        <div class="panel{{ $car->verified ? ' panel-default' : ' panel-danger' }}">
            <div class="panel-heading car_toogle accordion-toggle collapsed" data-toggle="collapse"
                 data-target="#collapse{{$car->id}}">
                <h4 class="panel-title">{{trans('all.transport')}} {{ $car->car_number or '' }}</h4>

                @if(!$car->verified)
                    <span> ( {{trans('all.data_not_accepted')}} )</span>
                @endif
            </div>

            <div id="collapse{{$car->id}}" class="panel-collapse collapse">
                <div class="panel-body car_data">
                    <div class="form-group{{ $errors->has('images.car.*') ? ' has-error' : '' }}">
                        <label class="control-label col-sm-6">{{trans('all.transport_photo')}}</label>

                        <div class="col-sm-6 text-right">
                            <input type="file" name="images[car][]" id="imageCar{{$car->id}}"
                                   class="inputfile"
                                   data-multiple-caption="{count} - {{trans('all.files_selected')}}" multiple>
                            <label for="imageCar{{$car->id}}" class="transition">
                                <span>{{trans('all.upload_file')}}</span>
                            </label>
                        </div>

                        @if ($errors->has('images.car.*'))
                            <span class="col-xs-12 help-block small"><strong>{{ $errors->first('images.*') }}</strong></span>
                        @endif

                        <div class="clearfix"></div>
                        @include('includes.image_block', ['image_loop'=>$car->images, 'url' => $helper::carsUrl()])
                    </div>

                    <div class="form-group{{ $errors->has('images.tpCar.*') ? ' has-error' : '' }}">
                        <label class="control-label col-sm-6">{{trans('all.transport_teh_passport_photo')}}</label>

                        <div class="col-sm-6 text-right">
                            <input type="file" name="images[tpCar][]" id="techPass{{$car->id}}" class="inputfile"
                                   data-multiple-caption="{count} - {{trans('all.files_selected')}}" multiple>
                            <label for="techPass{{$car->id}}" class="transition">
                                <span>{{trans('all.upload_file')}}</span>
                            </label>
                        </div>

                        @if ($errors->has('images.tpCar.*'))
                            <span class="col-xs-12 help-block small"><strong>{{ $errors->first('images.*') }}</strong></span>
                        @endif

                        <div class="clearfix"></div>

                        @include('includes.image_block', ['image_loop' => $car->documents()->images, 'url' => $helper::documentUrl()])
                    </div>

                    <div class="form-group{{ $errors->has('images.tpTrailer.*') ? ' has-error' : '' }}">
                        <label class="control-label col-sm-6">{{trans('all.trailer_teh_passport_photo')}}</label>

                        <div class="col-sm-6 text-right">
                            <input type="file" name="images[tpTrailer][]" id="techPassTr{{$car->id}}" class="inputfile"
                                   data-multiple-caption="{count} - {{trans('all.files_selected')}}" multiple>
                            <label for="techPassTr{{$car->id}}" class="transition">
                                <span>{{trans('all.upload_file')}}</span>
                            </label>
                        </div>

                        @if ($errors->has('images.tpTrailer.*'))
                            <span class="col-xs-12 help-block small"><strong>{{ $errors->first('images.*') }}</strong></span>
                        @endif

                        <div class="clearfix"></div>

                        @include('includes.image_block', ['image_loop' => $car->documents('trailer')->images, 'url' => $helper::documentUrl()])
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="license">{{trans('all.driver\'s_license_number')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="license" name="driver_license" class="form-control" value="{{ $car->driver_license }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="carType">{{trans('all.transport_car_type')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="carType" name="type" class="form-control" value="{{ $car->type }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="carModel">{{trans('all.transport_car_model')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="carModel" name="model" class="form-control" value="{{ $car->model }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"
                               for="carNumber">{{trans('all.transport_car_number')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="carNumber" name="car_number" class="form-control" value="{{ $car->car_number }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="trailerNumber">{{trans('all.transport_trailer_number')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="trailerNumber" name="trailer_number" class="form-control" value="{{ $car->trailer_number}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="year">{{trans('all.transport_car_year')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="year" name="year" class="form-control" value="{{ $car->year }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="state">{{trans('all.transport_car_state')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="state" name="state" class="form-control" value="{{ $car->state }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="tonnage">{{trans('all.transport_car_tonnage')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="tonnage" name="tonnage" class="form-control" value="{{ $car->tonnage }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="h-l-w">{{trans('all.transport_car_h_l_w')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="h-l-w" name="h_l_w" class="form-control" value="{{ $car->h_l_w }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4"
                               for="bulk">{{trans('all.transport_car_bulk')}}</label>

                        <div class="col-sm-8">
                            <input type="text" id="bulk" name="bulk" class="form-control" value="{{ $car->bulk }}">
                        </div>
                    </div>
                </div>

                <div class="panel-footer text-right">
                    <input class="btn btn-success" type="submit" value="{{trans('all.save')}}">

                    @if(Auth::user()->hasRole('logistic-company'))
                        <input class="btn btn-danger" data-remove-car="{{$car->id}}" type="button" value="{{trans('all.remove')}}">
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
