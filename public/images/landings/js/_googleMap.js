// GOOGLE
let map,
    point,
    marker,
    geocoder,
    placeIdTo,
    placeIdFrom,
    markers = [],
    waypoints = [],
    loading = false,
    autocompletes = [],
    directionsService,
    directionsRenderer,
    direction_waypoints = [];

let direction_waypoints_copy = [];
let first_waypoint;
let last_waypoint;

const markerArray = [];
const formDestination = $('#fDestination');

function initMap() {
    geocoder = new google.maps.Geocoder();
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer(
        {
            polylineOptions: {strokeColor: "#007cff"},
            strokeOpacity: 0.8,
            strokeWeight: 4,
            draggable: true
        }
    );
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: {lat: 48.411083, lng: 34.987417},
    });
    directionsRenderer.setMap(map);
    /* Distance change */
    directionsRenderer.addListener("directions_changed", () => {
        computeTotalDistance(directionsRenderer.getDirections());
    });

    document.getElementById("to").addEventListener("change", () => {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
        calculateDistance();
    });

    $(document).on('click', '#startOrder', function (event) {
        event.preventDefault();

        let form_valid = valid_destination_form(formDestination);

        if (form_valid === false) {
            return;
        }
        // calculateAndDisplayRoute(directionsService, directionsRenderer);
        // calculateDistance();
    });
}

function calculateAndDisplayRoute(directionsService, directionsRenderer) {
    directionsService.route(
        {
            origin: document.getElementById("from").value,
            destination: document.getElementById("to").value,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING,
            avoidTolls: true,
        },
        (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
                directionsRenderer.setOptions({suppressMarkers: true});
                directionsRenderer.setMap(map);
            } else {
                console.log("Запрос маршрутов не выполнен из-за " + status);
            }
        }
    );
}

/*
Distance change
 */
function computeTotalDistance(result) {
    let total = 0;
    const myRoute = result.routes[0];

    for (let i = 0; i < myRoute.legs.length; i++) {
        total += myRoute.legs[i].distance.value;
    }
    total = Math.floor(total / 1000);
    document.getElementById("distance").innerHTML = total + " km";
}

/*
Numbers () ------
 */
function declOfNum(number, words) {
    return words[(number % 100 > 4 && number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(number % 10 < 5) ? number % 10 : 5]];
}