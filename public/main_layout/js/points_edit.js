const $_form1 = $('#step-1');
let $formOrder = $('#newOrder');

var mapEditor = {

    markers: [],
    ready_map: false,
    timer: null,
    direction_waypoints_copy: [],

    is_ready_map: function(){
        if(mapEditor.ready_map){
            mapEditor.drawRoutes();
            clearInterval(mapEditor.timer);
        }
    },
    resizeMarkerType: function(type, m, k){

        var color = (type === 'loading') ? 'blue' : 'green';

        var size  = (k === 0) || (k === (mapEditor.markers[type].length - 1)) ? {w: 26, h: 26} : {w: 20, h: 20};

        mapEditor.markers[type][k].setIcon(({
            url       : '/main_layout/images/svg/pin-'+color+'.svg',
            scaledSize: new google.maps.Size(size.w, size.h)
        }));
    },
    resizeMarkers: function(){

        mapEditor.markers['loading'].forEach(function(marker, k) {
            mapEditor.resizeMarkerType('loading', marker, k)
        });

        mapEditor.markers['unloading'].forEach(function(marker, k) {
            mapEditor.resizeMarkerType('unloading', marker, k)
        });
    },
    setMarker: function($_input, data){

        let marker   = new google.maps.Marker({position: {lat: +data.lat, lng: +data.lng}, map: map}),
            updateId = $_input.attr('data-marker-update');

        marker.addressId = data.id;
        marker.type      = $_input.attr('data-address');


        var next = mapEditor.markers[marker.type].length;
        mapEditor.markers[marker.type][next] = marker;
        mapEditor.resizeMarkers();
    },
    RenderOrder: function(order){

        mapEditor.markers['loading']      = [];
        mapEditor.markers['unloading']    = [];

        var key = {loading: 0, unloading: 0};
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

            if(key[type] != 0)
                $point.append('<div class="delete-point" onclick="detachPoint(event)"></div>');

            initDateTimeSelector($point.find(`[name = "points[${type}][${key[type]}][date_at]"]`), type);

            let d= new Date(address.pivot.date_at);
            let date_format_at =
                (d.getDate()<10?'0':'') + d.getDate()+'/'+
                ((d.getMonth() + 1)<10?'0':'') + (d.getMonth()+1)+'/'+
                d.getFullYear()+' '+
                (d.getHours()<10?'0':'') + d.getHours()+':'+
                (d.getMinutes()<10?'0':'') + d.getMinutes();

            $point.find('[data-address]').val(address.id);
            $point.find('.hidden-prev-place-id').val(address.id);
            $point.attr('data-item', key[type]);
            // $point.find(`[name = "points[${type}][${key[type]}][date_at]"]`).val(address.pivot.date_at);
            $point.find(`[name = "points[${type}][${key[type]}][date_at]"]`).val(date_format_at);
            let $_input = $point.find(`[name="points[${type}][${key[type]}][address]"]`);
            $_input.val(address.address);
            $point.find('.hidden-prev-address').val(address.address);
            let data = {
                id : address.id,
                lat: address.lat,
                lng: address.lng,
            };

            $_input.prev().attr('data-marker-update', '');
            mapEditor.setMarker($_input.prev(), data);

            $formOrder.find(`.point-box-${address.pivot.type}[data-item="${key[type]-1}"]`).after($point);

            $_input.prev().attr('data-marker-update', i);
            key[type] += 1

            last = order.addresses.length - 1;
            if(last == i)
                mapEditor.ready_map = true;
        });

        mapEditor.timer = setInterval(mapEditor.is_ready_map, 1000);
    },
    drawRoutes: function() {
        if (direction_waypoints.length > 0) {
            var bounds = new google.maps.LatLngBounds();
            var waypts = [];
            var directionWaypointsLength = direction_waypoints.length - 1;
            for (let i = 0; i <= directionWaypointsLength; i++) {
                var point = new google.maps.LatLng(direction_waypoints[i][0],direction_waypoints[i][1]);
                waypts.push({
                    location: direction_waypoints[i][0]+','+direction_waypoints[i][1],
                    stopover: true
                });
                bounds.extend(point);
            }

            directionsService.route({
                origin: new google.maps.LatLng(direction_waypoints[0][0], direction_waypoints[0][1]),
                destination: new google.maps.LatLng(direction_waypoints[directionWaypointsLength][0], direction_waypoints[directionWaypointsLength][1]),
                travelMode: 'DRIVING',
                waypoints: waypts,
                optimizeWaypoints: true
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    directionsDisplay.setOptions({suppressMarkers: true});
                    directionsDisplay.setMap(map);
                    map.fitBounds(bounds);
                }
            });

        } else {
            //support old code
            var waypts = [];
            var length = mapEditor.markers['unloading'].length;
            var start = mapEditor.markers['loading'][0].getPosition();
            var end = mapEditor.markers['unloading'][length - 1].getPosition();

            mapEditor.markers['loading'].forEach(function (marker) {
                waypts.push({location: marker.getPosition(), stopover: true});
            });

            mapEditor.markers['unloading'].forEach(function (marker) {
                waypts.push({location: marker.getPosition(), stopover: true});
            });


            let request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: 'DRIVING'
            };
            directionsService.route(request, function (result, status) {

                if (status === 'OK') {
                    directionsDisplay.setDirections(result);
                    directionsDisplay.setOptions({suppressMarkers: true});
                    directionsDisplay.setMap(map);

                    // Get polyline points
                    let overview_polyline = '';
                    let legs = result.routes[0].legs;

                    for (let i = 0; i < legs.length; i++) {
                        let steps = legs[i].steps;
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
    },
    resizeMap: function(){

    },
    addPoint: function($_input, data, prev){

        var $parent = $_input.parent();
        var type = $parent.find('input[type="hidden"]').data('address');

        if(prev != '')
            mapEditor.deleteMarker(prev, type, false);

        mapEditor.setMarker($_input, data);
        mapEditor.drawRoutes();
    },
    deleteMarker: function(addressId, type, redraw) {

        if(typeof redraw == 'undefined')
            redraw = true;

        let _i = mapEditor.markers[type].findIndex(function (item) {
            return item.addressId === +addressId;
        });

        mapEditor.markers[type][_i].setMap(null);
        mapEditor.markers[type].splice(_i, 1);

        if(redraw)
            mapEditor.drawRoutes();
    },
    saveOrder: function(){
        var errors = false;
        $('#editOrderAddress input[type="text"]').attr('required', true).each(function( index ) {
            if ($(this).val() == '') {
                $(this).parent().addClass('has-error');
                errors = true;
            } else {
                $(this).parent().removeClass('has-error');
            }
        });

        if(validation_dublicate() === false){
            errors = true;
        }

        if (!errors) {

            $data = $('#generalForm').serialize();

            $data += '&recommend_price='+$('input[name=recommend_price]').val();

            let partners_request_view = $('#partners_request').is(":visible");

            if(partners_request_view){
                $data += '&partners_request=true';
                $data += '&offer_partner='+$('input[name=offer_partner]').val();
                $data += '&offer_partner_vat='+$('input[name=offer_partner_vat]').val();
                $data += '&offer_partner_payment_type='+$('#offer_partner_payment_type').val();
                $data += '&offer_partner_payment_term='+$('#offer_partner_payment_term').val();
                $data += '&partners=' + $('.selectpicker_transport').val();
            }

            $('.cargo-block input').each(function(){
                if($(this).is(':disabled') === false){
                    $data += '&cargo[' + $(this).attr('name') + ']=' + $(this).val();
                }
            });

            $('.cargo-block select').each(function(){
                if($(this).is(':disabled') === false){
                    $data += '&cargo[' + $(this).attr('name') + ']=' + $(this).val();
                }
            });

            orderId = $('#orderID').val();

            if(orderId === undefined){
                orderId = $('.content-box__body').data('order');
            }

            $.ajax({
                url: '/order/' + orderId,
                type: 'POST',
                data: $data,
                dataType: 'JSON',
            }).done(function (data) {
                resetValidation();
                if(data.estimated_arrival !== false)
                    $('#estimated_arrival').val(data.estimated_arrival);
                if(data.partners_request !== false)
                    window.location.reload();
            }).fail(function (data) {
                var errors = data.responseJSON;

                if (data.status === 422){
                    validation(errors);
                } else {
                    appAlert('', 'Something went wrong... :(', 'warning');
                }
                btnLoader('hide');

            }).always(function () {
                btnLoader(null);
            });
        } else {
            btnLoader(null);
        }
    }
}

/** Validate Form New Order */
function validation(errors) {

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

            let elem   = $('[name="' + key + '"]');
            let parent = elem.hasClass('selectpicker') ? elem.parents('.error-for-selectpicker') : elem.parent('.form-group');
            $('.content-box__body').find('#error_'+key).text(value);
            $('.content-box__body').find('#error_'+key).show();
            parent.addClass('shake');
            parent.addClass('has-error');
        }
    });

    setTimeout(function () {
        $formOrder.find('.shake').removeClass('shake');
    }, 500);
}

