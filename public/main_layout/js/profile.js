var $modal, $btnAdd, staff, $form, $userId;;
var postions_list = positions;

$modal  = $('#addEmployee');
$btnAdd = $('#submitEmployee');
$form   = $('#formCreateStaff');
$userId = $modal.find( "[name='id']");

function removeStaff(id) {
    appConfirm('', staff_delete_msg_attention, 'warning', function () {
        if (id <= 0)
            return;
        $.ajax({
            url: '/staff/' + id,
            type: 'DELETE',
            data: {_token: CSRF_TOKEN}
        })
                .done(function (res) {
                    if (res.status === 'success') {
                        swal(staff_delete_msg_success, '', 'success');
                        window.location.reload();
                    }
                })
                .fail(function () {
                    swal('Something went wrong... :(', '', 'warning');
                })
    });
}

staff = {
    save: function () {
        btnLoader($btnAdd);

        /* Save or update */
        if($userId.val() == 0)
            var $_url = '/staff';
        else
            var $_url = '/staff/'+$userId.val()+'/save';

        $.ajax({
                url        : $_url,
                type       : "POST",
                data       : new FormData($form[0]),
                processData: false,
                contentType: false
            })
            .done(function (data) {
                if (data.status === 'success') {

                    if(!data.refresh)
                        window.location.href = data.url;
                    else {
                        var hash = window.location.hash;
                        if(hash == "#" || hash == '')
                            window.location.hash = '#staffs';

                        self.location.reload();
                    }
                }
            })
            .fail(function (data) {
                var errors = data.responseJSON;

                if (data.status === 422)
                    staff.validation(errors);
                else
                    appAlert('', 'Something went wrong... :(', 'warning');

            })
            .always(function(){
                btnLoader(null);
            });
    },
    edit: function(obj){
        $data = obj.data('staff');
        let on_flight = obj.data('on_flight');
        $modal.find( "[name='id']").val($data.id);
        $modal.find( "[name='full_name']").val($data.name);
        $modal.find( "[name='phone']").val($data.phone);

        // console.log($data);

        // reset
        $('[name=is_admin]').prop('disabled', true);
        $('[name=is_admin]').prop('checked', false);


        $('[name=functional_role]').prop('disabled', true);
        if($data.role == null){
            $data.role = {role_id: 0};
            $('[name=functional_role]').prop('disabled', false);
        }

        $('[name=functional_role]').prop('disabled', false);

        // can be administrator
        if($data.roles[0].can_admin === 1) {
            $('[name=is_admin]').prop('disabled', false);
        }

        $('[name=position]').prop('disabled', false);
        $('.status-on-flight').hide();
        // if driver on flight cant change role
        if(on_flight === true) {
            $('[name=is_admin]').prop('disabled', true);
            $('[name=position]').prop('disabled', true);
            $('.status-on-flight').show();
        }

        // console.log($data.is_admin);

        // if user has already admin access
        if($data.is_admin === 1) {
            console.log($data.is_admin);
            $('[name=is_admin]').prop('disabled', false);
            $('[name=is_admin]').prop('checked', true);
        }


        // if driver
        if($data.role.role_id === 3) {
            $('.license').show();
            $('.field-password').hide();
        } else {
            $('.license').hide();
            $('.field-password').show();
        }

        $modal.find( "[name='position'] option").each(function( index ) {
            if($(this).val() == $data.role.role_id) {
                $modal.find( "[name='position']").parent().find('.filter-option-inner-inner').text($(this).text());
                $(this).attr('selected','selected');
            }
        });

        $modal.find( "[name='payment_type'] option").each(function( index ) {
            if($(this).val() == $data.meta_data.payment_type) {
                $modal.find( "[name='payment_type']").parent().find('.filter-option-inner-inner').text($(this).text());
                $(this).attr('selected','selected');
            }
        });
        $modal.find( "[name='payment_type']").val($data.meta_data.payment_type);
        $modal.find( "[name='position']").val($data.role.role_id);
        $modal.find( "[name='passport']").val($data.meta_data.passport);
        $modal.find( "[name='birthday']").val($data.meta_data.birthday);
        $modal.find( "[name='inn_number']").val($data.meta_data.inn_number);
        $modal.find( "[name='rate']").val($data.meta_data.rate);
        $modal.find( "[name='work_start']").val($data.meta_data.work_start);
        $modal.find( "[name='percent']").val($data.meta_data.percent);
        $modal.find( "[name='driver_licence']").val($data.meta_data.driver_licence);
        $modal.find( "[name='email']").val($data.email);

        if($data.meta_data.payment_type == 1) {
            $modal.find( "input[name='rate']" ).prop('disabled', false);
        }

        if($data.meta_data.payment_type == 2) {
            $modal.find( "input[name='percent']" ).prop('disabled', false);
        }

        if($data.meta_data.payment_type == 3) {
            $modal.find( "input[name='rate']" ).prop('disabled', false);
            $modal.find( "input[name='percent']" ).prop('disabled', false);
        }

        update_position_list($data.role.role_id);
        //add new fields

        var $btn = $modal.find( "#submitEmployee");
        $btn.html($btn.data('edit'));


        $('#addEmployee').modal('show');

    },
    validation: function (errors) {
        // var err = 0;

        staff.resetValidation();

        $.each( errors, function( key, value ) {

            let keys = key.split('.');

            if(keys.length > 1){
                $form.find('#'+keys[1]).parent('.form-group').addClass('has-error');
                $form.find('#error_'+keys[1]).text(value);
                $form.find('#error_'+keys[1]).show();
                $form.find('#'+keys[1]).addClass('shake');
             }
            else {

                let elem   = $('[name="' + key + '"]');
                let parent = elem.hasClass('selectpicker') ? elem.parents('.error-for-selectpicker') : elem.parent();

                $form.find('#error_'+key).text(value);
                $form.find('#error_'+key).show();
                $form.find('input[name='+key+']').addClass('shake');
                // $form.find('input[name='+key+']').parent('div').addClass('has-error');
                parent.addClass('has-error');
            }

        });

        setTimeout(function () {
            $form.find('.shake').removeClass('shake');
        }, 500);

        // if (errors !== undefined) {
        //     $.each(errors, function (key, value) {
        //         var name    = key.search(/phone/i) !== -1 ? 'phone[]' : key,
        //             $elem   = $('[name="' + name + '"]'),
        //             $parent = $elem.hasClass('selectpicker')
        //                 ? $elem.parents('.form-group')
        //                 : $elem.parent();
        //
        //         $parent.addClass('has-error');
        //     });
        // } else {
        //
        //     if($userId.val() == 0)
        //         var $_selector = 'input, select';
        //     else
        //         var $_selector = 'input:not(.skipUpdate), select:not(.skipUpdate)';
        //
        //     $form.find($_selector).each(function () {
        //         var $this   = $(this),
        //             $parent = $this.hasClass('selectpicker')
        //                 ? $this.parents('.error-for-selectpicker')
        //                 : $this.parent();
        //
        //
        //         if ($this.val() === '' && !$parent.hasClass('hidden')) {
        //             if ($this.attr('name') !== 'password' && $this.attr('name') !== 'position' && $this.attr('name') !== 'driver_licence') {
        //                 $parent.addClass('has-error shake');
        //                 err++;
        //                 console.log($(this).attr('name'))
        //             }
        //
        //         } else {
        //             $parent.removeClass('has-error');
        //         }
        //
        //         setTimeout(function () {
        //             $form.find('.shake').removeClass('shake');
        //         }, 500)
        //     });
        // }
        //
        // console.log(err);
        //
        // if (err > 0) return false;

        // $('#form_validation_error').hide();
        // return true;
    },

    resetValidation: function () {
        $form.find('.text-danger').hide();
        $form.find('.has-error').removeClass('has-error');
    }
};


