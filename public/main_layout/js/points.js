let $formOrder = $('#newOrder');

// STEP-1
const $_form1 = $('#step-1');

// GOOGLE
let map, directionsService, directionsDisplay,
    loading = false,
    markers = [];

let waypoints = [];
let direction_waypoints = [];
let direction_waypoints_copy = [];
let first_waypoint;
let last_waypoint;

$('#submit').click(function (event) {
    event.preventDefault();
    requestStore($(this));
});

function requestStore(object){
    let data = $formOrder.serializeArray();

    //cargo_weight
    if(data[15].value === ''){
        data[17].value = '';
    }

    $.ajax({
        url: '/order-store',
        type: "post",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "cache-control": "no-cache, no-store"
        }})
        .done( function (data) {
            btnLoader('hide');
            if (data.status === 'OK')
                window.location.href = data.redirectTo;

            if (data.status === 'TokenMismatchException'){
                appAlert(data.text, data.title, '');
            }
        })
        .fail(function (data) {
            var errors = data.responseJSON;

            if (data.status === 422){
                btnLoader('hide');
                validation(errors, object);
            }
        });
}

/** Event select order type */
jQuery('.content-box__body-tabs-btn').click(function (event) {
    btnLoader($(this));
    requestStore($(this));
});

/** Validate Form New Order */
function validation(errors, object) {

    resetValidation();

    let res = true;

    $.each( errors, function( key, value ) {
        let keys = key.split('.');

        if(keys.length > 1){

            let elem;

            if(keys.length > 2) elem = keys[1]+'_'+keys[2]+'_'+keys[3];
            $formOrder.find('#error_'+elem).parent('.group').addClass('has-error');
            $formOrder.find('#error_'+elem).text(value);
            $formOrder.find('#error_'+elem).show();
            $formOrder.find('#error_'+elem).parent('.group').addClass('shake');
        }
        else {

            let elem;

            if(key === 'cargo_weight'){
                elem   = $('[name="' + key + '_input"]');
            } else {
                elem   = $('[name="' + key + '"]');
            }

            let parent = elem.hasClass('selectpicker') ? elem.parents('.error-for-selectpicker') : elem.parents('.group ');
            $formOrder.find('#error_'+key).text(value);
            $formOrder.find('#error_'+key).show();
            parent.addClass('shake');
            parent.addClass('has-error');
        }
    });

    let step = $(object).parents('.content-box__body').attr('id');

    // search duplicate time
    $('.duplicate-error').hide();
    var arr = [];
    $("input.duplicate").each(function(){
        var value = $(this).val();
        if (arr.indexOf(value) == -1)
            arr.push(value);
        else
        {
            if(value !== '') {
                $(this).parents('.group').addClass('has-error shake');
                $(this).next('.duplicate-error').show();
            }
        }
    });

    // search duplicate address
    var arr = [];
    $("input.duplicate-address").each(function(){
        var value = $(this).val();
        if (arr.indexOf(value) == -1)
            arr.push(value);
        else
        {
            if(value !== '') {
                $(this).parents('.group').addClass('has-error shake');
                $(this).next().next('.duplicate-error-address').show();
            }
        }
    });

    setTimeout(function () {
        $formOrder.find('.shake').removeClass('shake');
    }, 500);

    if(object.data('validate') === 'Flight' && $('#'+step).find('.text-danger').is(":visible") === false){
        resetValidation();
        object.parents('.content-box__body').toggleClass('active hidden').next().toggleClass('active hidden');
    }

    if(object.data('validate') === 'Cargo' && $('#'+step).find('.text-danger').is(":visible") === false){
        resetValidation();
        object.parents('.content-box__body').toggleClass('active hidden').next().toggleClass('active hidden');
    }
}

function resetValidation() {
    $formOrder.find('.text-danger').hide();
    $formOrder.find('.has-error').removeClass('has-error');
}