function validation_dublicate(){

    resetValidation();

    var error = true;

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
                error = false;
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
                $(this).next('.duplicate-error-address').show();
                error = false;
            }
        }
    });

    setTimeout(function () {
        $formOrder.find('.shake').removeClass('shake');
    }, 500);

    return error;
}

function resetValidation() {
    $('.content-box__body').find('.text-danger').hide();
    $('.content-box__body').find('.has-error').removeClass('has-error');
}

// GOOGLE MAPS

/**
 * Init map on page load
 */
function initMap() {
    var isDraggable = false;

    if(isEditable === false)
    {
        console.log(isEditable);
        return;
    }

    if (isEditable !== undefined && isEditable) {
        isDraggable = true;
    }
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer(
        {
            polylineOptions: {strokeColor: "#007cff"},
            strokeOpacity  : 0.8,
            strokeWeight   : 4,
            draggable      : isDraggable
        }
    );

    directionsDisplay.addListener('directions_changed', function() {
        if (directionsDisplay.dragResult !== undefined) {
            mapEditor.direction_waypoints_copy = direction_waypoints.slice();
            testRoute(directionsDisplay);
        } else {
            updateMap(directionsDisplay);
        }
    });

    map = new google.maps.Map(
        document.getElementById('map'),
        {
            zoom           : 4,
            center         : {lat: 48.411083, lng: 34.987417},
            mapTypeControl : false,
            gestureHandling: 'cooperative'
        }
    );
}

