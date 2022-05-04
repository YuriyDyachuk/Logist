<div role="tabpanel" class="tab-pane fade {{ \Request::get('tab') != 'transport' ?' active in':''   }}" id="info">
    <form id="generalForm">
        {{--<input type="hidden" value="" id="price_partner_general" name="price_partner_general">--}}
        <div class="tab-pane__row row">
            <div class="col-xs-12">
                <h2 class="h2 title-block">{{ trans('all.order_info') }}</h2>
            </div>


            <div class="col-sm-6" style="padding-right: 30px">
                <div class="form-group">
                    <label for="category" class="control-label">{{ trans('all.transport_category') }}</label>
                    <input type="text" name="unloading_date" class="form-control"
                           value="{{ trans('handbook.' . $order->getCategoryName()) }}" disabled>
                </div>

                @if($userIsLogistic)
                <div class="form-group">

                    <label class="control-label"
                           for="client">
                        @if($order_from_partner)
                            {{  trans('all.partner') }}
                        @else
                            {{  trans('all.client') }}
                        @endif
                    </label>
                    <select name="client" id="client" class="form-control selectpicker" data-spec
                            title="{{ trans('all.select_client') }}"
                            disabled>
                        @if($order_from_client || $order_from_partner)
                            <option selected="selected" >{{$order->getPerformer()->creator->name}}</option>
                        @else
                            <option disabled >{{ trans('all.select_client') }}</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @if($client_id==$client->id) selected="selected" @endif>{{ $client->name }}</option>
                            @endforeach
                        @endif

                    </select>

                </div>
                @endif

                @if($order->isEditablePoints())
                    @include('orders.partials.show.includes.edit-points')
                @else
                    <div id="newOrder">
                        <div id="editOrderAddress">
                            <div id="step-1" class="editOrder">
                                <input type="hidden" name="route_polyline" value="">
                                <input type="hidden" name="direction_waypoints" value="{!! $order->direction_waypoints ?? '[]' !!}">
                                <div class="points-container">
                                    <!-- dop info img -->
                                    <div class="dop-img-show"></div>
                                    <!-- end dop info  -->
                        @foreach($order->addresses as $address)
                            <div class="row point-box with-marker-{{ $address->pivot->type }}">
                                <div class="col-xs-4 group">
                                    <label class="control-label"
                                           for="loading_date">{{ trans("all.date_{$address->pivot->type}") }}</label>
                                    <input type="text" name="loading_date" class="datetimepickerTime form-control" value="{{ \Carbon\Carbon::parse($address->orderAddress($order)->first()->date_at)->format('d/m/Y H:i') }}" disabled>
                                </div>
                                <div class="group col-xs-8">
                                    <label class="control-label"
                                           for="">{{ trans("all.{$address->pivot->type}_address") }}</label>
                                    {{-- hidden --}}
                                    <input type="text" class="form-control"
                                           value="{{ $address->address }}"
                                           disabled>
                                </div>
                            </div>
                        @endforeach
                                </div>
                                @if(isset($order->duration))
                                    @php
                                        $finishTime = strtotime($order->addresses->first()->pivot->date_at) + $order->duration;
                                    @endphp
                                    <div class="row">
                                        <div class="col-xs-12 group" style="margin-bottom: 0">
                                            <label class="control-label"
                                                   for="estimated_arrival">{{ trans("all.date_estimated_arrival") }}</label>
                                        </div>
                                    </div>
                                    <div class="row point-box1">
                                        <div class="col-xs-4 group">
                                            <input type="text" name="estimated_arrival" class="datetimepickerTime form-control" value="{{date("d/m/Y H:i", $finishTime)}}" disabled>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

{{--                @if($user->isLogistic())--}}
                @if(false)
                    <div class="form-group checkbox">
                        <input type="checkbox"
                               name="additional_download"
                               value="1"
                               id="additionalLoads"
                                {{ $order->getPerformer()->additional_loading ? ' checked' : '' }}
                                {{ $order->hasStatus('planning')?'':' disabled' }}>
                        <label for="additionalLoads" class="text-inherit">{{ trans('all.additional_loads') }}</label>
                    </div>

                    <div class="form-group additional-loads transition{{ $order->getPerformer()->additional_loading ? '' : ' hidden' }}">
                        @if($order->hasStatus('planning'))
                            <select name="additional_download" id="addDownloadSelect" class="form-control selectpicker">
                                @for ($i = 10; $i < 100; $i+= 10)
                                    <option value="{{ $i }}"{{ $order->getPerformer()->additional_loading == $i ? ' selected' : '' }}>
                                        {{ $i }}%
                                    </option>
                                @endfor
                            </select>
                        @else
                            <input type="text" class="form-control selectpicker"
                                   value="{{ $order->getPerformer()->additional_loading }}" disabled>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-sm-6">
                <label>{{ trans('all.map_route') }}</label>
                @if($order->isEditablePoints())
                <div class="map-container">
                    <div id="map" style="height: 310px"></div>
                </div>
                @else
                    <div id="map" style="height: 350px"></div>
                    @include('includes.map')
                @endif
            </div>

            <div class="col-sm-12"></div>

            <div class="col-sm-6">
                <hr>

                @include('orders.partials.show.includes.cargo')
            </div>
        </div>
        @php
            $edit_cargo = false;
        @endphp
        @if($order->hasStatus('planning') && $order->user_id === auth()->id())
            @php
                $edit_cargo = true;
            @endphp
        @endif
        <div class="row form-group group">
            <div class="col-xs-12 col-sm-6">
                <label class="control-label" for="comment">{{ trans('all.comment') }}</label>
                <textarea id="comment" name="comment" class="form-control" @if(!$edit_cargo) disabled @endif>{{$order->comment}}</textarea>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Restricts input for each element in the set of matched elements to the given inputFilter.
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));

    $(".input_numbers").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    var direction_waypoints   = $.parseJSON(JSON.stringify({!! $order->direction_waypoints ?? '[]' !!}));
</script>
@endpush

@if($order->isEditablePoints() || ($order->isOrderFromClient() && $order->status_id == \App\Enums\OrderStatus::PLANNING) )
    @push('scripts')
    <script>
        var address_details = '{{ url('address/details') }}';
        const addresses     = $.parseJSON(JSON.stringify({!! json_encode($order->addresses) !!}));
        const directions    = $.parseJSON(JSON.stringify({!! json_encode($order->directions) !!}));
        const order         = $.parseJSON(JSON.stringify({!! json_encode($order) !!}));
        const isEditable    = {{ (bool) $order->isEditablePoints()}};

        $( document ).ready(function() {
            mapEditor.RenderOrder(order);
        });
    </script>
    <script src="{{ url('main_layout/js/points_edit.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&libraries=places&language={{app()->getLocale()}}&callback=initMap"
            defer></script>
    @endpush
@else
    @push('scripts')
        <script>
            const isEditable    = false;

        </script>
        {{--<script src="{{ url('main_layout/js/points_edit.js') }}"></script>--}}
    @endpush
@endif

