{{--<div id="map" style="height: 350px"></div>--}}
@if(isset($order))
    @php
        $transport = $order->transports->first();
    @endphp

@endif
@push('scripts')
    <script>
        const addresses = $.parseJSON(JSON.stringify({!! json_encode($order->addresses) !!}));
        const directions = $.parseJSON(JSON.stringify({!! json_encode($order->directions) !!}));
        const directions_history = $.parseJSON({!! $order->directions_history ? json_encode($order->directions_history) : '"[]"' !!});
        const geo = $.parseJSON(JSON.stringify({!! json_encode($order->geo) !!}));
        let markers = [];
        let directionsDisplay, directionsService;
        var map;
        var infoWindows = [];

        function initMap() {
            directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay_fact = new google.maps.DirectionsRenderer();

            let bounds = new google.maps.LatLngBounds();

            map = new google.maps.Map(document.getElementById('map'), {
                disableDoubleClickZoom: true,
                mapTypeControl: false,
                gestureHandling: 'cooperative'
            });

            addresses.forEach(function (address, k) {
                let size = (k === 0) || (k === (addresses.length - 1)) ? {w: 26, h: 26} : {w: 20, h: 20},
                    color = (address.pivot.type === 'loading') ? 'blue' : 'green',
                    marker = new google.maps.Marker(
                        {
                            map: map,
                            position: {lng: +address.lng, lat: +address.lat}
                        }
                    );

                marker.setIcon(({
                    url: `/main_layout/images/svg/pin-${color}.svg`,
                    scaledSize: new google.maps.Size(size.w, size.h)
                }));

                markers.push(marker);
            });

            if (markers.length > 0) {
//                let bounds = new google.maps.LatLngBounds();

                for (let i = 0; i < markers.length; i++) {
                    bounds.extend(markers[i].getPosition());
                }
            }

            directionsDisplay.setMap(map);
            directionsDisplay.setOptions({suppressMarkers: true});

            directionsDisplay_fact.setMap(map);
            directionsDisplay_fact.setOptions({suppressMarkers: true});

            let path = directions.map(function (item) {
                bounds.extend(new google.maps.LatLng(+item[0], +item[1]));
                return {lat: +item[0], lng: item[1]}
            });


            if (directions_history.length > 0) {
                let path_history = directions_history.map(function (item) {
                    bounds.extend(new google.maps.LatLng(+item[0], +item[1]));
                    return {lat: +item[0], lng: item[1]}
                });
                polyline_history = new google.maps.Polyline(
                    {
                        path: path_history,
                        strokeColor  : '#a12a22',
                        strokeOpacity: 0.8,
                        strokeWeight : 3
                    }
                );
                polyline_history.setMap(map);
            }

//            let path_fact = geo.map(function (item) {
//                bounds.extend(new google.maps.LatLng(+item.lat, +item.lng));
//                return {lat: +item.lat, lng: item.lng}
//            });

            let path_fact = geo.reduce(function(result, item) {
                if(item.status_id === 1) { // with cargo
                    bounds.extend(new google.maps.LatLng(+item.lat, +item.lng));
                    result.push( {lat: +item.lat, lng: item.lng} );
                }
                return result;
            }, []);

            let path_before = geo.reduce(function(result, item) {
                if(item.status_id === null) { // without cargo
                    bounds.extend(new google.maps.LatLng(+item.lat, +item.lng));
                    result.push( {lat: +item.lat, lng: item.lng} );
                }
                return result;
            }, []);

            let polyline = new google.maps.Polyline(
                {
                    path: path,
                    strokeColor: '#007cff',
                    strokeOpacity: 0.8,
                    strokeWeight: 4
                }
            );
            polyline.setMap(map);

            polyline_fact = new google.maps.Polyline(
                {
                    path: path_fact,
                    strokeColor  : '#2ecc71',
                    strokeOpacity: 0.8,
                    strokeWeight : 5
                }
            );
            polyline_fact.setMap(map);


            var lineSymbol = {
                path: 'M 0,-1 0,1',
                strokeOpacity: 1,
                scale: 4
            };
//
            polyline_before = new google.maps.Polyline(
                {
                    path: path_before,
                    geodesic     : true,
                    strokeColor  : '#2ecc71',
                    strokeOpacity: 0,
                    icons: [{
                        icon: lineSymbol,
                        offset: '0',
                        repeat: '20px'
                    }]
                }
            );
            polyline_before.setMap(map);

            map.fitBounds(bounds);
        }
    </script>
    @if(isset($order))
        @if($order->hasStatus('active')&& $transport)
            <script>
                function setActiveMarker(el) {
                    if (el.lng === 0 && el.lat === 0)
                        return;

                    var latlng = {lat: el.lat, lng: el.lng};
                    var point = new google.maps.LatLng(latlng);
                    var marker = new google.maps.Marker({map: map, position: point});
                    // console.log('element:');
                    // console.log(el);
                    let html = `
                        <div id="info-${el.id}" class="info-map-window">
                            <div class="title">ID ${el.id}</div>
                            <div><i class="fa fa-truck"></i>${el.name}</div>
                            <div><span class="speed-meter"></span>${el.speed} {{trans('all.km_h')}}</div>
                            <div><i class="fa fa-user"></i>${el.driver || '-'}</div>
                            <div><i class="cargo-icon"></i>${el.order ? '#' + el.order + ' - ' + el.cargo : '-'}</div>
                        </div>`;
                    let infowindow = new google.maps.InfoWindow({content: html});

                    infowindow.transportId = el.id;
                    infoWindows.push(infowindow);

                    let iconName = getIcon(el);

                    marker.setIcon(({
                        url: '/main_layout/images/svg/' + iconName,
                        scaledSize: new google.maps.Size(36, 36)
                    }));

                    //Event click
                    marker.addListener('click', function () {
                        if (directionsDisplay)
                            directionsDisplay.setMap(null);
                        displayRoute = true;
                        closeAllInfoWindows();
                        infowindow.open(map, marker);
                    });

                    google.maps.event.addListener(infowindow, 'closeclick', function () {
                        displayRoute = false;
                        closeAllInfoWindows();
                    });

                    marker.transportId = el.id;
                    markers.push(marker);
                }

                function getIcon(el) {
                    let icon = 'truck-marker.svg';

                    if (el.transport_status == 'on_flight')
                        icon = 'truck-marker-active.svg';

                    if (el.transport_status === 'on_repair')
                        icon = 'truck-repair.svg';

//                    if (el.speed > 0)
//                        icon = 'truck-marker-active.svg';
//                    if (!el.ignition)
//                        icon = 'truck-marker-no-active.svg';

                    return icon;
                }

                function closeAllInfoWindows() {
                    for (let i = 0; i < infoWindows.length; i++) {
                        infoWindows[i].close();
                    }
                }


                var Transport = $.parseJSON(JSON.stringify({!! $transport->latestGeo()!!}));
                Transport.name = '{!! $transport->model !!} {!! $transport->number !!}';
                Transport.driver = '{!! $transport->drivers->first() ? $transport->drivers->first()->name : '' !!}';
                Transport.cargo = '{!! $order->cargo->name !!}';
                Transport.order = '{!! $order->id !!}';
                Transport.transport_status = '{!! $transport->status->name !!}';
                Transport.id = '{!! $transport->id !!}';


                $(document).ready(function () {
                    setActiveMarker(Transport);
                });

            </script>
        @endif
    @endif
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&callback=initMap">
    </script>
@endpush()