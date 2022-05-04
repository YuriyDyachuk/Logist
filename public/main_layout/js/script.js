/**
 * Project Name: InnLogist
 * Description: HTML skins files
 * Author: AmconSoft
 * Author URI: https://www.amconsoft.com/
 * Version: 0.0.1
 *
 * Current file: JavaScript script
 */
"use strict"
jQuery(document).ready(function () {

    /** Start page */

    /** Event upload file */
    jQuery('input[type="file"].inputfile').each(function () {
        var input    = jQuery(this),
            label    = input.next('label'),
            labelVal = label.html();

        input.on('change', function (e) {
            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                label.find('span').html(fileName);
            else
                label.html(labelVal);
        });
    });

    /** Event upload file */
    /** Event delete file */

    /** Event window resize */
    jQuery(window).resize(function () {
        console.log(window.innerWidth + ' : ' + window.innerHeight);
    });

    /** Event show/hidden next info-block */
    jQuery('.content-box__row-show').click(function () {
        jQuery(this).data('active', 1);
        jQuery('.content-box__row-show').each(function () {
            if (jQuery(this).data('active') != 1) {
                jQuery(this).removeClass('active').next('.content-box__row-second');
            }
        });
        jQuery(this).data('active', 0).toggleClass('active');
    });

    /** Event add second phone */
    $('#addTwoPhone').click(function (event) {
        $(this).addClass('hidden');
        $(this).next().toggleClass('hidden');
    });

    $('#rmTwoPhone').on('click', function(e){
        e.preventDefault();
        $(this).prev().find('input').val('');
        $(this).parent().toggleClass('hidden');
        $('#addTwoPhone').removeClass('hidden');
    });

    /** Event cancel submit form */
    jQuery('*[data-dismiss="modal"]').click(function (event) {
        jQuery(this).parents('form').find('input:not( [type="submit"] ), select, textarea').not('[type="radio"]').each(function () {
            jQuery(this).val('');
        });
        var tabpanel  = jQuery(this).parents('form').find('.tab-pane'),
            tabbutton = jQuery(this).parents('form').find('.nav-tabs > li');
        for (var i = 0; i < tabpanel.length; i++) {
            jQuery(tabbutton).eq(i).removeClass('active').removeAttr('aria-expanded');
            if (i == 0) {
                jQuery(tabpanel).eq(i).addClass('in active');
                jQuery(tabbutton).eq(i).addClass('active');
            } else {
                jQuery(tabpanel).eq(i).removeClass('in active');
                jQuery(tabbutton).eq(i).removeClass('active');
            }
        }
    });

    /** Event hidden/show order map */
    jQuery('.map-box__map-slider > a').click(function (event) {
        var data_even = jQuery(this).data('even'),
            data_html = jQuery(this).text();
        jQuery(this).parent().next().toggleClass('active');
        jQuery(this).fadeTo(400, 0.0001, function () {
            jQuery(this).data('even', data_html).text(data_even).fadeTo(400, 1);
        });
    });

    /** Event check transport own */
    jQuery('#transtort_own').change(function () {
        jQuery(this).parent().siblings('.own').toggleClass('private');
    });

    // /** Event select order type */
    // jQuery('.content-box__body-tabs-btn').click(function (event) {
    //     var name = jQuery(this).data('validate');
    //     var $this = $(this);
    //
    //     resetValidate(name);
    //     if (typeof($this.data('type')) !== 'undefined') {
    //         $this.parents('form').children('input[name="type"]').val($this.data('type'));
    //     }
    //
    //     if (validateData(name) && name !== 'Payment') {
    //         $this.parents('.content-box__body-tabs').toggleClass('active hidden').next().toggleClass('active hidden');
    //         event.preventDefault();
    //     }
    //
    //     if (name === 'Payment') {
    //         if (!validateData(name)) {
    //             event.preventDefault();
    //             return false;
    //         }
    //         btnLoader($this);
    //     }
    // });

    $('#newOrder').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    jQuery('.link-back').click(function (event) {
        $(this).parents('.content-box__body ').toggleClass('active hidden').prev().toggleClass('active hidden');
    });

    /** Event change specializations */
    jQuery('[data-spec]').change(function () {
        var fields = jQuery('#additionalField').html();
        var name   = jQuery(this).find('option:selected').attr('data-name');
        var box    = jQuery('#insertBox');

        if (/international/i.test(name)) {
            box.append(fields);
            box.slideDown(300);
        } else {
            box.slideUp(300, function () {
                $(this).html('');
            });
        }
    });

    /** Event rotation profile car */
    jQuery('.carthumb').click(function () {
        var clc_img = jQuery(this).html();
        jQuery('.carthumb').removeClass('active');
        jQuery(this).addClass('active');

        var el = jQuery(this).parent().parent().find('.cartimage');

        el.fadeTo(200, 0.0001, function () {
            el.html(clc_img).fadeTo(200, 1);
        });
    });

    /** Event show/hidden all services */
    jQuery('#all-services').click(function () {
        jQuery(this).siblings('.transition').toggleClass('collapse');
    });

    /** Event change radio */
    jQuery('#all-services').click(function () {
        jQuery(this).siblings('.transition').toggleClass('collapse');
    });


    /** Functions */
    function recalcWrapperHeight(el) {

        if (jQuery(el).data('recalc') == 1) {
            jQuery(el).parents('.content-box__body-tabs.active').animate({
                                                                             height: jQuery(el).parents('.tab-pane_col-right').outerHeight(true) + 135
                                                                         });
        } else {
            return false;
        }
    }
});