/** Event cancel create a new order */
jQuery('[data-cancel="flight"]').click(function () {
    appConfirm('', 'Нужно подтвердить отмену создания сделки', 'question', function () {
        window.location.href = window.location.origin + '/orders';
    });
});

$('#select-template').on('changed.bs.select', function (e) {
    $formOrder.css('opacity', 0.5);
    $.get('/templates/' + $(this).val())
        .done((response) => {
        if (response.status === 'OK') {
        renderOrder(response.data.order);
        initDateTimePicker();
    }
})
.fail((response) => console.warn(response))
.always(() => $formOrder.css('opacity', 1))
});

$('#asTemplate').click(function () {
    let $this = $(this);

    if ($this.prop("checked")) {
        swal({
            title            : 'Название шаблона',
            input            : 'text',
            allowEscapeKey   : false,
            showCancelButton : true,
            confirmButtonText:
                'Подтвердить',
            allowOutsideClick:
                false
        })
            .then((name) => {
            if (name.trim() !== '')
        $this.prop("checked", true).val(name);
    else
        $this.prop("checked", false);
    }, function (dismiss) {
            $this.prop("checked", false);
        })
    .catch(swal.noop)
    }
});

function resetValidate(name) {
    jQuery('#form' + name).find('.has-error').removeClass('has-error');
}

function renderOrder(order, set_date) {

    direction_waypoints = $.parseJSON(order.direction_waypoints);
    if (direction_waypoints === null) {
        direction_waypoints = [];
    }

    $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(direction_waypoints))
    clearWaypoints();
    if(typeof set_date == 'undefined')
        set_date = false;


    // Route block
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
    let key = {loading: 0, unloading: 0};

    $formOrder.find('.point-box:not([data-item="0"])').detach();

    order.addresses.forEach(function (address, i) {
        let type   = address.pivot.type,
            $_point = $formOrder.find(`.point-box-${address.pivot.type}[data-item="${key[type]}"]`),
            $point;
        if ($_point.length > 0) {
            $point = $_point;
        } else {
            $point = $formOrder.find(`.point-box-${address.pivot.type}[data-item="${key[type]-1}"]`).clone()
            $point.find(`[name="points[${type}][${key[type]-1}][address]"]`)
                .attr('name', `points[${type}][${key[type]}][address]`);

            $point.find(`[name="points[${type}][${key[type]-1}][address_id]"]`)
                .attr('name', `points[${type}][${key[type]}][address_id]`);

            $point.find(`[name="points[${type}][${key[type]-1}][date_at]"]`)
                .attr('name', `points[${type}][${key[type]}][date_at]`);

        }

        $point.find('[data-address]').val(address.id);
        $point.find('.hidden-prev-place-id').val(address.id);
        $point.attr('data-item', key[type]);

        if(!set_date)
            $point.find(`[name = "points[${type}][${key[type]}][date_at]"]`).val('');
        else
            $point.find(`[name = "points[${type}][${key[type]}][date_at]"]`).val(address.pivot.date_at);


        let $_input = $point.find(`[name="points[${type}][${key[type]}][address]"]`);
        $_input.val(address.address);
        $point.find('.hidden-prev-address').val(address.address);
        let data = {
            id : address.id,
            lat: address.lat,
            lng: address.lng,
        };
        $_input.prev().attr('data-marker-update', '');

        createMarker($_input.prev(), data);

        $formOrder.find(`.point-box-${address.pivot.type}[data-item="${key[type]-1}"]`).after($point);

        $_input.prev().attr('data-marker-update', i);
        key[type] += 1
    });
    routes();

    // Cargo block
    for (let k in order.cargo) {
        $formOrder.find(`[name="cargo_${k}"]`).val(order.cargo[k]);

        if(k === 'weight'){
            $formOrder.find('[name="cargo_weight_input"]').val(order.cargo[k] / 1000);
            $formOrder.find('[name="cargo_weight_type"]').val('t');
        }
    }
    $formOrder.find('[name="cargo_upload"]').selectpicker('val', order.cargo.loading_type);
    $formOrder.find('[name="cargo_pack"]').selectpicker('val', order.cargo.pack_type);
    $formOrder.find('[name="cargo_hazard"]').selectpicker('val', order.cargo.hazard_class);
    $formOrder.find(`#stars${order.rating_terms}`).prop("checked", true);
    $formOrder.find(`[name="register_transport"][value="${order.register_trans_terms}"]`).prop("checked", true);

    // Payment block
    $formOrder.find('[name="recommend_price"]').val(order.amount_plan);
    $formOrder.find('[name="payment_type"]').selectpicker('val', order.payment_type);
    $formOrder.find('[name="payment_terms"]').selectpicker('val', order.payment_terms);
}