/* THE EVENTS */
$btnAdd.click(function () {

    // if (staff.validation())
        staff.save();

});

$('#avatar, #license').change(function () {
    var $this    = $(this),
        fileName = $this.val().replace(/C:\\fakepath\\/i, ''),
        html     = '<span class="file-name">' + fileName + '</span>';

    $this.siblings('.file-name').detach();
    $this.parent().append(html);
});

$(".phone").intlTelInput({
    initialCountry : "ua",
    nationalMode   : false,
    formatOnDisplay: true,
    utilsScript    : "/plugins/phone_input/js/utils.js",
});

$modal.on('hidden.bs.modal', function (e) {
    $modal
        .find('.file-name')
        .detach()
        .end()
        .find('input')
        .each(function () {
            if ($(this).attr('name') !== '_token') {
                $(this).val('');
            }
        });

    var $btn = $modal.find( "#submitEmployee");
    $btn.html($btn.data('add'));

    $('[name=is_admin]').prop('checked', false);
    $('[name=is_admin]').prop('disabled', true);

    staff.resetValidation();
});

/*
$('#rowTab a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
});
*/

$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;

    $([document.documentElement, document.body]).animate({
        scrollTop: $(".profile-page").offset().top
    }, 0);
});

var hash = window.location.hash;
if(hash == '#add_staff'){
    $('#addEmployee').modal('show');
} else {
    $('#rowTab a[href="' + hash + '"]').tab('show');
}

