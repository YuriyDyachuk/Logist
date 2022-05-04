$( document ).ready( function () {

    /**
     * Initial select
     */
    $( '.selectpicker' ).selectpicker();

    /**
     * Initialing review slider
     */
    var swiper = new Swiper( '.swiper-container', {
        pagination : {
            el : '.swiper-pagination',
            clickable : true
        },
    } );

    /**
     * Submit register form
     */
    $( '.contact-form__text-fieldset' ).on( 'click', 'button[type="submit"]', function ( event ) {
        event.preventDefault();
        var field = $( this ).siblings( 'input[name="from"]' ),
            val = {};

        field.each( function () {
            if ( validationForm( $( this ) ) ) {
                val[$( this ).attr( 'name' )] = $( this ).val();
            } else {
                val.error = 1;
            }
        } );

        if ( val.error ) {
            return false;
        } else {
            $( this ).parents( 'form' ).submit();
        }
    } );

    /**
     * Search form
     */
    $( '.header-block__text-fieldset' ).on( 'click', 'button[type="submit"]', function ( event ) {
        event.preventDefault();
        var field = $( this ).parent().find( 'select' ),
            val = {};

        field.each( function () {
            if ( validationForm( $( this ) ) ) {
                val[$( this ).attr( 'name' )] = $( this ).val();
            } else {
                val.error = 1;
            }
        } );

        if ( val.error ) {
            return false;
        } else {
            $( this ).parents( 'form' ).submit();
        }
    } );

    /**
     * Submit pop-up form
     */
    $( '#modal-send' ).on( 'click', function ( event ) {
        event.preventDefault();
        var field = $( this ).parents( '.form-feedback' ).find( 'input:not([type=submit]), textarea' ),
            val = {};

        field.each( function () {
            $( this ).parents( '.error' ).removeClass( 'error' );
            if ( validationForm( $( this ) ) ) {
                val[$( this ).attr( 'name' )] = $( this ).val();
            } else {
                val.error = 1;
            }
        } );

        if ( val.error ) {
            return false;
        } else {
            $.ajax( {
                type : 'POST',
                url : '/feedback',
                data : val,
                success : function ( data, status ) {
                    if ( data.status === 'success' ) {
                        $( '.form-feedback' ).addClass( 'hidden' );
                        $( '.correct-send' ).removeClass( 'hidden' );
                    }
                }
            } )
            .fail( function ( data ) {
                if ( data.status === 422 ) {
                    var $form = $( '.form-feedback' ),
                        errors = data.responseJSON;

                    $form.find( '.error' ).removeClass( 'error' );

                    for ( let error in errors ) {
                        let $input = $form.find( '[name="' + error + '"]' );

                        $input.parent().addClass( 'error' );
                        $input.siblings( '.modal-error' ).text( errors[error][0] );
                    }
                }
            } );
        }
    } );

    /**
     * Autosize textarea
     */
    var textarea = document.querySelector( 'textarea' );

    textarea.addEventListener( 'keydown', autosize );

    function autosize () {
        var el = this;
        setTimeout( function () {
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }, 0 );
    }

    $.ajaxSetup( {
        headers : {
            'X-CSRF-TOKEN' : $( 'meta[name="csrf-token"]' ).attr( 'content' )
        }
    } );

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
} );

/**
 * Form validation
 *
 * @param el
 * @returns {*}
 */
function validationForm ( el ) {

    var regex  = {
            of      : /^[\w]{3,}$/i,
            to      : /^[\w]{3,}$/i,
            name    : /^[\w]{3,}$/i,
            subject : /^[\w]{3,}$/i,
            email   : /^[\w.+-]+@[\w-]+.([\w-]+.)?[a-z]{2,4}$/gi,
            from    : /^([\w.+-]+@[\w-]+.([\w-]+.)?[a-z]{2,4})|([+]?[\d]+([\s(]+)?[\d]+([\s)]+)?[\d\s\-]{7,9})$/gi,
            message : /^[\w]{3,}$/i,
            phone   : /^[+]?[\d]+([\s(]+)?[\d]+([\s)]+)?[\d\s\-]{7,9}$/
        },
        title  = $( el ).attr( 'name' ),
        value  = $( el ).val(),
        result = regex[title].test( value );

    if ( ! result ) {
        $( el ).parent().addClass( 'error' );
    }

    return result;
}