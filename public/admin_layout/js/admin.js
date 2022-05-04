/**
 * Created by CrossRoad on 04.04.2017.
 */
$( document ).ready(function() {

    $( '.carthumb' ).click( function() {
        var clc_img = jQuery( this ).html();
        jQuery( '#carthumb a' ).removeClass( 'active' );
        jQuery( this ).addClass( 'active' );

        var el = jQuery(this).parent().parent().find( '#carimage' );
        el.fadeTo( 400, 0.0001, function() {
            el.html( clc_img ).fadeTo( 400, 1 );
        } );
    });

    function my_alert(text, title)
    {
        alert(text);
    }

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $( ".admin_user_update" ).click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var rel = $(this).attr('rel');

        $.ajax({
            url: url,
            type: 'POST',
            data: {_token: CSRF_TOKEN, a:rel},
            dataType: 'JSON',
            success: function (data) {
                if (data['result'] == true) {
                    window.location = data['redirect'];
                }
                else {
                    my_alert(data['msg'], '');
                }
            },
            error: function (data) {
            }
        });
    });

    $( ".admining_list h2" ).click(function(e) {
        e.preventDefault();
        var el = $(this).parent();
        el.find('table').toggle(400);
    });



});
