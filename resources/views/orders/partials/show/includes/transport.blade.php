<div role="tabpanel" class="tab-pane fade animated fadeIn" id="transport">
    <div class="tab-pane__row row">
        @if($order->performer->_transport)
            @php($transport = $order->performer->_transport)
            <div class="col-xs-12">
                <h2 class="h2 title-black">{{ trans('all.transport_info') }}</h2>
            </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ trans('all.transport') }}</label>
                        <div class="box-list-transport">
                            <select class="form-control selectpicker list-transport" data-show-subtext="true" disabled>
                                <option data-subtext="{{ $transport->typeName ?? '' }} ">
                                    ID {{ $transport->id }} - {{ $transport->number }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ trans('all.driver') }}</label>
                        <input class="form-control" name="driver_name" value="{{ $transport->drivers->isNotEmpty() ?$transport->drivers[0]->name : ''}}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="">{{ trans('all.rolling_stock_type') }}</label>
                        <input name="rollingStock" class="form-control" value="{{ $transport->rollingStock ? $transport->rollingStock : ''}}" disabled>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">{{ trans('all.transport_number') }}</label>
                                <input class="form-control" name="number" value="{{ $transport->number }}" disabled>
                            </div>
                            <div class="col-sm-6">
                                <label for="">{{ trans('all.transport_trailer_number') }}</label>
                                <input value="{{ $transport->trailerNumber }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="driver-box">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">{{ trans('all.phone') }}</label>
                                    <input class="form-control" value="{{ $transport->drivers->isNotEmpty() ? $transport->drivers[0]->phone : ''}}" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">{{ trans('all.driver_license') }}</label>
                                    <input class="form-control" value="{{ $transport->drivers->isNotEmpty() ?$transport->drivers[0]->meta_data['driver_licence'] : ''}}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ trans('all.license_driver_photo') }}</label>

                            <div class="upload-block text-center">
                           {{--<!--     @foreach($transport->drivers[0]->picLicense as $image)--}}
                                    {{--<div class="photo animated fadeIn zoom" style="background-image: url({{$image}}); background-size: contain">--}}
                                        {{--<a href="{{ $image }}"></a>--}}
                                    {{--</div>--}}
                                {{--@endforeach -->--}}
                            </div>
                        </div>
                    </div>

                    {{-- Second driver --}}
                    @if($user->hasRole('logistic-company') && key_exists(1, $transport->drivers))
                        <div class="form-group checkbox filter">
                            <input type="checkbox" name="additional_driver" value="1" id="additionalDriver" disabled checked>
                            <label for="additionalDriver">
                                {{ trans('all.second_driver') }} </label>
                        </div>

                        <div class="driver-box additional animated fadeIn">
                            <div class="form-group">
                                <label for="">{{ trans('all.driver') }}</label>
                                <input value="{{ $transport->drivers->isNotEmpty() ? $transport->drivers[1]->name : '' }}" class="form-control" disabled>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">{{ trans('all.phone') }}</label>
                                        <input class="form-control" value="{{ $transport->drivers->isNotEmpty() ?  $transport->drivers[1]->phone : '' }}" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">{{ trans('all.driver_license') }}</label>
                                        {{--<input class="form-control" value="{{ $transport->drivers[1]->meta_data['driver_license'] ?? '' }}" disabled>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">{{ trans('all.license_driver_photo') }}</label>

                                <div class="upload-block text-center">
                                    {{--@foreach($transport->drivers[1]->picLicense as $image)--}}
                                        {{--<div class="photo animated fadeIn zoom" style="background-image: url({{$image}}); background-size: contain">--}}
                                            {{--<a href="{{ $image }}"></a>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            <div class="col-sm-6"></div>
        @else
            @if($transport_partner)
                @include('orders.partials.show.includes.transport-partner')
            @else
                <div class="col-xs-12">
                    <h3 style="color: #a4a4a4">Транспорт не найден...</h3>
                </div>
            @endif
        @endif
    </div>
</div>

@push('scripts')
    <script>
        $('.zoom').click(function () {
            let lightbox = $(this).find('a').simpleLightbox();

            lightbox.open();
        })
    </script>
@endpush

