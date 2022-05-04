/**
 * Created by CrossRoad on 22.06.2017.
 */
$( window ).ready( function () {

    /* notifications start */
    var innerHeight = 0;
    $('.notifications ul .list-group-item').each(function() {
        innerHeight += $(this).outerHeight();
    });

    var outerHeight = $(window).height()*2/3;
    var finalHeight;

    if(innerHeight > outerHeight){
        finalHeight = outerHeight;
    } else {
        finalHeight = innerHeight;
    }
    $('.notifications').height(finalHeight+32);

    /* notifications end */

    window.completedAjax = true;
    window.appLoading = false;

    mobileRemoveClass( 'body', 'is-collapsed', 'sidebar_collapsed' );
    $( window ).resize( function () {
        mobileRemoveClass( 'body', 'is-collapsed', 'sidebar_collapsed' );
    } );

    /**
     * Remove class for mobile device
     *
     * @param elm
     * @param cls
     * @param str
     */
    function mobileRemoveClass ( elm,  cls, str ) {
        var w = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        if ( w <= 979 && $( elm ).hasClass( cls ) && localStorage.getItem( str ) == 'false'  ) {
            $( elm ).removeClass( cls );
        } else if ( w > 979 && localStorage.getItem( str ) != 'false'  && ! $( elm ).hasClass( cls ) ) {
            $( elm ).addClass( cls );
        }
    }

    swal.setDefaults( {
        confirmButtonClass : 'button-green',
        cancelButtonClass : 'button-cancel',
        cancelButtonText : sa2_btn_cancel,
        reverseButtons : true,
        customClass : 'my-alert animated zoomIn',
        animation : false,
    } );

    $.notifyDefaults( {
        delay : 1000,
        type : 'success',
        placement : {
            from : "top",
            align : "right"
        },
        animate : {
            enter : "animated fadeInRight",
            exit : "animated fadeOutRight"
        },
        offset : { y : 80, x : 15 }
    } );

    window.appAlert = function ( text, title, type ) {
        swal( text, title, type );
    };

    window.appConfirm = function ( title, text, type, callback ) {
        swal( {
            title : title,
            text : text,
            type : type,
            showCancelButton : true,
            cancelButtonText : sa2_btn_cancel
        } ).then( function () {
            callback();
        } ).catch( swal.noop )
    }

    window.btnLoader = function ( btn ) {
        if ( btn === 'hide' || btn === null ) $( '.spinner' ).detach();

        var html =
            '<div class="spinner">' +
            '<div class="bounce1"></div>' +
            '<div class="bounce2"></div>' +
            '<div class="bounce3"></div>' +
            '</div>';

        $( btn ).css( {
            position : 'relative',
            width : $( btn ).outerWidth(),
            height : $( btn ).outerHeight()
        } ).append( html );
    };

    // PROGRESS BAR
    window.progressBar = function ( width ) {
        var $bar = $( '.app-progress-bar .progress-bar' ),
            duration = 1000;

        $bar.parent().next().css( { opacity : 0.2, filter : 'grayscale(1)', '-webkit-filter' : 'grayscale(1)' } );

        if ( width === 100 ) {
            $bar.stop();
            duration = 400;
        }

        $bar.animate( { width : width + '%' }, duration, function () {
            if ( width === 100 ) {
                $bar.css( 'width', 0 )
                .parent().next().css( { opacity : 1, filter : 'none', '-webkit-filter' : 'none' } );
            }
        } );
    };

    window.appLoader = function ( element ) {
        var html, container, position;

        if ( element === false ) {
            return $( '.spinner-wrapper' ).detach();
        }

        container = element || 'body';
        position = container === 'body' ? 'fixed' : 'absolute';
        html = '<div class="spinner-wrapper spinner" style="position: ' + position + '"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';

        $( container ).append( html );
    };

    window.appSelectpiker = {
        loader : function ( $select ) {
            if ( $select === 'hide' || $select === false ) {
                $( '.loader-select' )
                .siblings( '.dropdown-menu.inner' ).css( 'opacity', 1 ).end()
                .detach();
                return;
            }

            $select.siblings( '.dropdown-menu.open' )
            .children( '.dropdown-menu.inner' ).css( 'opacity', 0 ).end()
            .append( '<span class="as-loader loader-select"></span>' );
        }
    };

    window.appDelay = ( function () {
        let timer = 0;
        return function ( callback, ms ) {
            clearTimeout( timer );
            timer = setTimeout( callback, ms );
        };
    } )();

    var sp_count = 0;

    function validateEmail ( email ) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test( email );
    }

    // AJAX SETTINGS
    $.ajaxSetup( {
        headers : {
            'X-CSRF-TOKEN' : $( 'meta[name="csrf-token"]' ).attr( 'content' )
        }
    } );
    $( document )
    .ajaxStart( function () {
        window.completedAjax = false;
    } )
    .ajaxStop( function () {
        window.completedAjax = true;
    } );

    window.CSRF_TOKEN = $( 'meta[name="csrf-token"]' ).attr( 'content' );

    // Set up default data for jQuery-driven AJAX requests.
    /*
     $.ajaxPrefilter(function(options, originalOptions, jqXHR){
     if (options.type.toLowerCase() === "post") {
     options.data = options.data || "";
     options.data += options.data?"&":"";
     options.data += "_token=" + CSRF_TOKEN;
     }
     });
     */

    $( ".delete_employer" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        console.log( url );
        var el = $( this );

        $.ajax( {
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success : function ( data ) {
                if ( data['result'] == true ) {
                    el.parent().parent().parent().remove();
                } else {
                    appAlert( data['msg'], '' );
                }
            }
        } );
    } );

    $( ".phone_activate_btn" ).click( function ( e ) {
        e.preventDefault();
        var isValid = $( "#phone" ).intlTelInput( "isValidNumber" );
        if ( isValid ) {
            var url = $( this ).attr( 'href' );
            var phone = $( "#phone" ).val();
            $.ajax( {
                url : url,
                type : 'POST',
                data : { _token : CSRF_TOKEN, phone : phone },
                dataType : 'JSON',
                success : function ( data ) {
                    if ( data['result'] == true ) {
                        $( ".phone_activation" ).removeClass( 'hidden' );
                    } else {
                        appAlert( data['msg'], '' );
                    }
                },
                error : function ( data ) {
                    console.log( data );
                }
            } );
        } else {
            appAlert( 'Wrong phone', '' );
        }
    } );

    $( ".send_again_sms_popup" ).click( function ( e ) {
        e.preventDefault();
        var isValid = $( "#phone_2" ).intlTelInput( "isValidNumber" );
        if ( isValid ) {
            var url = $( this ).attr( 'href' );
            var phone = $( "#phone_2" ).val();
            $.ajax( {
                url : url,
                type : 'POST',
                data : { _token : CSRF_TOKEN, phone : phone },
                dataType : 'JSON',
                success : function ( data ) {
                    if ( data['result'] == true ) {
                        $( '#phone' ).val( phone );
                        $( '#sms_again' ).modal( 'hide' );
                    } else {
                        appAlert( data['msg'], '' );
                    }
                },
                error : function ( data ) {
                }
            } );
        } else {
            appAlert( 'Wrong phone', '' );
        }

    } );

    $( ".phone_code_btn" ).click( function ( e ) {
        e.preventDefault();
        var isValid = $( "#phone" ).intlTelInput( "isValidNumber" );
        if ( isValid ) {
            var url = $( this ).attr( 'href' );
            var phone = $( "#phone" ).val();
            var code = $( "#code_activate_input" ).val();
            $.ajax( {
                url : url,
                type : 'POST',
                data : { _token : CSRF_TOKEN, phone : phone, code : code },
                dataType : 'JSON',
                success : function ( data ) {
                    if ( data['result'] == true ) {
                        $( '.phone_activate_btn' ).hide();
                        $( ".phone_activation" ).hide();
                        appAlert( data['msg'], '' );
                    } else {
                        appAlert( data['msg'], '' );
                    }
                },
                error : function ( data ) {
                }
            } );
        } else {
            appAlert( 'Wrong phone', '' );
        }
    } );

    /** Event show/hidden all services */
    $('.btn-notification').on('click', function (event) {
        var id   = $(this).attr('data-notification');
        var href = $(this).attr('href');
        var block = $(this).parents('.list-group-item');
        // var wrapper = $(this).parent('.dropdown');

        event.preventDefault();
        event.stopPropagation();

        if (id) {
            $.ajax({
                       url     : '/notification/' + id,
                       type    : 'DELETE',
                       data    : {_token: CSRF_TOKEN},
                       dataType: 'JSON',

                       success: function (data) {
                           if (data['status'] === 'success' && href !== '') {
                               window.location.href = href.toString();
                           }

                           if (data['status'] === 'success' && href === '') {
                               block.hide('slow');
                           }
                       },
                       error  : function (data) {
                           if (data.status === 404){
                               block.hide('slow');
                           }
                           else {
                               appAlert('Something went wrong!', 'Error');
                           }
                       }
                   });
        } else {
            appAlert( 'Notification not found', 'Error' );
        }

    });

    $('.notifications button[type=submit]').on('click', function (event){
        event.preventDefault();

        var form = $(this).parents('form').serialize();
        var form_url = $(this).parents('form').attr('action');
        var block = $(this).parents('.list-group-item');

        btnLoader($(this));

        $.ajax({
            url     : form_url,
            type    : 'post',
            data    : form,
            success: function (data) {
                if (data['status'] === 'OK') {
                    block.hide('slow');
                    btnLoader('hide');
                }
            },
            error  : function (data) {
                btnLoader('hide');
                appAlert('Something went wrong!', 'Error');
            }
        });
    });


    function ValidateCreditCardNumber ( ccNum ) {

        var visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
        var mastercardRegEx = /^(?:5[1-5][0-9]{14})$/;
        var amexpRegEx = /^(?:3[47][0-9]{13})$/;
        var discovRegEx = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
        var isValid = false;

        if ( visaRegEx.test( ccNum ) ) {
            isValid = true;
        } else if ( mastercardRegEx.test( ccNum ) ) {
            isValid = true;
        } else if ( amexpRegEx.test( ccNum ) ) {
            isValid = true;
        } else if ( amexpRegEx.test( ccNum ) ) {
            isValid = true;
        }

        if ( isValid ) {
            return true;
        } else {
            return false;
        }
    }

    $( ".btn_remove_ccard" ).click( function ( e ) {
        e.preventDefault();
        var id = $( this ).attr( 'cid' );
        var url = $( this ).attr( 'href' );
        var data = { _token : CSRF_TOKEN, id : id };
        $.ajax( {
            url : url,
            type : 'POST',
            data : data,
            dataType : 'JSON',
            success : function ( data ) {
                if ( data['result'] == true ) {
                    window.location.reload();
                } else {
                    appAlert( data['msg'], '' );
                }
            },
            error : function ( data ) {
            }
        } );
    } );

    $( ".phone_sms_again" ).click( function ( e ) {
        e.preventDefault();
        $( '#sms_again' ).modal( 'show' );
    } );

    $( ".update_cc_ajax" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        var id = $( this ).attr( 'cid' );
        var n = $( '#updateCcard .cn_new' ).val();
        var em = $( '#updateCcard .em_new' ).val();
        var ey = $( '#updateCcard .ey_new' ).val();
        var cvv = $( '#updateCcard .cvv_new' ).val();

        var valid = ValidateCreditCardNumber( n );

        if ( n.length > 6 && em.length > 1 && ey.length > 1 && cvv > 2 && valid ) {
            var data = { _token : CSRF_TOKEN, n : n, em : em, ey : ey, cvv : cvv, id : id };
            $.ajax( {
                url : url,
                type : 'POST',
                data : data,
                dataType : 'JSON',
                success : function ( data ) {
                    if ( data['result'] == true ) {
                        window.location.reload();
                    } else {
                        appAlert( data['msg'], '' );
                    }
                },
                error : function ( data ) {
                }
            } );
        } else {
            appAlert( 'Wrong credit card data', '' )
        }

    } );

    $( ".reactivate_email" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        var data = { _token : CSRF_TOKEN };
        $.ajax( {
            url : url,
            type : 'POST',
            data : data,
            dataType : 'JSON',
            success : function ( data ) {
                if ( data['result'] == true )
                    appAlert( data['msg'], '' );
                else
                    appAlert( data['msg'], '' );
            },
            error : function ( data ) {
            }
        } );
    } );

    function parse_tree ( items ) {
        var h = '';
        items.forEach( function ( a, i, arr ) {
            h += '<optgroup label="' + a['name'] + '">';
            a['sp'].forEach( function ( b, j, arr ) {
                h += '<option value="' + b["route"] + '">' + b["name"] + '</option>';
            } );

            if ( a['tree'].length > 0 ) {
                h += parse_tree( a['tree'] );
            }

            h += '</optgroup>';

        } );

        return h;
    }

    function build_selectbox_sp ( items ) {
        var html =
            '<div class="row form-group" style="display: none">' +
            '<div class="col-xs-12">' +
            '<div class="input-group">' +
            '<select name="sp" class="title-grey form-control">' +
            '<option selected disabled>Select Specialization</option>' +
            createOptions( items ) +
            '</select>' +
            '<span class="input-group-addon btn_remove_spec"><i class="fa fa-times fa-fw"></i></span>' +
            '</div>' +
            '</div> ' +
            '</div>';

        return html;
    }

    function createOptions ( items ) {
        var html = '';
        items.forEach( function ( item ) {
            html += '<option value="' + item.id + '">' + item.name + '</option>';
        } );

        return html;
    }

    $( ".save_specializations" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        var spId = [];

        $( ".spsecialization_list [name='sp']" ).each( function ( index ) {
            spId.push( $( this ).find( 'option:selected' ).val() );
        } );

        if ( spId.length ) {
            var data = { _token : CSRF_TOKEN, sp : spId };

            $.ajax( {
                url : url,
                type : 'POST',
                data : data,
                dataType : 'JSON',
                success : function ( data ) {
                    console.log( data );
                    if ( data['result'] ) {
                        window.location.reload();
                    } else {
                        appAlert( 'Try again later...', 'error...' );
                    }
                },
                error : function ( data ) {
                }
            } );
        }
    } );

    $( ".add_specialization" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        var data = { _token : CSRF_TOKEN };
        $.ajax( {
            url : url,
            type : 'POST',
            data : data,
            dataType : 'JSON',
            success : function ( data ) {
                if ( data['result'] == true ) {
                    var r = build_selectbox_sp( data['data'] );

                    $( '.spsecialization_list' ).append( r );
                    $( '.spsecialization_list .form-group' ).last().show( 300 );
                } else {
                    appAlert( 'Try again later...', 'error...' );
                }
            },
            error : function ( data ) {
            }
        } );
    } );

    $( document ).on( "click", ".btn_remove_spec_item", function ( e ) {
        e.preventDefault();
        $( this ).parent().parent().remove();
    } );

    $( document ).on( "click", ".btn_remove_spec", function ( e ) {
        e.preventDefault();
        $( this ).parents( '.form-group' ).hide( 300, function () {
            $( this ).remove();
        } );
    } );

    $( ".add_cc_ajax" ).click( function ( e ) {
        e.preventDefault();
        var url = $( this ).attr( 'href' );
        var n = $( '#createCcard .cn_new' ).val();
        var em = $( '#createCcard .em_new' ).val();
        var ey = $( '#createCcard .ey_new' ).val();
        var cvv = $( '#createCcard .cvv_new' ).val();

        var valid = ValidateCreditCardNumber( n );
        if ( n.length > 6 && em.length > 1 && ey.length > 1 && cvv > 2 && valid ) {
            var data = { _token : CSRF_TOKEN, n : n, em : em, ey : ey, cvv : cvv };
            $.ajax( {
                url : url,
                type : 'POST',
                data : data,
                dataType : 'JSON',
                success : function ( data ) {
                    if ( data['result'] == true ) {
                        window.location.reload();
                    } else {
                        appAlert( data['msg'], '' );
                    }
                },
                error : function ( data ) {
                }
            } );
        } else {
            appAlert( 'Wrong credit card data', '' )
        }
    } );

    $( ".register_1" ).click( function ( e ) {
        e.preventDefault();
        var isValid = $( ".phone_1" ).intlTelInput( "isValidNumber" );
        if ( isValid ) {
            $( '.register_form_1' ).submit();
        } else {
            alert( 'Phone is not valid' );
        }
    } );

    $( ".register_2" ).click( function ( e ) {
        e.preventDefault();
        var isValid = $( ".phone_2" ).intlTelInput( "isValidNumber" );
        console.log( isValid );
        if ( isValid ) {
            $( '.register_form_2' ).submit();
        } else {
            alert( 'Phone is not valid' );
        }
    } );

    $( '[loader-btn]' ).click( function () {
        btnLoader( $( this ) );
    } );

    // MASKS FOR INPUT
    $( '.money' ).mask( "###0.00", { reverse : true } );
    $( '.date' ).mask( '00/00/0000' );
    $( '.number' ).mask( '000000000' );

    // $( '.datetimepicker' ).datetimepicker( {
    //     useCurrent : false,
    //     locale : 'en',
    //     format : 'DD/MM/YYYY',
    //     disabledHours : [],
    //     // debug:true
    // } );
    //
    // $( '.datetimepickerTime' ).datetimepicker( {
    //     useCurrent : false,
    //     locale : 'ru',
    //     format : 'DD/MM/YYYY HH:mm',
    //     // collapse   : true,
    //     // debug:true
    // } );

    // Autocomplete
    $( 'body' ).on( 'input', '.autocomplete', function () {
        let $_this = $( this );
        deleteAutocompleteResult();
        window.appDelay( function () {
            if ( !window.appLoading )
                autocomplete( $_this );
        }, 800 );
    } );
    $( 'body' ).on( 'blur', '.autocomplete', function () {
        deleteAutocompleteResult()
    } );
    $( 'body' ).on( 'change', '.autocomplete', function () {
        deleteAutocompleteResult()
    } );

    function deleteAutocompleteResult () {
        $( 'body' ).find( '.autocomplete-result' ).fadeOut( 200, function () {
            $( this ).detach();
        } );
    }

    function autocomplete ( $_this ) {
        let input = $_this.val().trim();

        if ( input ) {
            $_this.parent().css( 'position', 'relative' );
            autocompleteLoader( $_this );
            $.get( '/address/autocomplete', { input : input } )
            .done( ( data ) => {
                if ( data.status === 'OK' ) {
                    let list = '<div class="list-group autocomplete-result">';

                    if ( data.predictions !== undefined ) {
                        data.predictions.forEach( function ( item ) {
                            list += `<a href="javascript://" class="list-group-item" data-place="${ item.place_id }">${ item.description }</a>`;
                        } );
                    }

                    if ( data.results !== undefined ) {
                        data.results.forEach( function ( item ) {
                            list += `<a href="javascript://" class="list-group-item" data-place="${ item.place_id }">${ item.formatted_address }</a>`;
                        } );
                    }


                    $_this.parent().append( list + '</div>' );
                }

                $( '.autocomplete-result a' ).bind( 'click', function () {
                    let $_parent = $( this ).parent();
                    $_parent.siblings( 'input.autocomplete' ).val( $( this ).text() );
                } )
            } )
            .always( () => autocompleteLoader( null ) );
        }
    }

    function autocompleteLoader ( $_this ) {
        if ( $_this === null ) {
            $( 'body' ).find( '.as-loader' ).detach();
            window.appLoading = false;
            return;
        }
        window.appLoading = true;
        $_this.parent().append( '<span class="as-loader"></span>' )
    }

    if ( typeof euCookieLawPopup == 'function' ) {
        $( document ).euCookieLawPopup().init( {
            cookiePolicyUrl : '/?cookie-policy',
            popupPosition : 'top',
            colorStyle : 'default',
            compactStyle : false,
            popupTitle : '',
            popupText : '',
            buttonContinueTitle : 'Continue',
            buttonLearnmoreTitle : 'Learn more',
            buttonLearnmoreOpenInNewWindow : true,
            agreementExpiresInDays : 30,
            autoAcceptCookiePolicy : false,
            htmlMarkup : $( '#cookie-warning' ).html()
        } );
    }

    function nextInput ( el, e ) {

        if ( e.keyCode == 13 ) {
            var $inputs = $( el ).parents( "form" ).find( "input, .next-tab" );
            var idx = $inputs.index( el );

            if ( idx == $inputs.length - 1 ) {
                var next_index = 0
            } else {
                var next_index = idx + 1;
            }

            if ( $inputs[next_index].tagName == 'INPUT' ) {
                var type = $inputs.eq( next_index ).attr( 'type' );
                if ( type == 'hidden' || type == 'radio' ) {
                    nextInput( $inputs.get( next_index ), e );
                }
                $inputs[next_index].select();
                $inputs[next_index].focus();
            }

            if ( $inputs[next_index].tagName == 'A' ) {

                $( 'html, body' ).animate( {
                    scrollTop : $inputs.eq( next_index ).offset().top
                }, 1000 );
            }

            return false;
        }
    }

    function set_helper ( helper, callback ) {
        var url = helper_url + '/' + helper;
        $.ajax( {
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success : function ( data ) {
                if ( data['result'] == true ) {
                    callback();
                } else {
                    appAlert( data['msg'], '' );
                }
            }
        } );
    }

    $( 'input' ).on( "keydown", function ( e ) {
        nextInput( this, e );
    } );

    if ( typeof helpers['faq'] == 'undefined' ) {
        $( '.faq-tooltip' ).popover( {
            container : $( '#app' ),
            html : true,
            placement : 'auto right',
            title : $( '.faq-tooltip' ).data( 'title' ),
            content : '<div style="width: 230px">' + $( '.faq-tooltip' ).data( 'body' ) + '</div>',
            trigger : 'hover'
        } );

        $( '.faq-tooltip' ).click( function () {
            if ( typeof helpers['faq'] == 'undefined' ) {
                set_helper( 'faq', function () {
                    helpers['faq'] = 1;
                    $( '.faq-tooltip' ).popover( 'disable' );
                } )
            }
        } );
    }

    // Close all opened element
    $( document ).click( function ( e ) {
        let elm = $( e.target );
        if ( elm.is( '.is-open' ) || elm.parents( '.is-open' ).length > 0 ) {
            return false;
        }
        $( '.is-open' ).removeClass( 'is-open' );
    } );

    // Top page scroll
    var btn = $( '#scrollTop' ),
        h = window.innerHeight
        || document.documentElement.clientHeight
        || document.body.clientHeight;

    if ( $( window ).scrollTop() > h/2 ) {
        btn.removeClass( 'hidden' );
    } else {
        btn.addClass( 'hidden' );
    }

    $( window ).scroll( function () {
        if ( $( window ).scrollTop() > h/2 ) {
            btn.removeClass( 'hidden' );
        } else {
            btn.addClass( 'hidden' );
        }
    } );

    btn.on( 'click', function ( e ) {
        e.preventDefault();
        $( 'html, body' ).animate( { scrollTop : 0 }, 500 );
    } );

    // Filter form clearing
    $( 'form' ).on( 'click', '.clear-form', function() {
        let f = $( this ).parents( 'form' ).attr( 'id' ),
            select = $( this ).parents( 'form' ).find( 'select' );

        document.getElementById( f ).reset();

        select.each( function() {
            $( this ).selectpicker( 'refresh' );
        } );

        if ( typeof filters == 'function' ) {
            filters();
        }
    } );

    // Dragscroll initial
    var w = window.innerWidth
        || document.documentElement.clientWidth
        || document.body.clientWidth;

    if ( w >= 650 ) {

        $( '*[data-class="dragscroll"]' ).each( function () {
            $( this ).addClass( 'dragscroll' );
            dragscroll.reset()
        } )
    }

    // Dragscroll convert to dropdown
    window.addEventListener('resize', function() {
        var w = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth,
            d = $( '*[data-class="dragscroll"]' );

        d.each( function () {
            if ( w >= 650 ) {
              $( this ).addClass( 'dragscroll' );
            } else {
                $( this ).removeClass( 'dragscroll' );
            }
        } )

        dragscroll.reset()
    });

    // Tab convert to dropdown
    $( '#rowTab a, #rowTab2 a' ).click( function ( e ) {
        e.preventDefault();

        var type = $( this ).data( 'url' );
        var href = $( this ).attr( 'href' );
        var id = href.substr( 1 ),
            ds = $( this ).parents( '.dragscroll' );

        if( type  !== undefined ){
            window.location.replace(href);
            return;
        }

        if ( ds.length > 0 ) {
            // Dragscroll tab - skip
        } else {

            if ( typeof ( id ) != 'undefined' ) {
                window.location.hash = id;
            }
            $( this ).tab( 'show' );
        }
    } );
    $( '#rowTab li, #rowTab2 li' ).click( function () {
        var w  = document.documentElement.clientWidth
                || document.body.clientWidth;

        if ( w <= 650 ) {
            // Dropdown menu open or close
            $( this ).parents( '.tablist' ).toggleClass( 'is-open' );
            // DropDown menu initial
            $( this ).parents( '.tablist' ).find( '.active' ).removeClass( 'active' );
            $( this ).addClass( 'active' ).prependTo( $( this ).parent() );
            return false;
        }
    } );

    // Filter reset
    $( '[data-order-filter]' ).click( function () {
        $( '#formFilters' )[0].reset();
        $( '#filter-status' ).prop( 'selectedIndex', 0 ).selectpicker( 'refresh' );
        $( '#filter-specialization' ).prop( 'selectedIndex', 0 ).selectpicker( 'refresh' );
        select( this );
    } );


    /*
    // Dragscroll convert to dropdown
    $( '.tablist' ).on( 'click', '.active a', function( event ) {
        var w = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        if ( w <= 767 ) {
            // Disable Toggle orders/requests
            event.preventDefault();

            $( this ).parents( '.tablist' ).toggleClass( 'is-open' );

            return false;
        } else {
            // Toggle orders/requests
            $('[data-order-filter]').click(function () {
                $('#formFilters')[0].reset();
                $('#filter-status').prop('selectedIndex',0).selectpicker('refresh');
                $('#filter-specialization').prop('selectedIndex',0).selectpicker('refresh');
                select(this);
            });
        }
    } );

    $( '.tablist' ).on( 'click', 'li:not(.active) a', function() {
        var w = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;


        if ( w <= 767 ) {
            // DropDown menu initial
            if ( $( this ).hasClass( 'active' ) || $( this ).parents( 'li' ).hasClass( 'active' ) ) {
                $( this ).parents( '.tablist' ).toggleClass( 'is-open' );
            } else {
                $( this ).parents( '.tablist' ).find( '.active' ).removeClass( 'active' );
                if ( $( this ).parent( 'li' ).length > 0 ) {
                    $( this ).parent( 'li' ).addClass( 'active' ).prependTo( $( this ).parents( '.tablist' ) );
                } else {
                    $( this ).addClass( 'active' ).prependTo( $( this ).parent() );
                }
            }

            return false;
        }
    } );
*/
} );