initDateTimePicker();

// Event create a new point
$('.create-point a').click(function () {
    // Check points limit
    if ($_form1.find('.point-box').length > 7) {
        console.warn('Over points limit');
        return;
    }

    let $_clone = $(this).parent().prev().clone(),
        item    = $_clone.attr('data-item');

    ++item;
    $_clone.find('.datetimepickerTime.date-start').removeClass('date-start');
    $_clone.find('[data-marker-update]').attr('data-marker-update', '');
    $_clone
        .attr('data-item', item)
        .find('[name]')
        .each(function () {
            let oldName = $(this).attr('name');
            $(this).attr('name', oldName.replace(/(\d)/, item)).val('');
        });
    $_clone.append('<div class="delete-point" onclick="detachPoint(event)"></div>');
    $_clone.hide().insertBefore($(this).parent()).fadeIn(150);

    initDateTimePicker();
});

// Event autocomplete
/*
$_form1.on('change', '.autocomplete', function () {
    let addressId = $(this).siblings('input[data-address]').val();

    if (addressId > 0) {
        clearWaypoints();
        let _i = markers.findIndex(function (item) {
            return item.addressId === +addressId;
        });
        $(this).siblings('input[data-marker-update]').attr('data-marker-update', _i);
        deleteMarker(addressId, true)
    }
});
*/

// for pre-order from landing
$(function() {
    let place_id;
    let address_details = 'address/details';
    $( ".address_place_id" ).each(function( index ) {
        place_id = $(this).val();
        let input_address = $(this);

        $.ajax({
            method: "GET",
            url: address_details,
            data: { place_id: place_id}
        })
            .done(function( result ) {
                input_address.val(result.id);
                //createMarker(input_address, result);
                if (markers.length >= 2) {
                    routes();
                }
            });
    });
});

// The event for select the address
$_form1.on('click', '.autocomplete-result a', function () {
    let $_parent = $(this).parent().parent(),
        placeId  = $(this).attr('data-place'),
        address  = $_parent.find('input[type="hidden"]').data('address');

    $_parent.find('input.autocomplete').val($(this).text());

    if(typeof address_details == 'undefined')
        address_details = 'address/details';


    $.get(address_details, {place_id: placeId})
        .done((data) => {
            let $_input = $_parent.find('input[data-address]');
            direction_waypoints_copy = direction_waypoints.slice();
            if (!$.isEmptyObject(data)) {

                waypts = [];
                for (let i = 0; i < direction_waypoints.length; i++) {
                    waypts.push({
                        location: new google.maps.LatLng(direction_waypoints[i][0], direction_waypoints[i][1]),
                        stopover: true
                    });
                }
                if (waypts.length > 1) {
                    routeCheck(waypts, function (response, status) {
                        if (status === 'OK') {
                            updateMapFromInput(address, $_input, data);
                        } else {
                            appAlert('', status, 'warning')
                            direction_waypoints = direction_waypoints_copy.slice();
                            routes();
                        }
                    });
                } else {
                    updateMapFromInput(address, $_input, data);
                }
            } else {
                rollbackInput($_input, 'Place not found');
            }
        })
});

