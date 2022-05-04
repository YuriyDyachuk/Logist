const currentOrderId = $('[data-order]').attr('data-order');

// setMarker('.places');

$('.phone-mask').mask('(000) 000-00-00');
$('.percent').mask('##0.00', {reverse: true});

$('#additionalLoads').click(function () {
    var $select = $('.additional-loads');

    if ($(this).prop('checked'))
        $select.removeClass('hidden');
    else
        $select.addClass('hidden');
});

/* The Events for modal */
$('#newDoc').change(function () {
    var $this    = $(this),
        fileName = $this.val().replace(/C:\\fakepath\\/i, ''),
        html     = '<span class="file-name">' + fileName + '</span>';

    $this.siblings('[name="documentName"]').val(fileName.replace(/\..+$/, ''));
    $this.siblings('.file-name').detach();
    $this.parent().append(html);
    $('#addDocumentBtn').removeAttr('disabled');
});

$('[name="documentName"]').keydown(function () {
    if ($(this).val() === '')
        $('#addDocumentBtn').attr('disabled', 'disabled');
    else
    {
        $('#addDocumentBtn').removeAttr('disabled');
        $('#form_id').attr('disabled', 'disabled');
    }    
});

$('[name="form_id"]').change(function () {
    if ($(this).val() === '0')
        $('#addDocumentBtn').attr('disabled', 'disabled');
    else
        $('#addDocumentBtn').removeAttr('disabled');
});

$('#addDocumentBtn').click(function () {
    var data = new FormData($('#formDocument')[0]);

    data.append('orderId', currentOrderId);
    data.append('_token', CSRF_TOKEN);
    data.append('slug', $( "#form_id option:selected" ).text());

    btnLoader($(this));
    $.ajax({
               url        : '/order-document',
               type       : 'POST',
               data       : data,
               processData: false,
               contentType: false
           })
     .done(function (data) {
         if (data.status === 'success') {
             $('.documents-box').html(data.html);
             $.notify({message: 'Документ сохранен'}, {type: 'success'});
         }
     })
     .fail(function (data) {
         console.log(data);
         appAlert('', 'Something went wrong... :(', 'warning');
     })
     .always(function () {
         btnLoader(null);
         $('#addDocument').modal('hide');
     });
});

$('.documents-box').on('click', '.btn-destroy-doc', function (e) {
    e.preventDefault();

    appConfirm('', 'Нужно подтвердить удаление документа.', 'question', function () {
        destroyDocument($(e.currentTarget))
    });
});

$('.documents-box').on('change', '.update-document', function () {
    var $this = $(this);

    appConfirm('', 'Вы действительно хотите заменить документ?', 'question', function () {
        updateDocument($this);
    });
});

$('#additionalDriver').click(function () {
    var $box = $('.driver-box.additional');

    if ($(this).prop('checked'))
        $box.removeClass('hidden');
    else
        $box.addClass('hidden');
});

$('#addDocument').on('hidden.bs.modal', function () {
    $(this)
        .find('input').val('')
        .end()
        .find('.file-name').detach();
});

// Event inn-bind-update
$('[inn-bind-update]').change(function () {
    var field = $(this).attr('name'),
        data  = {};

    data[field] = $(this).val();

    $.post('/order/' + currentOrderId, data)
     .done(function (data) {
         if (data.status === 'success') {
             console.log(data)
         }
     })
     .fail(function () {
         appAlert('', 'Something went wrong... :(', 'warning');
     })
});

// Event inn-bind-update
$('[name="additional_download"]').change(function () {
    var $this = $(this),
        data  = {additional_loading: null};

    if ($this.is('input[type="checkbox"]') && $this.prop('checked')) {
        data.additional_loading = $('#addDownloadSelect').val();
    } else if ($this.is('select')) {
        data.additional_loading = $this.val();
    }

    $.post('/additional-loading/' + currentOrderId, data)
     .done(function (data) {
         if (data.status === 'OK') {
             console.log(data)
         }
     })
     .fail(() => appAlert('', 'Something went wrong... :(', 'warning'));
});

$('[data-action-order]').click(function (e) {
    e.preventDefault();
    if(!$(this).attr('dis')){
        let action  = $(this).data('action-order').split('-'),
            data    = {
                _token     : CSRF_TOKEN,
                action     : action[0],
                orderId    : action[1],
                transportId: $('[name="transportId"]').val()
            },
            options = {
                showCancelButton : true,
                confirmButtonText: sweetAlert_btn_confirm,
                allowOutsideClick: false
            };

        let qBlock = true;

        switch (action[0]) {
            case 'rejection':
                options.title            = sweetAlert_btn_order_title_cancel;
                options.input            = 'textarea';
                options.inputPlaceholder = sweetAlert_form_placeholder_order;
                options.inputValidator   = (value) => {
                    return new Promise((resolve, reject) => {
                        if (value !== '') {
                            resolve();
                        } else {
                            swal.showValidationError('Поле обязательно для заполнения.');
                            reject();
                        }
                    })
                };
                break;
            case 'rejectionoffers':
                if (typeof(mapEditor) !== 'undefined'){
                    mapEditor.saveOrder();
                }

                //
                options.type = 'question';
                options.text = sweetAlert_cancel_success_order;
                break;

            case 'rejectionexecuteoffer':
                if (typeof(mapEditor) !== 'undefined'){
                    mapEditor.saveOrder();
                }

                //
                options.type = 'question';
                options.text = sweetAlert_cancel_success_order;
                break;

            case 'activate':
                if (typeof(mapEditor) !== 'undefined'){
                    mapEditor.saveOrder();
                }

                //
                options.type = 'question';
                options.text = sweetAlert_success_active_order;
                break;

            case 'completed':
                    qBlock = false;
                    orderComplete(data);
                // options.type = 'question';
                // options.text = 'Подтвердите завершения заказа.';
                break;
            case 'testimonial':
                console.log('123123');
                qBlock = false;
                orderComplete(data);
            // case 'completion':
            //         qBlock = false;
            //
            //         $('#completed_order').modal('show');
            break;
        }

        if(qBlock === true){
            swal(options).then((comment) => {
                if (typeof comment === 'string'){
                data.comment = comment;
            }

            orderId = $('#orderID').val();
            orderComplete(data);
            // $.ajax({
            //     url: '/order-action',
            //     type: 'POST',
            //     data: data,
            // }).done(function (data) {
            //     if (data.status === 'OK')
            //         window.location.href = data.redirectTo;
            //     else
            //         appAlert('', 'Something went wrong... :(', 'warning');
            // }).fail(function (response) {
            //     let data = response.responseJSON;
            //     if (data.status === 'ERROR')
            //         appAlert('', data.errors.message, 'error');
            //     console.warn(response);
            //
            // }).always(function () {
            //     btnLoader(null);
            // });

            }).catch(swal.noop);
        }

    } else {
        options = {
            confirmButtonText: 'ОК',
            allowOutsideClick: false,
            text : sweetAlert_tab_progress_order,
        };
        swal(options);
        }

});