$('#addEmployee').on('show.bs.modal', function (e) {

    var id = $(this).find('input[name=id]').val();

    if(id === ''){
        $("#position").val('default');
        $("#position").selectpicker('refresh');

        $("#payment_type").val('default');
        $("#payment_type").selectpicker('refresh');
    }

    $('.selectpicker').selectpicker('refresh');
});

function update_position_list($id) {

    // var parent = null;
    // var child = null;
    // var childs = null;
    //
    // postions_list.forEach(function(element) {
    //     if($id == element.id) {
    //         parent = element.id;
    //         childs = element.children;
    //     }
    //
    //     element.children.forEach(function(ChildElement) {
    //         if($id == ChildElement.id) {
    //             parent = element.id;
    //             child = ChildElement.id;
    //             childs = element.children
    //         }
    //     });
    // });
    //
    // if (typeof parent !== 'object') {
    //     $modal.find( "[name='functional_role'] option").each(function( index ) {
    //         if($(this).val() == parent) {
    //             $modal.find( "[name='functional_role']").parent().find('.filter-option-inner-inner').text($(this).text());
    //             $(this).attr('selected','selected');
    //         }
    //     });
    //     $modal.find( "[name='functional_role']").val(parent);
    // }
    //
    // if(typeof childs == 'object') {
    //     if (childs!== null && childs.length >= 1) {
    //         $modal.find(".position-picker").show();
    //         $modal.find( ".position-picker").removeClass('hidden');
    //         $modal.find("[name='position'] option").remove();
    //         $el = '';
    //         childs.forEach(function (ChildElement) {
    //             var selected = '';
    //             if ($id == ChildElement.id) {
    //                 selected = 'selected="selected"';
    //             }
    //             $el += '<option value="' + ChildElement.id + '" ' + selected + '>' + ChildElement.name + '</option>';
    //         });
    //         $modal.find("[name='position']").append($el);
    //         $('#position').selectpicker('refresh');
    //     } else {
    //         // $modal.find( "[name='functional_role'] option").each(function( index ) {
    //         //     $(this).prop('selected', false);
    //         // });
    //         $modal.find( "[name='functional_role'] option").prop('selected', false);
    //         $modal.find(".position-picker").hide();
    //     }
    //
    //     $('.selectpicker').selectpicker('refresh');
    // } else {
    //     $modal.find( ".position-picker").hide();
    //     $modal.find( ".position-picker").addClass('hidden');
    // }
}

  // Create user position for 'manager' role. Start page in add user in profile company.