function updateMapFromInput(address, $_input, data) {
    updateDirectionWayPointsFromInput(address, $_input, data);
    $_input.val(data.id);
    createMarker($_input, data);
    let prev_id = $_input.parent().find('.hidden-prev-place-id').val();
    deleteMarker(prev_id, true);
    if (markers.length >= 2) {
        routes();
    }

    $_input.parent().find('.hidden-prev-address').val(data.address);
    $_input.parent().find('.hidden-prev-place-id').val(data.id);
}

function updateDirectionWayPointsFromInput(address, $_input, data)
{
    direction_waypoints = [];
    let point = [data.lat, data.lng];
    if (address === 'loading') {
        direction_waypoints[0] = point;
        if (last_waypoint !== undefined) {
            direction_waypoints[1] = last_waypoint;
        }
        first_waypoint = point;
    } else {
        if (first_waypoint !== undefined) {
            direction_waypoints[0] = first_waypoint;
            direction_waypoints[1] = point;
        } else {
            direction_waypoints[0] = point;
        }
        last_waypoint = point;
    }

    $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(direction_waypoints))
}

function rollbackInput($_input, error) {
    direction_waypoints = direction_waypoints_copy.slice();
    let prev_address = $_input.parent().find('.hidden-prev-address').val();
    let prev_id = $_input.parent().find('.hidden-prev-place-id').val();

    $_input.val(prev_id);
    $_input.parent().find('.autocomplete').val(prev_address);
    appAlert('', error, 'warning');
    routes();
}

/** --- FUNCTIONS --- */
function detachPoint(e) {
    let addressId = $(e.target).parent().find('input[data-address]').val();
    $(e.target).parent().fadeOut(150, function () {
        if (addressId > 0) {
            deleteMarker(addressId);
        }
        $(this).detach();
    })
}

function initDateTimeSelector(el, type){

    el.each(function (index) {


        $(this).on("dp.show", function (e) {

            var $loading = $('.point-box-loading .datetimepickerTime');
            var $unloading = $('.point-box-unloading .datetimepickerTime');

            if(type == 1) {
                var max = null;
                var min = new Date();

                $unloading.each(function (index) {
                    var date = $(this).data("DateTimePicker").date();
                    if (date != null) {
                        var m = new Date(
                            date._d.getFullYear(),
                            date._d.getMonth(),
                            date._d.getDate(),
                            date._d.getHours(),
                            date._d.getMinutes(),
                            date._d.getSeconds()
                        );

                        if (max == null || m.valueOf() > max.valueOf()) {
                            max = m;
                        }
                    }
                });

            } else {
                var max = null;
                var min = null;
                var cur = new Date();

                $loading.each(function (index) {
                    var date = $(this).data("DateTimePicker").date();
                    if (date != null) {
                        var m = new Date(
                            date._d.getFullYear(),
                            date._d.getMonth(),
                            date._d.getDate(),
                            date._d.getHours(),
                            date._d.getMinutes(),
                            date._d.getSeconds()
                        );

                        if (min == null || m.valueOf() < min.valueOf()) {
                            min = m;
                        }
                    }
                });

                if(min == null || cur.valueOf() < min.valueOf()){
                    min = cur;
                }

            }

            if (max != null) {
                $(this).data("DateTimePicker").maxDate(max);
            }

            if (min != null) {
                $(this).data("DateTimePicker").minDate(min);
            }
        });
    });
}

function initDateTimePicker() {
    let lang = $('body').data('language');

    let options     = {
            useCurrent : false,
            locale     : lang,
            format     : 'DD/MM/YYYY HH:mm',
            // sideBySide : true,
            // collapse   : true,
            // debug:true
        },
        $_dateLoading = $('.point-box-loading .datetimepickerTime'),
        $_dateUnLoading = $('.point-box-unloading .datetimepickerTime');

    $_dateLoading.datetimepicker(options);
    // $('.point-box-loading .datetimepickerTime').data("DateTimePicker").show();
    options.useCurrent = false;
    $_dateUnLoading.datetimepicker(options);

    initDateTimeSelector($_dateLoading, 1);
    initDateTimeSelector($_dateUnLoading, 2);

    /*
    /*
     $_dateUnLoading.on("dp.change", function (e) {
     $_dateLoading.data("DateTimePicker").maxDate(e.date);
     });
     */
}

