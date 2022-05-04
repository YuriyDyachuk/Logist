<div id="map" style="height: 400px">

</div>

@push('scripts')
<script>
    var latLngs = $.parseJSON(JSON.stringify({!! $locations !!}));
    var markers = [];
    var directionsDisplay, directionsService;
    var all_latLngs = false;
    var geo = [];
    var map;
    var bounds;

    function initMap() {

        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: {lat: 48.411083, lng: 34.987417},
            disableDoubleClickZoom: true,
            mapTypeControl: false,
            gestureHandling: 'cooperative'
        });


        var styledMapType = new google.maps.StyledMapType(
                [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#616161"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#ffeb3b"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#aad5ff"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#bdbdbd"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#757575"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e5e5e5"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#757575"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#dadada"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#616161"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.line",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e5e5e5"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#c9c9c9"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    }
                ]
        );


        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');

        latLngs.forEach(function (el) {
            if (el.lng == 0 && el.lat == 0) return;

            var point = new google.maps.LatLng(el);

            var marker = new google.maps.Marker({
                map: map,
                position: point
            });


            contentString = '' +
                    '<div>' +
                    '<div>{{trans('all.location')}} : '+el.lat+', '+el.lng+'</div>' +
                    '<div>'+el.speed+' {{trans('all.km_h')}}</div>' +
                    '<div>{{trans('all.driver')}} : '+el.driver_name+' </div>' +
                    '<div>{{trans('all.status')}} : '+el.status+' </div>' +
                    '<div>{{trans('all.order')}} : '+el.order_id+' </div>' +
                    '<div>{{trans('all.transport_number')}} : '+el.transport_number+' </div>' +
                    '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.setIcon(/** @type {google.maps.Icon} */({
                //url: '/main_layout/images/icons/locating.png',
                url: '/main_layout/images/icons/van.png',
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            markers.push(marker);
        });

        if (markers.length > 0) {
            bounds = new google.maps.LatLngBounds();

            for (var i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
            }
            map.fitBounds(bounds);
        }

        directionsDisplay.setMap(map);
        markers.setMap(map);
        directionsDisplay.setOptions({suppressMarkers: true});

    }

    function clear_map(){
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);

        }
        markers = [];
        marker = null;
        bounds = null;
    }

    function calcRoute() {
        var waypts = [],
                length = latLngs.length,
                start  = latLngs[0],
                end    = latLngs[length-1];

        for (var i = 0; i < length; i++) {
            if (i > 0 && (i < length - 1) && length > 2 ) {
                waypts.push({
                    location: latLngs[i],
                    stopover: true
                });
            }
        }
        console.log('start', start, 'end', end, 'waypts', waypts);
        var request = {
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function (result, status) {
            if (status == 'OK') {
                directionsDisplay.setDirections(result);
            }
        });
    }


    function print_geo(geo) {
        geo.forEach(function (el) {
            if (el.lng == 0 && el.lat == 0) return;

            var point = new google.maps.LatLng(el);

            var marker = new google.maps.Marker({
                map: map,
                position: point
            });

            contentString = '' +
                    '<div>' +
                    '<div>{{trans('all.location')}} : '+el['lat']+', '+el['lng']+'</div>' +
                    '<div>'+el['speed']+' {{trans('all.km_h')}}</div>' +
                    '<div>'+el['created_at']+'</div>' +
                    '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.setIcon(/** @type {google.maps.Icon} */({
                url: '/main_layout/images/icons/locating.png',
                size: new google.maps.Size(25, 25),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 0),
                scaledSize: new google.maps.Size(25, 25)
            }));

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            markers.push(marker);
        });

        directionsDisplay.setMap(map);
        directionsDisplay.setOptions({suppressMarkers: true});
    }

    $(document).ready(function() {
        $(".draw_route_map").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('url');
            var data = {};
            $.ajax({
                url: url,
                type: 'GET',
                data : data,
                success: function (output) {
                    console.log(output);
                    if(!all_latLngs)
                        all_latLngs = latLngs;

                    clear_map();
                    latLngs = output['locations'];
                    geo = output['geo'];
                    calcRoute();
                    print_geo(geo);

                    var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                    console.log(markerCluster);
                },
            });
        });
    });
</script>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&libraries=places&callback=initMap"></script>
@endpush