$( "#addEmployee" ).ready(function() {
    $id = $( "[name='functional_role'] option:selected").val();
    $('.status-on-flight').hide();
    update_position_list($id);
});

$( "[name='functional_role']" ).change(function() {
    $id = $( "[name='functional_role'] option:selected").val();
    update_position_list($id);
});

$('select[name=payment_type]').change(function () {
    var selectPayment = $(this).find("option:selected").val()
    var rate = $('input[name=rate]')
    var percent = $('input[name=percent]')

    switch (selectPayment) {
        case '1' :
            rate.prop( "disabled", false );
            percent.prop( "disabled", true );
            percent.val( 0 );
            break;
        case '2' :
            rate.prop( "disabled", true );
            rate.val( 0 );
            percent.prop( "disabled", false );
            break;
        case '3' :
            rate.prop( "disabled", false );
            percent.prop( "disabled", false );
            break;
    }
})

// $('select[name=functional_role]').change(function () {
//     var selectRole = $(this).find("option:selected").val()
//
//     if (selectRole == 5) {
//         $modal.find( ".license").hide();
//         $modal.find( ".license").addClass('hidden');
//     } else if (selectRole == 3) {
//         $modal.find( ".license").show();
//         $modal.find( ".license").removeClass('hidden');
//     }
// })

// $('select[name=position]').change(function () {
//     var selectPosition = $(this).find("option:selected").val()
//     if (selectPosition == 2) {
//         $modal.find( ".license").hide();
//         $modal.find( ".license").addClass('hidden');
//     } else if (selectPosition == 1) {
//         $modal.find( ".license").show();
//         $modal.find( ".license").removeClass('hidden');
//     }
// })

function randomPassword(length) {
    var pass  = "";

    var pwd = [], cc = String.fromCharCode, R = Math.random, rnd, i;
    pwd.push(cc(48+(0|R()*10))); // push a number
    pwd.push(cc(65+(0|R()*26))); // push an upper case letter

    for(i=2; i<length; i++){
        rnd = 0|R()*62; // generate upper OR lower OR number
        pwd.push(cc(48+rnd+(rnd>9?7:0)+(rnd>35?6:0)));
    }

    pass = pwd.sort(function(){ return R() - .5; }).join('');

    let result = pass.match(/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/);

    if(result){
        return pass;
    } else {
        return randomPassword(8);
    }


}

function refreshPass($this) {
    $this.next().val(randomPassword(8));
    $this.next().change();
}

$(document).ready(function() {
    if(getUrlParameter('tutorial')){
        $('#addEmployee').modal('show');
    };

    $('#position').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

        let role = $(this).val();

        $('[name=is_admin]').prop('checked', false);

        let admin = false;

        postions_list.forEach(function(element) {
            if(role == element.id && element.can_admin == 1) {
                admin = true;
            }

            element.children.forEach(function(ChildElement) {
                if(role == ChildElement.id  && ChildElement.can_admin == 1) {
                    admin = true;
                }
            });
        });

        if(admin === true){
            $('[name=is_admin]').prop('disabled', false);
        } else {
            $('[name=is_admin]').prop('disabled', true);
        }

        if(role === '3'){
            // if driver
            $('.license').show();
            $('[name=password]').val(randomPassword(8));
            $('.field-password').hide();
        }
        else {
            $('.license').hide();
            $('[name=password]').val('');
            $('.field-password').show();
        }

    });

});

function removePartner(id) {
    appConfirm('', 'Партнер будет удален из Вашего списка.', 'question', function () {
        if (id <= 0) return;
        $.ajax({
            url: '/partner/' + id,
            type: 'DELETE',
            data: {_token: CSRF_TOKEN}
        })
            .done(function (res) {
                if (res.status === 'success') {
                    window.location.reload();
                }
            })
            .fail(function () {
                swal('Something went wrong... :(', '', 'warning');
            })
    });
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};