// GOOGLE MAPS

/**
 * Init map on page load
 */
function initMap() {
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer(
        {
            polylineOptions: {strokeColor: "#007cff"},
            strokeOpacity  : 0.8,
            strokeWeight   : 4,
            draggable: true
        }
    );
    map               = new google.maps.Map(
        document.getElementById('map'),
        {
            zoom           : 4,
            center         : {lat: 48.411083, lng: 34.987417},
            mapTypeControl : false,
            gestureHandling: 'cooperative'
        }
    );

    /**
     * When direction changed - clear old waypoints and draw new with correct markers
     */
    directionsDisplay.addListener('directions_changed', function() {
        if (directionsDisplay.dragResult !== undefined) {
            direction_waypoints_copy = direction_waypoints.slice();
            testRoute(directionsDisplay);
        } else {
            updateMapAfterDirectionChanged();
        }
    });
}

/**
 * Testing route, before update map (check route status by waypoints)
 * @param directionsDisplay
 */
function testRoute(directionsDisplay)
{
    var result = directionsDisplay.getDirections()
    var waypts = [];

    var directionWaypoints = result.request.waypoints;
    var directionWaypointsLength = directionWaypoints.length - 1;

    waypts.push({
        location: new google.maps.LatLng(result.request.origin.location.lat(), result.request.origin.location.lng()),
        stopover: true
    });

    for (let i = 0; i <= directionWaypointsLength; i++) {
        if (directionWaypoints[i].location.location === undefined) {
            waypts.push({
                location: new google.maps.LatLng(directionWaypoints[i].location.lat(), directionWaypoints[i].location.lng()),
                stopover: true
            });
        } else {
            waypts.push({
                location: new google.maps.LatLng(directionWaypoints[i].location.location.lat(), directionWaypoints[i].location.location.lng()),
                stopover: true
            });
        }
    }
    waypts.push({
        location: new google.maps.LatLng(result.request.destination.location.lat(), result.request.destination.location.lng()),
        stopover: true
    });

    routeCheck(waypts, function(response, status) {
        if (status === 'OK') {
            updateMapAfterDirectionChanged(directionsDisplay);
        } else {
            appAlert('', status, 'warning')
            direction_waypoints = direction_waypoints_copy.slice();
            routes();
        }
    });
}

function updateMapAfterDirectionChanged() {
    clearWaypoints();
    setPolyLine(directionsDisplay.getDirections());
    setWayPoints(directionsDisplay.getDirections());
    setMarkers(directionsDisplay.getDirections());
    updateBounds();
}

/**
 * Set markers with click event listeners
 * @param result
 */
function setMarkers(result)
{
    points = getPoints(result);
    waypoints = [];
    for (let i = 0; i < points.length; i++) {

        var point = new google.maps.LatLng(points[i][0], points[i][1]);
        waypoints[i] = new google.maps.Marker({
            position: point,
            title: "",
            map: map,
            animation: google.maps.Animation.DROP,
            icon: {
                url : '/main_layout/images/svg/circle.svg',
                size: new google.maps.Size(12, 12),
                scaledSize: new google.maps.Size(12, 12),
            }
        });

        waypoints[i].addListener('click', function() {
            this.setMap(null);
            let waypoint_index = i+1;
            direction_waypoints.splice(waypoint_index, 1);
            $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(direction_waypoints))
            clearWaypoints();
            routes();
        });
    }
}

/**
 * Update map bounds (scale)
 */
function updateBounds() {
    var bounds = new google.maps.LatLngBounds();

    for (let i = 0; i < direction_waypoints.length; i++) {
        var point = new google.maps.LatLng(direction_waypoints[i][0], direction_waypoints[i][1]);
        bounds.extend(point);
    }

    if (direction_waypoints.length > 0) {
        map.fitBounds(bounds);
    }
}

