var Transports = Transport;
var addresses = addr;
var directions = direction;

var map, bounds, directionsDisplay, polyline_fact, polyline_plan,
    infoWindows = [],
    markers     = [],
    points      = [];

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: Transports.lat, lng: Transports.lng},
        zoom: 8
    });
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer();
}

function setActiveMarker(el) {
    if (el.lng === 0 && el.lat === 0)
        return;

    let point  = new google.maps.LatLng(el),
        marker = new google.maps.Marker({map: map, position: point});

    let html = `
                    <div id="info-${el.id}" class="info-map-window">
                        <div class="title">ID ${el.id}</div>
                        <div><i class="fa fa-truck"></i>${el.name}</div>
                        <div><span class="speed-meter"></span>${el.speed} {{trans('all.km_h')}}</div>
                        <div><i class="fa fa-user"></i>${el.driver || '-'}</div>
                        <div><i class="cargo-icon"></i>${ el.order ? '#' + el.order + ' - ' + el.cargo : '-'}</div>
                    </div>`;
    let infowindow = new google.maps.InfoWindow({content: html});

    infowindow.transportId = el.id;
    infoWindows.push(infowindow);

    let iconName = getIcon(el);

    marker.setIcon(({
        url       : '/main_layout/images/svg/' + iconName,
        scaledSize: new google.maps.Size(36, 36)
    }));

    //Event click
    marker.addListener('click', function () {
        if (directionsDisplay)
            directionsDisplay.setMap(null);
        displayRoute = true;
        closeAllInfoWindows();
        infowindow.open(map, marker);
        routes(el);
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

    if (el.speed > 0)
        icon = 'truck-marker-active.svg';
    if (!el.ignition)
        icon = 'truck-marker-no-active.svg';

    return icon;
}