/**
 * Update map (route, markers, waypoints...)
 * @param directionsDisplay
 */
function updateMap(directionsDisplay) {
    clearWaypoints();
    setPolyLine(directionsDisplay.getDirections());
    setWayPoints(directionsDisplay.getDirections());
    setMarkers(directionsDisplay.getDirections());
    updateBounds();
}

/**
 * Testing route, before update map (check route status by waypoints)
 * @param directionsDisplay
 */
function testRoute(directionsDisplay) {

    var result = directionsDisplay.getDirections()
    var waypts = [];

    var directionWaypoints = result.request.waypoints;
    var directionWaypointsLength = directionWaypoints.length - 1;

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

    routeCheck(waypts, function(response, status) {
        if (status === 'OK') {
            updateMap(directionsDisplay);
        } else {
            appAlert('', status, 'warning')
            direction_waypoints = mapEditor.direction_waypoints_copy.slice();
            mapEditor.drawRoutes();
        }
    });
}

/**
 * Set route markers by waypoints search result
 * @param result
 */
function setMarkers(result)
{
    var points = [];
    var waypointsLength = direction_waypoints.length - 1;
    if (waypointsLength > 0) {
        for (let i = 0; i <= waypointsLength; i++) {

            if (waypointsLength !== i && i !== 0) {
                points.push([direction_waypoints[i][0], direction_waypoints[i][1]]);
            }
        }
    } else {
        let request = result.request;
        let waypointsLength = request.waypoints.length - 1;

        for (let i = 0; i <= waypointsLength; i++) {
            if (waypointsLength !== i && i !== 0) {
                points.push([request.waypoints[i][0], request.waypoints[i][1]])
            }
        }
    }

    mapEditor.markers['waypoints'] = [];
    var pointsLength = points.length - 1;
    for (let i = 0; i <= pointsLength; i++) {
        var point = new google.maps.LatLng(points[i][0], points[i][1]);
        mapEditor.markers['waypoints'][i] = new google.maps.Marker({
            position: point,
            title: "",
            map: map,
            animation: google.maps.Animation.DROP,
            icon: {
                url : '/main_layout/images/svg/circle.svg',
                size: new google.maps.Size(20, 20),
                scaledSize: new google.maps.Size(20, 20),
            }
        });

        mapEditor.markers['waypoints'][i].addListener('click', function() {
            this.setMap(null);
            let waypoint_index = i+1;
            direction_waypoints.splice(waypoint_index, 1);
            $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(direction_waypoints))
            clearWaypoints();
            mapEditor.drawRoutes();
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
    }
    direction_waypoints = waypoints;
    $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(waypoints))
}


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
    $_clone.find('.box_error_unloading_date_at').attr('id', 'error_unloading_' + item + '_date_at');
    $_clone.find('.box_error_unloading_address').attr('id', 'error_unloading_' + item + '_address');
    $_clone.find('.box_error_loading_date_at').attr('id', 'error_loading_' + item + '_date_at');
    $_clone.find('.box_error_loading_address').attr('id', 'error_loading_' + item + '_address');
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