/**
 * Get way points from google request, or return current waypoints (if request dont have points)
 *
 * @param result
 * @returns {[]}
 */
function getPoints(result) {
    var points = [];

    if (result !== null && result.request.waypoints.length > 0) {
        let request = result.request;
        let waypointsLength = request.waypoints.length - 1;
        for (let i = 0; i <= waypointsLength; i++) {
            if (request.waypoints[i].location.location === undefined) {
                points.push([request.waypoints[i].location.lat(), request.waypoints[i].location.lng()]);
            } else {
                points.push([request.waypoints[i].location.location.lat(), request.waypoints[i].location.location.lng()]);
            }
        }
    } else {
        var directionWaypointsLength = direction_waypoints.length - 1;
        for (let i = 0; i <= directionWaypointsLength; i++) {
            if (directionWaypointsLength !== i && i !== 0) {
                points.push([direction_waypoints[i][0], direction_waypoints[i][1]]);
            }
        }
    }

    return points;
}

/**
 * Draw polyline route, from origin > current direction waypoints > destination
 */
function routes() {
    let waypts = [];
    let start;
    let end;
    let length;
    if (direction_waypoints.length > 0) {
        length = direction_waypoints.length;
        start = new google.maps.LatLng(direction_waypoints[0][0], direction_waypoints[0][1]);
        end = new google.maps.LatLng(direction_waypoints[length - 1][0], direction_waypoints[length - 1][1]);
    } else {
        length = markers.length;
        start = new google.maps.LatLng(markers[0].position.lat(), markers[0].position.lng());
        end = new google.maps.LatLng(markers[length - 1].position.lat(), markers[length - 1].position.lng());
    }

    if (direction_waypoints === null) {
        direction_waypoints = [];
    }
    var directionWaypointsLength = direction_waypoints.length - 1;
    for (let i = 0; i <= directionWaypointsLength; i++) {
        if (directionWaypointsLength !== i && i !== 0) {
            waypts.push({
                location: direction_waypoints[i][0] + ',' + direction_waypoints[i][1],
                stopover: true
            });
        }
    }

    let request = {
        origin           : start,
        destination      : end,
        waypoints        : waypts,
        optimizeWaypoints: true,
        travelMode       : 'DRIVING'
    };
    directionsService.route(request, function (result, status) {

        if (status === 'OK') {
            directionsDisplay.setDirections(result);
            directionsDisplay.setOptions({suppressMarkers: true});
            directionsDisplay.setMap(map);

            // Get polyline points
            let overview_polyline = '';
            let legs              = result.routes[0].legs;

            for (let i = 0; i < legs.length; i++) {
                let steps     = legs[i].steps;
                let delimiter = ':::';
                for (let j = 0; j < steps.length; j++) {
                    overview_polyline += steps[j].encoded_lat_lngs + delimiter;
                }
            }
            $_form1.find('input[name="route_polyline"]').val(overview_polyline)
        } else {
            console.warn(result);
        }
    });
}

/**
 * Clear waypoints from map before create new
 * (If it is not cleared, then sometimes a bug occurs, with a click on another marker)
 */
function clearWaypoints() {
    if (waypoints !== undefined) {
        for (let i = 0; i < waypoints.length; i++) {
            waypoints[i].setMap(null);
        }
    }
    waypoints = [];
}

/**
 * Set polyline encoded - input value
 * @param result
 */
function setPolyLine(result) {
    let overview_polyline = '';
    let legs              = result.routes[0].legs;
    let legsLength        = legs.length - 1;
    for (let i = 0; i <= legsLength; i++) {
        let steps     = legs[i].steps;
        let delimiter = ':::';
        let stepsLength = steps.length - 1;
        for (let j = 0; j <= stepsLength; j++) {
            overview_polyline += steps[j].encoded_lat_lngs + delimiter;
        }
    }

    $_form1.find('input[name="route_polyline"]').val(overview_polyline)
}