function orderComplete(data){

    if(data.action === 'testimonial'){
        data.rating = $('#testimonial_order').find('input[name=rating]').val();
        data.comment = $('#testimonial_order').find('textarea[name=comment]').val();
    }

    // console.log(data);

    $.ajax({
        url: '/order-action',
        type: 'POST',
        data: data,
    }).done(function (data) {
        if (data.status === 'OK')
            window.location.href = data.redirectTo;
        else
            appAlert('', 'Something went wrong... :(', 'warning');
    }).fail(function (response) {
        let data = response.responseJSON;
        if (data.status === 'ERROR')
            appAlert('', data.errors.message, 'error');
        console.warn(response);

    }).always(function () {
        btnLoader(null);
    });
}


$('#formDocument').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

function updateDocument($this) {
    var data    = new FormData($this.parents('form')[0]);
    var imageId = $this.siblings('[name="documentId"]').val();

    data.append('_token', CSRF_TOKEN);
    $.ajax({
               url        : '/order-document/' + imageId,
               type       : 'POST',
               data       : data,
               processData: false,
               contentType: false
           })

     .done(function (data) {
         if (data.status === 'success') {
             $('#linkDown' + data.image.id).attr('href', data.image.path).removeClass('no-file');
             $.notify({message: data.msg}, {type: 'success'});
         } else {
             $.notify({message: data.msg}, {type: 'warning'});
         }
     })

     .fail(function (data) {
         console.log(data);
         appAlert('', 'Something went wrong... :(', 'warning');
     });
}

function destroyDocument($this) {
    var url   = $this.attr('href');
    var $item = $this.parents('[data-document]');

    console.log()
    $.ajax({
               url : url,
               type: 'DELETE',
               data: {_token: CSRF_TOKEN}
           })
     .done(function (data) {
         console.log(data);
         if (data.status === 'success') {
             $item.detach();
             $.notify({message: data.msg}, {type: 'success'});
         }
     })
     .fail(function (data) {
         console.log(data);
         appAlert('', 'Something went wrong... :(', 'warning');
     });
}

function setMarker(elem) {
    var marker, places;

    marker = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
        'w', 'x', 'y', 'z'
    ];
    places = $(elem).find('.marker-place')

    $.each(places, function (key, elem) {
        $(elem).text(marker[key]);
    })
}


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
        scrollTop: $(".content-box__header").offset().top - 80
    }, 0);
});

$('.chang-transport').on('change', function(e) {
    let partners_request = $('#partners_request');

    if(partners_request !== 'undefined'){
        if($(partners_request).is(":visible")){
            $('#text-save-btn2').show();
            $('#activate-button').prop('disabled', true);
        }
        else {
            $('#text-save-btn2').hide();
            $('#activate-button').prop('disabled', false);
        }
    }


//
//     if($(this).attr('id') === 'partnerTransport') {
//         $('#activate-button').attr('disabled', true)
//         $('#amount_partner').show()
//         $('#text-save-btn').text('и отправить')
//
//     } else {
//         $('#activate-button').attr('disabled', false)
//         $('#amount_partner').hide()
//         $('#text-save-btn').text('')
//
//     }
});

$('#ownTransport').click(function(e) {
    $('#amount_partner').hide();
});

$('#amount_partner_input').change(function(e) {
    let val = $('#amount_partner_input').val();
    $('#price_partner_general').val(val);

});

var hash = window.location.hash;
$block = $('#rowTab a[href="' + hash + '"]');
if($block.hasClass('ajax-tab')){
    $block.click();
} else {
    $block.tab('show');
}

var orderEditor = {
    saveOrder: function(){

        $data = $('#generalForm').serialize();

        $data += '&recommend_price='+$('input[name=recommend_price]').val();
        $data += '&price_partner_general='+$('input[name=offer_partner]').val();

        var partners = $('.selectpicker_transport').val();

        $data += '&partners=' + $('.selectpicker_transport').val();

        orderId = $('.content-box__body').data('order');
        console.log(orderId);
        $.ajax({
            url: '/order/' + orderId,
            type: 'POST',
            data: $data,
            dataType: 'JSON',
        }).done(function (data) {
            if (data.status === 'OK')
                window.location.href = data.redirectTo;
        }).fail(function (data) {
            var errors = data.responseJSON;

            appAlert('', 'Something went wrong... :(', 'warning');

            btnLoader('hide');

        }).always(function () {
            btnLoader(null);
        });

        btnLoader(null);

    }
};