// The event for select the address
$_form1.on('click', '.autocomplete-result a', function () {
    let $_parent = $(this).parent().parent(),
        placeId  = $(this).attr('data-place'),
        address  = $_parent.find('input[type="hidden"]').data('address');

    $_parent.find('input.autocomplete').val($(this).text());

    if(typeof address_details == 'undefined')
        address_details = 'address/details';


    $.get(address_details, {place_id: placeId}).done((data) => {
        prev = $_parent.find('input[data-address]').val();
        let $_input = $_parent.find('input[data-address]');
        if (!$.isEmptyObject(data)) {
            $_input.val(data.id);
            if (address === 'loading' || address === 'unloading') {
                updatePlace(address, $_input, data);
            } else {
                mapEditor.addPoint($_input, data, prev);
            }
        } else {
            mapEditor.direction_waypoints_copy = direction_waypoints.slice();
            rollbackInput($_input, 'Place not found');
        }
    })
});

/**
 * Update place marker and route
 * @param address
 * @param $_input
 * @param data
 */
function updatePlace(address, $_input, data) {
    if (direction_waypoints.length > 0) {
        mapEditor.direction_waypoints_copy = direction_waypoints.slice();
        var deleteCount = direction_waypoints.length - 2;
        if (address === 'loading') {
            direction_waypoints[0] = [data.lat, data.lng];
        } else {
            let lastWaypoint = direction_waypoints.length - 1;
            direction_waypoints[lastWaypoint] = [data.lat, data.lng];
        }

        if (deleteCount > 0) {
            direction_waypoints.splice(1, deleteCount);
        }

        var waypts = [];
        for (let i = 0; i < direction_waypoints.length; i++) {
            waypts.push({
                location: new google.maps.LatLng(direction_waypoints[i][0], direction_waypoints[i][1]),
                stopover: true
            });
        }

        routeCheck(waypts, function(response, status) {
            if (status === 'OK') {

                $_form1.find('input[name="direction_waypoints"]').val(JSON.stringify(direction_waypoints));
                for (let i = 0; i < mapEditor.markers['loading'].length; i++) {
                    mapEditor.markers['loading'][i].setMap(null);
                    mapEditor.markers['loading'].splice(i, 1);
                }

                for (let i = 0; i < mapEditor.markers['unloading'].length; i++) {
                    mapEditor.markers['unloading'][i].setMap(null);
                    mapEditor.markers['unloading'].splice(i, 1);
                }

                if (mapEditor.markers['waypoints'] !== undefined) {
                    for (let i = 0; i < mapEditor.markers['waypoints'].length; i++) {
                        mapEditor.markers['waypoints'][i].setMap(null);
                        mapEditor.markers['waypoints'].splice(i, 1);
                    }
                }

                mapEditor.drawRoutes();
                mapEditor.setMarker($_input, data);

                // generate new markers from new route
                if (address === 'loading') {
                    var point = new google.maps.LatLng(direction_waypoints[direction_waypoints.length - 1][0], direction_waypoints[direction_waypoints.length - 1][1]);
                    mapEditor.markers['unloading'][0] = new google.maps.Marker({
                        position: point,
                        title: "",
                        map: map
                    });
                    mapEditor.resizeMarkerType('unloading', mapEditor.markers['unloading'][0], 0)
                }

                if (address === 'unloading') {
                    var point = new google.maps.LatLng(direction_waypoints[0][0], direction_waypoints[0][1]);
                    mapEditor.markers['loading'][0] = new google.maps.Marker({
                        position: point,
                        title: "",
                        map: map
                    });
                    mapEditor.resizeMarkerType('loading', mapEditor.markers['loading'][0], 0)
                }
                $_input.parent().find('.hidden-prev-address').val(data.address);
                $_input.parent().find('.hidden-prev-place-id').val(data.id);
            } else {
                rollbackInput($_input, status);
            }
        });
    } else {
        mapEditor.drawRoutes();
    }
}