/**
 * Set new waypoints
 * @param result
 */
function setWayPoints(result) {
    let request     = result.request;
    let waypoints   = [];
    if (request.waypoints.length === 0) {
        waypoints.push([request.origin.location.lat(), request.origin.location.lng()]);
        waypoints.push([request.destination.location.lat(), request.destination.location.lng()]);
    } else {
        waypoints.push([request.origin.location.lat(), request.origin.location.lng()]);
        let waypointsLength = request.waypoints.length - 1;
        for (let i = 0; i <= waypointsLength; i++) {
            if (i <= 25) {
                if (request.waypoints[i].location.location === undefined) {
                    waypoints.push([request.waypoints[i].location.lat(), request.waypoints[i].location.lng()]);
                } else {
                    waypoints.push([request.waypoints[i].location.location.lat(), request.waypoints[i].location.location.lng()]);
                }
            } else {
                appAlert('25 points allowed');
                break;
            }
        }
        waypoints.push([request.destination.location.lat(), request.destination.location.lng()]);
    }

    direction_waypoints = waypoints;
    $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(waypoints))
}

// Adds a marker to the map.
function createMarker($_input, data) {
    let marker   = new google.maps.Marker({position: {lat: +data.lat, lng: +data.lng}, map: map}),
        updateId = $_input.attr('data-marker-update');

    marker.addressId = data.id;
    marker.type      = $_input.attr('data-address');

    if (updateId !== '') {
        markers[updateId] = marker;
    } else {
        let key = -1;
        markers.forEach((item, k) => {
            if (item.type === marker.type)
        key = k;
    });

        if ((key !== -1) && (marker.type !== 'unloading'))
            markers.splice(key + 1, 0, marker);
        else
            markers.push(marker);
    }
    resizeMarker();
    fitBounds();
}

/**
 * fit bounds and resize map
 */
function fitBounds() {
    if (markers.length > 1) {
        let bounds = new google.maps.LatLngBounds();
        for (let i = 0; i < markers.length; i++) {
            bounds.extend(markers[i].getPosition());
        }
        map.fitBounds(bounds);
    } else if (markers.length === 1) {
        map.setCenter(markers[0].getPosition());
        map.setZoom(8);
    }
}

/**
 * Delete marker
 * @param addressId
 * @param onChange
 */
function deleteMarker(addressId, onChange) {
    let _i;
    markers.forEach(function callback(marker, index) {
        if(parseInt(marker.addressId) === parseInt(addressId)) {
            _i = index;
        }
    });

    if (markers[_i] !== undefined) {
        markers[_i].setMap(null);
    }

    if (onChange === undefined) {
        markers = markers.filter((marker) => {
            return marker.addressId !== +addressId
        });
        resizeMarker();
        fitBounds();
        routes();
    }
}

/**
 * Resize marker
 */
function resizeMarker() {
    markers.forEach((marker, k) => {
        let size  = (k === 0) || (k === (markers.length - 1)) ? {w: 26, h: 26} : {w: 20, h: 20},
        color = (marker.type === 'loading') ? 'blue' : 'green';

        marker.setIcon(({
            url       : `/main_layout/images/svg/pin-${color}.svg`,
            scaledSize: new google.maps.Size(size.w, size.h)
        }));
    });
}

/**
 * Check route - is allowed to build route, with callback (response and status)
 *
 * @param waypts
 * @param callback
 */
function routeCheck(waypts, callback)
{
    let start = waypts[0].location.lat() + ',' + waypts[0].location.lng();
    let end = waypts[waypts.length - 1].location.lat() + ',' + waypts[waypts.length - 1].location.lng();
    directionsService.route({
        origin: start,
        destination: end,
        travelMode: 'DRIVING',
        waypoints: waypts,
        optimizeWaypoints: true
    }, callback);
}