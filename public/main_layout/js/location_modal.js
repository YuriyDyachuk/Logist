
let modal_opened_from_menu = false;


$(document).ready(function () {
    $('#search-trans')
        .on('input', function () {
            location_map.searchTrans();
        })
        .focusout(function () {
            $('#search-result').css('opacity', 0);
        });
});

$('.modal-close').on('click', function(e) {
    e.preventDefault();
    location_map.closeModal();
});

$( window ).on( 'mouseup', function( e ) {
    location_map.closeAllInfoWindows();
    let status = $('#mapModalCurrent').attr('data-status');
    let click = true;
    if ($(e.target).parents('#locations-filters-list').length !== 0) {
        click = false;
    }

    if ($(e.target).parents('.map-modal').length !== 0 || e.target.className === 'map-modal') {
        click = false;
    }

    if (e.target.id === 'menu-show' || e.target.id === 'menu-close') {
        click = false;
    }

    if(e.target.attributes.src !== undefined && e.target.attributes.src.value === '/main_layout/images/svg/truck-marker-active.svg'){
        click = false;
    }

    if(e.target.className !== undefined && e.target.className === 'gm-control-active'){
        click = false;
    }

    if(status === 'open' && click === true){
        location_map.closeModal();
    }
});

$('#locations .tsearchInput').on('input', function(e) {
    let value = $(this).val();
    if(value.length > 1) {
        let url = 'location/search_data?search=' + value;
        $.ajax({
            url     : url,
            type    : 'GET',
            dataType: 'json',
            success : function (data) {
                location_map.hideTransportsByNumberFilter(data);
                location_map.filterMarkers(data);

                let transport_items = $(location_map.itemTransportSelector).filter(function() {
                    return $(this).css("display") === 'block'
                });

                if (transport_items.length === 0) {
                    $('.transport_item_empty').show();
                } else {
                    $('.transport_item_empty').hide();
                }

                let order_items = $(location_map.itemOrderSelector).filter(function() {
                    return $(this).css("display") === 'block'
                });

                if (order_items.length === 0) {
                    $('.order_item_empty').show();
                } else {
                    $('.order_item_empty').hide();
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    } else {
        $('.transport_item_wrap').show();
        $('.order_item_wrap').show();

        $('.transport_item_empty').hide();
        $('.order_item_empty').hide();
        location_map.showAllMarkers();
    }
});

$('#search-trans').on('input', function(e){
    var number = $(this).val();
    if(number.length > 1){

        var url = 'location/search_number?filters[number]='+number;
        $.ajax({
            url     : url,
            type    : 'GET',
            dataType: 'json',
            success : function (data) {
                if ($('.autocomplete-result').length) {
                    $('.autocomplete-result').remove();
                }

                let list = '<div class="list-group autocomplete-result">';
                $.each(data, function(key, value) {
                    list += '<a href="javascript://" class="list-group-item" data-id='+key+'>'+value+' [ID '+key+']</a>';
                });

                if(data.length == 0){
                    $('#search-trans-val').val(0);
                    list += '<a href="javascript://" class="list-group-item" data-id="0">No result</a>';
                }

                list +=  '</div>';
                $('#search-trans').parent().append(list + '</div>');


                location_map.hideTransportsByNumberFilter(data);
                $('.autocomplete-result a').bind('click', function () {
                    $('#search-trans-val').val($(this).attr('data-id'));
                    if($(this).attr('data-id') == 0) {
                        location_map.deleteAutocompleteResult();
                        $("#search-trans").val('');
                        $("#search-trans-val").val('');
                        location_map.updateMarkers(true);
                    } else {
                        $('#search-trans').val($(this).text());
                        location_map.updateMarkers(true);
                        location_map.deleteAutocompleteResult();
                    }
                });
            },
            error: function (data) {
                console.log(data)
            }
        });
    }
});

$('body').on('blur', '.input-autocomplete', function () {
    location_map.deleteAutocompleteResult();
});

$('body').on('change', '.input-autocomplete', function () {
    location_map.deleteAutocompleteResult();
});

$(".searchclear").click(function(){
    $("#search-trans").val('');
    $("#search-trans-val").val('');
    location_map.updateMarkers(true, true);
});

$('select[name="filters[status]"]').on('change', function(){
    location_map.updateMarkers(true, true);
});

$('select[name="filters[location]"]').on('change', function(){
    location_map.updateMarkers(true, true);
});

$(document).on('click', "#locations #menu-close", function(event) {
    event.preventDefault();
    location_map.hideMenu();
});

$(document).on('click', ".map-wrapper #menu-show", function(event) {
    event.preventDefault();
    location_map.showMenu();
});

// $(document).on('click', location_map.itemTransportSelector + ', ' + location_map.itemOrderSelector, function() {
//     if ($(this).hasClass('active')) {
//         location_map.closeModal();
//         location_map.showAllMapData();
//         $(this).removeClass('active');
//         return;
//     }
//
//     $(location_map.itemTransportSelector + ', ' + location_map.itemOrderSelector).removeClass('active');
//
//     let selectedId = $(this).data('id');
//     $(location_map.itemTransportSelector + '[data-id="'+selectedId+'"]').addClass('active');
//     $(location_map.itemOrderSelector + '[data-id="'+selectedId+'"]').addClass('active');
//     if (!$(this).hasClass('active')) {
//         $(this).addClass('active');
//     }
//
//     location_map.clearPolylinePath();
//     location_map.openModalFromMenu($(this));
//     location_map.resizeModalWindow();
// });

$(document).on('click', '.type_window_current, ' + location_map.itemTransportSelector + ', ' + location_map.itemOrderSelector, function(e) {
    e.preventDefault();

    // console.log(this);
    // console.log(this.className);

    if($('.type_window').is(":visible") && (this.className === 'transport_item_wrap' || this.className === 'transport_item_wrap active')){
        return;
    }

    let selectedId;

    if(this.className === 'type_window_current'){
        selectedId = $(this).parents('.type_window').data('id');
    }

    if(this.className === 'transport_item_wrap' || this.className === 'transport_item_wrap active'){
        selectedId = $(this).data('id');
    }

    location_map.closeModal();
    // location_map.showAllMapData();

    let block = $(location_map.itemTransportSelector + '[data-id="'+selectedId+'"]');

    if (block.hasClass('active')) {
        location_map.closeModal();
        location_map.showAllMapData();
        block.removeClass('active');
        return;
    } else {
        $(location_map.itemTransportSelector).removeClass('active');
        block.addClass('active');
    }

    closeTypeModal();

    location_map.clearPolylinePath();
    location_map.openModalFromMenu(block);
    location_map.resizeModalWindow();
});

$('#formFilters .refresh-locations').click(function() {
    let status = $(this).data('status');
    if (status === 'active') {
        location_map.updateMarkers(true, true);
    }
});

$(document).on({
    mouseenter: function(){
        let id = $(this).data('id');
        let index = location_map.findMarkerIndex(id);
        if (location_map.markers[index] !== undefined) {
            location_map.markers[index].setIcon(({
                url       : location_map.markers[index].icon.url,
                scaledSize: new google.maps.Size(location_map.default_marker_scaled_size, location_map.default_marker_scaled_size)
            }));
        }
    },
    mouseleave: function() {
        let id = $(this).data('id');
        let index = location_map.findMarkerIndex(id);
        if (location_map.markers[index] !== undefined) {
            location_map.markers[index].setIcon(({
                url       : location_map.markers[index].icon.url,
                scaledSize: new google.maps.Size(location_map.default_marker_size, location_map.default_marker_size)
            }));
        }
    }
}, location_map.itemTransportSelector + ', ' + location_map.itemOrderSelector);

$('#locations .tabs a').on('click', function(e){
    e.preventDefault();
    $('#locations .tabs a').removeClass('active');
    $(this).addClass('active');
});

$(function() {

    $('.link_type_window').on('click', function (e) {
        e.preventDefault();

        let windowM = $('.type_window');

        if(windowM.is(":visible")){
            windowM.hide(300, function() {
                windowM.show();
            });
        } else {
            windowM.show();
        }

        let transport_id = $(this).parent('.transport_item_wrap').data('id');
        windowM.data('id', transport_id);

        // let elPosition = $(this).offset();
        // let parentPosition = $(this).parent().offset();
        // let elPositionTop = elPosition.top;
        // //
        // console.log(windowM.data('id'));
        // // console.log(elPositionTop);
        // // console.log(parentPosition.top);
        //
        // let top = elPosition.top - parentPosition.top + 110;

        // console.log(top);

        // windowM.css('top', top );

        // var elPositionLeft = elPosition.left;
    });

    $('.type_window_history').on('click', function(e) {
        e.preventDefault();

        let transport_id = $(this).parents('.type_window').data('id');

        let mapModalRoute = $('#mapModalRoute').show();

        // mapModalRoute.attr('data-status', 'open');
        mapModalRoute.show();
        mapModalRoute.css('left', '0px');

        closeTypeModal();

    });


    $('#getRoute').on('click', function(e) {
        let from = $('#fromRouteDate').val();
        let to = $('#toRouteDate').val();

        $.ajax({
            url: '/location/route',
            type: "post",
            data: {'from' : from, 'to' : to},
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "cache-control": "no-cache, no-store"
            }
        })
        .done( function (data) {
            location_map.drawPolylineHistory(data);
        })
        .fail(function (data) {
        });
    });
});

function closeTypeModal(){
    if($('.type_window').is(":visible")){
        $('.type_window').hide();
    }
}

