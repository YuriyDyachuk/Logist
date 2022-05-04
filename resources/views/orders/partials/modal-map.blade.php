<!-- Modal -->
<div class="modal fade" id="searchPlace" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title title-blue">{{ trans('all.address_add') }}</h2>
            </div>

            <div class="modal-body" style="padding: 0 15px">
                <div id="map" style="height: 400px"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="button" id="createAddress" class="btn button-green xs"
                        disabled><span>{{ trans('all.create') }}</span></button>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        var marker, place, map, currentForm, geocoder;
        var btnCreate = document.getElementById('createAddress');
        var modal     = jQuery('#searchPlace');
        var center    = getDefaultCenter();

        function initMap() {
            geocoder = new google.maps.Geocoder;

            map = new google.maps.Map(document.getElementById('map'), {
                disableDoubleClickZoom: true,
                mapTypeControl: false,
                gestureHandling: 'cooperative'
            });
            marker = new google.maps.Marker({
                                                map: map,
                                                anchorPoint: new google.maps.Point(0, -29)
                                            });

            marker.setIcon(/** @type {google.maps.Icon} */({
                url: '/main_layout/images/icons/locating.png',
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));

            google.maps.event.addListener(map, 'dblclick', function (event) {
                addMarker(event.latLng);
            });

            btnCreate.addEventListener('click', function (event) {
                fillDataAddress();
            });

            var acInputs = document.getElementsByClassName("address");

            for (var i = 0; i < acInputs.length; i++) {
                initAutocomplete(acInputs[i]);
            }
        }

        function initAutocomplete(input) {
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.inputId = input.id;
            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', function () {
                marker.setVisible(false);
                place       = this.getPlace();
                currentForm = $('#' + this.inputId).parent();

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                    center = place.geometry.location;
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(4);
                }
                fillDataAddress();
            });
        }

        // Adds a marker to the map.
        function addMarker(location) {
            if (location) {
                marker.setPosition(location);

                geocoder.geocode({'location': location}, function (results, status) {
                    if (status === 'OK') {
                        if (results[1]) {
                            place = results[1];
                            modal.find('.search-input').val(place.formatted_address);
                            btnCreate.removeAttribute('disabled');
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }
        }

        function fillDataAddress() {
            console.log(place);
            if (place) {
                currentForm
                    .find('.address')
                    .val(place.formatted_address)
                    .end()
                    .find('.lng')
                    .val(place.geometry.location.lng())
                    .end()
                    .find('.lat')
                    .val(place.geometry.location.lat());

                modal.modal('hide');
            }
        }

        function getDefaultCenter() {
            return {lat: 48.411083, lng: 34.987417};
        }

        /* Modal's events */
        modal.on('shown.bs.modal', function (event) {
            currentForm = $(event.relatedTarget).parent();
            var lat     = parseInt(currentForm.find('.lat').val()) || null;
            var lng     = parseInt(currentForm.find('.lng').val()) || null;
            var title   = currentForm.find('.control-label').text();

            if (lat && lng) {
                center = {lat: lat, lng: lng};
                marker.setPosition(center);
            }

            $(this).find('.modal-title').text(title);

            google.maps.event.trigger(map, "resize");
            marker.setVisible(true);
            map.setCenter(center);
            map.setZoom(5);
        });

        modal.on('hide.bs.modal', function () {
            center = getDefaultCenter();
            marker.setVisible(false);
        });

        $('.mask-number').mask('000000000');

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&libraries=places&callback=initMap"></script>
@endpush