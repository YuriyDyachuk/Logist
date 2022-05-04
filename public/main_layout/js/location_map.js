var location_map = {
    default_zoom:6,
    default_center_lat:48.411083,
    default_center_lng:34.987417,
    default_marker_size: 36,
    default_marker_scaled_size: 36,
    displayRoute:true,
    map:null,
    bounds:null,
    directionsDisplay:null,
    polyline_fact:null,
    polyline_before:null,
    polyline_plan:null,
    infoWindows:[],
    markers:[],
    markers_prev:[],
    points:[],
    overlays: [],
    itemTransportSelector: '#locations .transport_item_wrap',
    itemOrderSelector: '#locations .order_item_wrap',
    initMap: function () {
        console.log('Google Maps API version: ' + google.maps.version);
        this.map = new google.maps.Map(document.getElementById('map'), {
            zoom                  : this.default_zoom,
            center                : {lat: this.default_center_lat, lng: this.default_center_lng},
            disableDoubleClickZoom: true,
            mapTypeControl        : true,
            mapTypeId             : 'hybrid'
        });

        location_map.setAllMarkers();
        // location_map.refreshAllMarkers();

        this.polyline_plan = new google.maps.Polyline({
            strokeColor  : '#007cff',
            strokeOpacity: 0.8,
            strokeWeight : 4
        });
        this.polyline_plan.setMap(this.map);

        this.polyline_fact = new google.maps.Polyline({
            geodesic     : true,
            strokeColor  : '#2ecc71',
            strokeOpacity: 0.8,
            strokeWeight : 5
        });
        this.polyline_fact.setMap(this.map);

        let lineSymbol = {
            path: 'M 0,-1 0,1',
            strokeOpacity: 1,
            scale: 4
        };

        this.polyline_before = new google.maps.Polyline({
            geodesic     : true,
            strokeColor  : '#2ecc71',
            strokeOpacity: 0,
            icons: [{
                icon: lineSymbol,
                offset: '0',
                repeat: '20px'
            }]
        });
        this.polyline_before.setMap(this.map);

        google.maps.event.addListener(this.map, 'click', function(event) {
            // global events

            closeTypeModal();
        });

        this.refreshAllMarkers();

    },
    refreshAllMarkers: function () {
        setTimeout( function () {
            console.log('start refresh');
            location_map.updateMarkers(false, undefined, location_map.getSelectedTransportId());
            location_map.refreshAllMarkers();
        }, 20000 );
    },
    setAllMarkers: function (transport_id_only) {
        this.infoWindows = [];
        this.markers     = [];
        let location_map = this;


        if(!transport_id_only)
            location_map.setActiveBlock(transport_id_only);

        Transports.forEach(function (el) {

            if(transport_id_only && el.id !== transport_id_only)
            {
                // stay on map only transport_id_only
                return;
            }

            location_map.setMarker(el);
        });

        if (this.markers.length > 0/* && isBounds === undefined*/) {
            let bounds = new google.maps.LatLngBounds();

            for (let i = 0; i < this.markers.length; i++) {
                bounds.extend(this.markers[i].getPosition());
            }

            this.map.fitBounds(bounds);
        }
    },
    setMarker: function(el) {
        console.log(el);

        if ((el.lng === 0 && el.lat === 0) || (el.lng === null && el.lat === null))
            return;

        let point               = new google.maps.LatLng(el),
            marker              = new google.maps.Marker({map: this.map, position: point});
        let html                = getInfoWindowHtml(el);
        let infoWindow          = new google.maps.InfoWindow({content: html});
        infoWindow.transportId  = el.id;
        let iconName            = this.getDefIcon(el);
        let iconPath            = '/images/svg/location/' + iconName;
        let location_map        = this;

        // default delete icon
        // marker.setMap(null);


        this.infoWindows.push(infoWindow);

        marker.setIcon(({
            url       : iconPath,
            scaledSize: new google.maps.Size(location_map.default_marker_size, location_map.default_marker_size)
        }));

        marker.addListener('click', function () {
            if (typeof window.progressBar === "function") {
                window.progressBar(50);
            }

            let selectedTransportId = location_map.getSelectedTransportId();
            if (selectedTransportId === el.id) {
                $(location_map.itemTransportSelector + ', ' + location_map.itemOrderSelector).removeClass('active');
                location_map.closeModal();
                location_map.showAllMapData();
                if (typeof window.progressBar === "function") {
                    window.progressBar(100);
                }

                return;
            }


            location_map.setActiveBlock(el.id);
            location_map.resizeModalWindow();
            location_map.clearMarkers();
            location_map.showMarker(el);

            let latLng = new google.maps.LatLng(el.lat, el.lng);
            location_map.map.setCenter(latLng);

            if (location_map.directionsDisplay) {
                location_map.directionsDisplay.setMap(null);
            }

            location_map.displayRoute = true;
            location_map.closeAllInfoWindows();
            location_map.clearPolylinePath();
            location_map.routes(el);

            if (typeof window.progressBar === "function") {
                window.progressBar(100);
            }
        });

        marker.addListener('mouseover', function() {
            infoWindow.open(this.map, this);
        });

        marker.addListener('mouseout', function() {
            infoWindow.close();
        });

        google.maps.event.addListener(infoWindow, 'closeclick', function () {
            location_map.displayRoute = false;
            location_map.closeAllInfoWindows();
            location_map.clearPolylinePath();
        });

        marker.transportId = el.id;
        this.markers.push(marker);

        // this.setHtmlIcon(el);
    },
    setHtmlIcon: function(el){
        class USGSOverlay extends google.maps.OverlayView {
            constructor(el) {
                super();
                this.lat = el.lat;
                this.lng = el.lng;
                this.pos = new google.maps.LatLng(el.lat, el.lng);
                this.el = el;
                this.id = el.id;
            }
            /**
             * onAdd is called when the map's panes are ready and the overlay has been
             * added to the map.
             */
            onAdd() {
                this.div = document.createElement("div");
                this.div.style.position='absolute';
                this.div.className = "htmlMarker";

                let engine_on = false;
                let gps_params = false;
                let gpsDivClass = 'not-installed';

                if (this.el.gps_params !== null) {
                    gps_params = true;

                    this.el.gps_params.forEach(function (item, i) {
                        if (item.ioparam_slug == 'engine_speed' && item.ioparam_value > 0) {
                            engine_on = true;
                        }
                    });
                }

                if(gps_params === true && engine_on === true){
                    gpsDivClass = 'engine_on';
                }

                if(gps_params === true && engine_on === false){
                    gpsDivClass = 'engine_off';
                }

                //
                if(gps_params === false && this.el.monitoring == 'gps'){

                    // GLOBUS
                    if(this.el.ignition == 1){
                        gpsDivClass = 'engine_on';
                    }

                    if(this.el.ignition == 0){
                        gpsDivClass = 'engine_off';
                    }
                }

                this.div.innerHTML = '<div class="gps_block gps_' + gpsDivClass + '">' +
                    '<div class="marker_gps marker_gps_' + gpsDivClass + '" style="transform: rotate(' + el.angle + 'deg)"></div>' +
                    '<div class="marker_status marker_status_' + el.status + '" style=""></div>' +
                    '</div>';
                var panes = this.getPanes();
                panes.overlayImage.appendChild(this.div);
                // this.div=div;
            }
            draw() {
                var overlayProjection = this.getProjection();
                var position = overlayProjection.fromLatLngToDivPixel(this.pos);
                var panes = this.getPanes();
                this.div.style.left = position.x - 20  + 'px';
                this.div.style.top = position.y - 36 + 'px';
            }
            /**
             * The onRemove() method will be called automatically from the API if
             * we ever set the overlay's map property to 'null'.
             */
            onRemove() {
                if (this.div) {
                    this.div.parentNode.removeChild(this.div);
                    delete this.div;
                }
            }
        }

        this.overlays[el.id] = new USGSOverlay(el);
        this.overlays[el.id].setMap(this.map);
    },
    getDefIcon: function(el) {
        return 'default.svg';
    },
    getIcon: function(el) {

        // NOT USING!!! OLD VERSION

        let icon = 'no-gps-free.svg';

        let engine_on = false;
        let gps = false;

        if (el.gps_params !== null) {
            gps = true;

            el.gps_params.forEach(function (item, i) {
                if (item.ioparam_slug == 'engine_speed' && item.ioparam_value > 0) {
                    engine_on = true;
                }
            });
        }

        if (el.status === 'on_flight' && gps === false) {
            icon = 'no-gps-on_fligh.svg';
        }


        if (el.status === 'on_flight' && gps === true) {
            if (engine_on === true) {
                icon = 'gps-engine_on-on_flight.svg';
            }
            else {
                icon = 'gps-engine_off-on_flight.svg';
            }
        }

        if (el.status === 'on_flight' && gps === false) {
            icon = 'no-gps-on_repair.svg';
        }

        if (el.status === 'on_repair' && gps === true){
            if (engine_on === null) {
                icon = 'gps-engine_on-on_repair.svg';
            }
            else {
                icon = 'gps-engine_off-on_repair.svg';
            }
        }

        if (el.status === 'free' && gps === true){
            if (engine_on === null) {
                icon = 'gps-engine_on-free.svg';
            }
            else {
                icon = 'gps-engine_off-free.svg';
            }
        }

        return icon;
    },
    resizeModalWindow: function () {
        let map_modal_current = $('#mapModalCurrent');
        let map_modal_width = map_modal_current.width();
        map_modal_current.css('left', '-'+map_modal_width+'px');
        map_modal_current.show();
        map_modal_current.animate({left: '0px'}, 250, function(map_modal_width) {
            map_modal_current.attr('data-status', 'open');
            $('.map-locations').css('margin-left', (map_modal_width)+'px');
        });
    },
    clearMarkers: function(clear_array = false) {

        let i;

        for (i = 0; i < this.markers.length; i++) {
            this.markers[i].setMap(null);
        }

        for (i = 0; i < this.overlays.length; i++) {
            if(typeof this.overlays[i] !== 'undefined'){
                this.overlays[i].setMap(null);
            }
        }

        if (clear_array) {
            this.markers = [];
        }
    },
    showMarker: function(el) {
        let index = this.findMarkerIndex(el.id);
        if (this.markers[index] !== undefined) {
            this.setHtmlIcon(el);
            this.markers[index].setMap(this.map);
        }
    },
    showAllMarkers: function() {
        let location_map = this;
        this.markers.forEach(function(marker){
            marker.setMap(location_map.map)
        })
    },
    closeAllInfoWindows: function() {
        for (let i = 0; i < this.infoWindows.length; i++) {
            this.infoWindows[i].close();
        }
    },
    clearPolylinePath: function() {
        this.clearPoints();
        this.polyline_fact.getPath().clear();
        this.polyline_plan.getPath().clear();
        this.polyline_before.getPath().clear();
    },
    clearPoints: function() {
        for (let i = 0; i < this.points.length; i++) {
            this.points[i].setMap(null);
        }
    },
    routes: function(transport){
        let location_map = this;
        if (transport.order > 0 && transport.status_id != 7/*free*/) {
            let $_info = $(`#info-${transport.id}`);
            $_info.append('<span class="as-loader"></span>');

            $.get(`/ajax/route/${transport.order}`)
                .done( function(data){
                    location_map.syncMarkers(data);

                    if (location_map.displayRoute) {
                        location_map.drawPolyline(data);
                    }

                    location_map.displayRoute = true;
                    if (transport.lat && transport.lng) {
                        let latLng = new google.maps.LatLng(transport.lat, transport.lng);
                        location_map.map.setCenter(latLng);
                    }
                })
                .fail(function (data) {
                    console.warn(data);
                })
                .always(function () {
                    $_info.find('.as-loader').detach()
                });
        }
    },
    syncMarkers: function(data) {
        let location_map = this;
        for (let i = 0; i < data.length; i++) {
            let exists = false;
            for (let j = 0; j < this.markers.length; j++) {
                if (this.markers[j].transportId === data[i].id) {
                    this.markers[j].setIcon({
                        url       : '/images/svg/location/' + this.getDefIcon(data[i]),
                        scaledSize: new google.maps.Size(location_map.default_marker_size, location_map.default_marker_size)
                    });

                    if (!isNaN(data[i].lat) && !isNaN(data[i].lng)) {
                        this.markers[j].setPosition({lat: data[i].lat, lng: data[i].lng});
                        exists = true;
                    }

                    break;
                }
            }

            if (!exists) {
                this.setMarker(data[i]);
            }
        }
    },
    drawPolylineHistory: function(data) {
        this.clearPolylinePath();

        let bounds = new google.maps.LatLngBounds();

        // with cargo
        let path_fact = this.polyline_fact.getPath();

        if(data !== null){
            data.route.forEach(function (item) {
                console.log(item);
                path_fact.push(new google.maps.LatLng(+item.lat, +item.lng));
                bounds.extend(new google.maps.LatLng(+item.lat, +item.lng));
            });
        }

        this.map.fitBounds(bounds);

    },
    drawPolyline: function(data) {
        this.clearPolylinePath();

        let bounds = new google.maps.LatLngBounds();

        // without cargo
        let path_before = this.polyline_before.getPath();
        data.directions_fact.forEach(function (item) {
            if (item[2] === undefined || item[2] === null){
                path_before.push(new google.maps.LatLng(+item[0], +item[1]));
                bounds.extend(new google.maps.LatLng(+item[0], +item[1]));
            }
        });

        // with cargo
        let path_fact = this.polyline_fact.getPath();
        data.directions_fact.forEach(function (item) {
            if (item[2] !== undefined && item[2] !== null && item[2] == 1) {
                path_fact.push(new google.maps.LatLng(+item[0], +item[1]));
                bounds.extend(new google.maps.LatLng(+item[0], +item[1]));
            }
        });

        let path_plan = this.polyline_plan.getPath();
        data.directions_plan.forEach(function (item) {
            path_plan.push(new google.maps.LatLng(+item[0], +item[1]));
            bounds.extend(new google.maps.LatLng(+item[0], +item[1]));
        });

        this.map.fitBounds(bounds);
        this.setMapOnAllPoints(data.addresses);
    },
    setMapOnAllPoints: function(addresses) {
        for (let k = 0; k < addresses.length; k++) {
            if (!addresses[k]) continue;
            let size = (k === 0) || (k === (addresses.length - 1)) ? {w: 26, h: 26} : {w: 20, h: 20},
                color = (addresses[k].type === 'loading') ? 'blue' : 'green',
                point = new google.maps.Marker(
                    {
                        map: this.map,
                        position: {lng: +addresses[k].lng, lat: +addresses[k].lat}
                    }
                );

            point.setIcon({
                url: `/main_layout/images/svg/pin-${color}.svg`,
                scaledSize: new google.maps.Size(size.w, size.h)
            });

            this.points.push(point);
        }
    },
    closeModal: function () {
        this.hideModalAnimation();
        modal_opened_from_menu = false;
    },
    showAllMapData: function() {
        this.closeAllInfoWindows();
        this.clearPolylinePath();
        this.clearMarkers(true);
        this.syncMarkers(Transports);
        this.map.setZoom(this.default_zoom);
        this.map.setCenter({lat:this.default_center_lat, lng:this.default_center_lng});
    },
    findMarkerIndex: function(id) {
        return this.markers.map(function(e) { return e.transportId; }).indexOf(id);
    },
    findWithAttr: function(array, attr, value) {
        for(let i = 0; i < array.length; i += 1) {
            if(array[i][attr] === value) {
                return i;
            }
        }
        return -1;
    },
    hideModalAnimation: function () {

        let map_modal_current;

        if($('#mapModalCurrent').is(":visible")){
            map_modal_current = $('#mapModalCurrent');
        }

        if($('#mapModalRoute').is(":visible")){
            map_modal_current = $('#mapModalRoute');
        }

        if(typeof map_modal_current !== 'undefined'){
            let map_modal_width = map_modal_current.width();
            map_modal_current.animate({left: '-'+map_modal_width+'px'}, 0, function() {
                map_modal_current.hide();
                map_modal_current.attr('data-car', '');
                map_modal_current.attr('data-status', '');
                $('.map-locations').css('margin-left', '0px');
            });

        }

    },
    hideTransportsByNumberFilter: function(data) {
        $( '.transport_item_wrap' ).each(function( index ) {
            let id = $(this).data('id');
            let finedIndex = null;
            let keys = Object.keys(data);
            keys.forEach((element) => {
                if (element == id) {
                    finedIndex = index;
                }
            })

            if (finedIndex === null) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });

        $( '.order_item_wrap' ).each(function( index ) {
            let id = $(this).data('id');
            let finedIndex = null;
            let keys = Object.keys(data);
            keys.forEach((element) => {
                if (element == id) {
                    finedIndex = index;
                }
            })

            if (finedIndex === null) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    },
    deleteAutocompleteResult: function() {
        $('body').find('.autocomplete-result').fadeOut(200, function () {
            $(this).detach();
        });
    },
    updateMarkers: function(refresh, progressBar, onlymarker) {
        let location_map = this;

        if (!onlymarker)
            location_map.disableRefreshButton();

        let form = $('#formFilters').serialize() + '&refresh=' + refresh;
        if(progressBar !== undefined) {
            if (typeof window.progressBar === "function") {
                window.progressBar(50);
            }
        }

        $.ajax({
            url     : '/location?'+ form,
            type    : 'get',
            headers: {
                "cache-control": "no-cache, no-store"
            }})
            .done(function (data) {
                if (!onlymarker) {
                    let status = $('#mapModalCurrent').attr('data-status');
                    if(status === 'open') {
                        location_map.closeModal();
                    }
                } else {

                }

                Transports = data.transports;
                location_map.clearMarkers(true);
                if (Transports.length !== 0) {
                    if (!onlymarker)
                        location_map.clearPolylinePath();

                    location_map.setAllMarkers(onlymarker);
                    location_map.syncMarkers(data.transports);
                }

                if (data.html !== undefined && refresh === true) {
                    $('#locations .tsearchInput').val('')
                    $('#locations .tabs a').removeClass('active');
                    $('#locations .tabs a.default').addClass('active');
                    $('#locations .content-box__body').html(data.html);
                }

                if (!onlymarker && location_map.map.getZoom() > location_map.default_zoom) {
                    location_map.map.setZoom(location_map.default_zoom);
                }
            })
            .fail(function (data) {
                console.warn(data);
            })
            .always(function () {
                if(progressBar !== undefined) {
                    if (typeof window.progressBar === "function") {
                        window.progressBar(100);
                    }
                }
                if (!onlymarker)
                    location_map.enableRefreshButton();
            });
    },
    disableRefreshButton: function() {
        let button = $('#formFilters .refresh-locations');
        button.data('status', 'disabled');
        button.css('background-color', '#C4C4C4');
    },
    enableRefreshButton: function() {
        let button = $('#formFilters .refresh-locations');
        button.data('status', 'active');
        button.css('background-color', '#fff');
    },
    getSelectedTransportId: function() {
        let activeTransport = $(this.itemTransportSelector + '.active');
        if (activeTransport.length > 0 ) {
            return activeTransport.data('id');
        }

        let activeOrder = $(this.itemOrderSelector + '.active');
        if (activeOrder.length > 0 ) {
            return activeOrder.data('id');
        }

        return false;
    },
    searchTrans: function() {
        let val   = $('#search-trans').val(),
            $_box = $('#search-result');

        $_box.css('opacity', 1).html('');
        if (val.trim() === '') return;
    },
    isCorrectLocation: function(el) {
        if ((el.lng === 0 && el.lat === 0) || (el.lng === null && el.lat === null)) {
            return false;
        }

        return true;
    },
    openModalFromMenu: function (block) {
        let id = block.data('id');
        let transportIndex = this.findWithAttr(Transports, 'id', id);
        let el = Transports[transportIndex];
        if (el !== undefined) {
            modalUpdate(el);

            let map_modal_current = $('#mapModalCurrent');

            map_modal_current.attr('data-status', 'open');
            map_modal_current.show();
            map_modal_current.css('left', '0px');
            this.clearMarkers();

            if (!this.isCorrectLocation(el)) {
                let latLng = new google.maps.LatLng(this.default_center_lat, this.default_center_lng);
                this.map.setZoom(this.default_zoom);
                this.map.setCenter(latLng);
                return;
            }

            this.setMarker(el);
            this.displayRoute = true;

            if (this.directionsDisplay) {
                this.directionsDisplay.setMap(null);
            }
            this.routes(el);
            let latLng = new google.maps.LatLng(el.lat, el.lng);
            this.map.setCenter(latLng);
            modal_opened_from_menu = true;
        } else {
            appAlert('', 'Something went wrong... :(', 'warning');
        }
    },
    filterMarkers: function (data) {
        this.clearMarkers();
        this.clearPolylinePath();
        let location_map = this;
        Object.entries(data).forEach(entry => {
            let key = parseInt(entry[0]);
            let index = location_map.findMarkerIndex(key);
            if (location_map.markers[index] !== undefined) {
                location_map.markers[index].setMap(location_map.map);
            }
        });
    },
    setActiveBlock: function (id) {
        let wrap = $('#locations');
        wrap.find('.transport_item_wrap').removeClass('active');
        wrap.find('.order_item_wrap').removeClass('active');
        wrap.find('.order_item_wrap[data-id="' + id + '"]').addClass('active');

        let activeBlock =  wrap.find('.transport_item_wrap[data-id="' + id + '"]');
        activeBlock.addClass('active');

        // console.log(activeBlock.offset().top);
        //
        // $(wrap).animate({
        //     scrollTop: activeBlock.offset().top
        // }, 2000);
    },
    hideMenu: function () {
        $('#locations-filters-list').hide();
        $('#locations-map').css('margin-left', '0px');
        $('#menu-show').show();
    },
    showMenu: function () {
        $('#locations-filters-list').show();
        let menuWidth = $('#locations-filters-list').width();
        $('#locations-map').css('margin-left', menuWidth + 'px');
        $('#menu-show').hide();
    }
}