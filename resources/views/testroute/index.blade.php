
@extends("layouts.app")

@section("content")
        <script>
        const addresses = $.parseJSON(JSON.stringify([{"id":333,"place_id":"EkdVcmFsJ3Mna2EgU3QsIDEsIE9yZHpob25pa2lkemUsIERuaXByb3BldHJvdnMna2Egb2JsYXN0LCBVa3JhaW5lLCA1MzMwMCIwEi4KFAoSCWHFGpT1W9tAESXrCH0IXLnZEAEqFAoSCecZRpQOXNtAEcz-Vb1-wMI1","address":"\u0423\u0440\u0430\u043b\u044c\u0441\u044c\u043a\u0430 \u0432\u0443\u043b\u0438\u0446\u044f, 1, \u041f\u043e\u043a\u0440\u043e\u0432, \u0414\u043d\u0456\u043f\u0440\u043e\u043f\u0435\u0442\u0440\u043e\u0432\u0441\u044c\u043a\u0430 \u043e\u0431\u043b\u0430\u0441\u0442\u044c, \u0423\u043a\u0440\u0430\u0438\u043d\u0430, 53300","name":"\u041f\u043e\u043a\u0440\u043e\u0432, \u0423\u0440\u0430\u043b\u044c\u0441\u044c\u043a\u0430 \u0432\u0443\u043b\u0438\u0446\u044f, 1","house":"1","street":"\u0423\u0440\u0430\u043b\u044c\u0441\u044c\u043a\u0430 \u0432\u0443\u043b\u0438\u0446\u044f","city":"\u041f\u043e\u043a\u0440\u043e\u0432","state":"\u0414\u043d\u0456\u043f\u0440\u043e\u043f\u0435\u0442\u0440\u043e\u0432\u0441\u044c\u043a\u0430 \u043e\u0431\u043b\u0430\u0441\u0442\u044c","country":"\u0423\u043a\u0440\u0430\u0438\u043d\u0430","type":1,"lat":"47.65661820","lng":"34.09421990","created_at":"2019-06-14 14:32:40","updated_at":"2019-06-14 14:32:40","pivot":{"order_id":410,"address_id":333,"date_at":"2019-06-16 02:00:00","type":"loading"}},{"id":117,"place_id":"ChIJbTjLE1Dn1EARyuA4vvsYUEQ","address":"\u0414\u0443\u0434\u0430\u0440\u043a\u043e\u0432, \u041a\u0438\u0435\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c, \u0423\u043a\u0440\u0430\u0438\u043d\u0430, 08330","name":"\u0414\u0443\u0434\u0430\u0440\u043a\u043e\u0432","house":"","street":"","city":"\u0414\u0443\u0434\u0430\u0440\u043a\u043e\u0432","state":"\u041a\u0438\u0435\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c","country":"\u0423\u043a\u0440\u0430\u0438\u043d\u0430","type":0,"lat":"50.44727920","lng":"30.94517390","created_at":"2018-10-07 21:01:55","updated_at":"2019-04-02 08:42:18","pivot":{"order_id":410,"address_id":117,"date_at":"2019-06-16 22:00:00","type":"unloading"}}]));
        const directions = $.parseJSON(JSON.stringify({!!json_encode($directions)!!}))
        const geo = $.parseJSON(JSON.stringify({!!json_encode($geo)!!}))
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=&language=ru&callback=initMap"> </script>
    <div class="col-sm-6">
        <label>Карта маршрута</label>
        <div id="map" style="height: 350px"></div>
    </div>
    <div>
    количество до обработки {!!$count_beg!!} </br>
    количество после обработки {!!$count_end!!} </br>
    </div>
    
@endsection

<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ url('/plugins/phone_input/js/intlTelInput.js') }}"></script>

        {{-- Bower components js --}}
        <script type="text/javascript" src="{{ url('bower-components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/moment/min/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('bower-components/moment/min/moment-with-locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/moment/locale/ru.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/simplelightbox/dist/simple-lightbox.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('bower-components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>

        <script type="text/javascript" src="{{ url('/main_layout/js/script.js') }}"></script>
        <script type="text/javascript" src="{{ url('/main_layout/js/main.js') }}"></script>