/**
 * rolling back values after wrong waypoint set
 * @param $_input
 */
function rollbackInput($_input, error) {
    var prev_id = $_input.parent().find('.hidden-prev-address').val();
    var prev_address = $_input.parent().find('.hidden-prev-place-id').val();
    $_input.val(prev_address);
    $_input.parent().find('.autocomplete').val(prev_id);
    appAlert('', error, 'warning');
    direction_waypoints = mapEditor.direction_waypoints_copy.slice();
    mapEditor.drawRoutes();
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


    $_dateLoading.datetimepicker();
    // $_dateLoading.datetimepicker(options);
    options.useCurrent = false;
    $_dateUnLoading.datetimepicker(options);

    initDateTimeSelector($_dateLoading, 1);
    initDateTimeSelector($_dateUnLoading, 2);

    /*
     $_dateUnLoading.on("dp.change", function (e) {
     $_dateLoading.data("DateTimePicker").maxDate(e.date);
     });
     */


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

$('.updateAddress').click(function (event) {
    event.preventDefault();
    btnLoader($(this));
    mapEditor.saveOrder();
});

function detachPoint(e) {
    $address        = $(e.target).parent().find('input[data-address]');
    let addressId   = $address.val();
    $(e.target).parent().fadeOut(150, function () {
        if (addressId > 0) {
            mapEditor.deleteMarker(addressId, $address.data('address'));
        }
        $(this).detach();
    })
}

/**
 * Clear waypoints from map before create new
 * (If it is not cleared, then sometimes a bug occurs, with a click on another marker)
 */
function clearWaypoints() {
    if (mapEditor.markers['waypoints'] !== undefined) {
        for (let i = 0; i < mapEditor.markers['waypoints'].length; i++) {
            mapEditor.markers['waypoints'][i].setMap(null);
        }
    }
    waypoints = [];
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