$(document).ready(function () {

    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

    window.btnLoader = function (btn) {
        if (btn === 'hide') {
            $('.spinner').parent().attr('disabled', false);
            $('.spinner').detach();
        }

        var html =
                '<div class="spinner">\n' +
                '<div class="bounce1"></div>\n' +
                '<div class="bounce2"></div>\n' +
                '<div class="bounce3"></div>\n' +
                '</div>';

        $(btn).attr('disabled', true);
        $(btn).css({
                            // position: 'relative',
                            width: $(btn).outerWidth(),
                            height: $(btn).outerHeight()
                        }).append(html);
    };

    /**
     * Submit small form
     */
    $('button[type="submit"]').on('click', function (event) {
        event.preventDefault();
        var field = $(this).parent().find('input[name="from"]'),
            val   = {},
            err   = $(this).siblings('.error');

        field.each(function () {
            if (!validationForm($(this).val())) {
                err.text(err.data('error'));
                setTimeout(function () {
                    err.text('');
                }, 5000);
                val.error = 1;
                return false;
            } else {
                val[$(this).attr('name')] = $(this).val();
            }
        });

        if (val.error) {
            return false;
        } else {
            $(this).parents('form').submit();
            // btnLoader($(this));
            // $.ajax({
            //            type: 'POST',
            //            url: '/request-test',
            //            data: val,
            //            success: function (data) {
            //                if (data.status === 'success') {
            //                    field.each(function () {
            //                        $(this).val('')
            //                    });
            //                    err.text(data.msg);
            //                } else {
            //                    err.text('Попробуйте позже..');
            //                }
            //            },
            //            error: function (data) {
            //                if (data.status === 422)
            //                    err.text(data.responseJSON.from);
            //                else
            //                    err.text('Попробуйте позже..');
            //            }
            //        })
            //  .always(function () {
            //      btnLoader('hide');
            //      setTimeout(function () {
            //          err.text('');
            //      }, 5000)
            //  });
        }
    });

    /**
     * Submit pop-up form
     */
    $('#modal-send').on('click', function (event) {
        event.preventDefault();
        var field = $(this).parents('.modal-content').find('input:not([type=submit]), textarea'),
            val   = {};

        field.each(function () {
            val[$(this).attr('name')] = $(this).val();
        });

        if (val.error) {
            return false;
        } else {
            btnLoader($(this));
            $.ajax({
                       type: 'POST',
                       url: '/feedback',
                       data: val,
                       success: function (data, status) {
                           if (data.status === 'success') {
                               $('#feedback').addClass('hidden');
                               $('.correct-send').removeClass('hidden');
                               setTimeout(function () {
                                   $('#modal-form').modal('hide');
                               }, 2500);
                           }
                       }
                   })
                .fail(function (data) {
                    if (data.status === 422){
                        console.log(data);
                        var $form = $('.form-feedback'),
                            errors = data.responseJSON;

                        $form.find('.error').removeClass('error');

                        for(let error in errors) {
                            let $input = $form.find('[name="'+error+'"]');

                            $input.parent().addClass('error');
                            $input.siblings('.modal-error').text(errors[error][0]);
                        }
                    }
                })
                .always(function () {
                    btnLoader('hide');
                });
        }
    });

    /**
     * Hidden modal
     */
    $('#modal-form').on('hidden.bs.modal', function (e) {
        $('#feedback').removeClass('hidden');
        $('.correct-send').addClass('hidden');
        $(this).find('input, textarea').val('');
    });

    /**
     * Initialing tabs
     */
    $('#function-system a').click(function (event) {
        event.preventDefault();
        $(this).tab('show');
    })

    var has_active = false;
    $('#function-system li').each(function( index ) {
        if($(this).hasClass('active')) has_active = true;
    });

    if(!has_active)
        $('#function-system a:first').tab('show');


    /**
     * Autosize textarea
     */
    var textarea = document.querySelector('textarea');

    textarea.addEventListener('keydown', autosize);

    function autosize(){
        var el = this;
        setTimeout(function(){
            el.style.cssText = 'height:auto; padding:5px 0';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        },0);
    }

    /**
     * Initialing point animate
     */
    $('#animated-start').viewportChecker({
                                             callbackFunction: function () {

                                                 $('.flex-box:nth-child(1)').fadeIn(500);
                                                 $('.flex-box:nth-child(3)').fadeIn(500, function () {

                                                     if ($(window).width() > 600) {
                                                         $('.flex-box__wrapper-dotted').animate({
                                                                                                    width: '100%'
                                                                                                }, 1500, function () {
                                                             $('.flex-box:nth-child(2)').fadeIn(500);
                                                         });
                                                     } else {

                                                         $('.flex-box__wrapper-dotted').animate({
                                                                                                    height: '100%'
                                                                                                }, 1500, function () {
                                                             $('.flex-box:nth-child(2)').fadeIn(500);
                                                         });
                                                     }

                                                 });
                                             }
                                         });

    /**
     * Scroll to top
     */
    $(window).scroll(function () {
        if ($(this).scrollTop() > $(window).height()) {
            $('#scrol-top').fadeIn(2000);
        } else {
            $('#scrol-top').fadeOut(2000);
        }
    });
    $('#scrol-top').click(function () {
        $('body,html').animate({
                                   scrollTop: 0
                               }, 400);
        return false;
    });

    /**
     * Scroll navbar
     */
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0)
            $('nav').addClass('small-fix-navbar');
        else
            $('nav').removeClass('small-fix-navbar');
    });

    /**
     * Scroll to next display or anchor
     */
    $('a.scroll, .navbar-nav a:not(.link)').on('click', function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({
                                   scrollTop: top
                               }, 1500);
    });

    /**
     * Initialing review slider
     */
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
    });

    /**
     * Form validation
     * @param  {string} value            [Current phone or e-mail]
     * @return {boolean}                [Validation result]
     */
    function validationForm(value) {

        // e-mail
        var re    = /^[\w-\.]+@[\w-\.]+\.[a-z]{2,4}$/i,
            valid = re.test(value);
        if (valid) {
            return true;
        } else {

            // phone
            re = /^\d[\d\(\)\ -]{4,14}\d$/,
                valid = re.test(value);
            if (valid) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Coming soon..
     */
    $('.btn-coming-soon').click(function () {
        var $this = $(this),
            currentText = $this.text();
        
        $this.text('Coming soon');
        setTimeout(function () {
            $this.text(currentText);
        }, 2000);
    });

    $(document).euCookieLawPopup().init({
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
        htmlMarkup : $('#cookie-warning').html()
    });


    jQuery("a.playVideo").YouTubePopUp();
});