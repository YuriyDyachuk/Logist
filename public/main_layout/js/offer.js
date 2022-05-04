var $formOffer = $("#formOffer");

$formOffer.submit(function (event) {
    var data  = $(this).serialize(),
        type  = $(this).find('[name="type"]:checked').val(),
        input = $(this).find('[name="' + type + '"]');

    event.preventDefault();

    if (input.val() === '') {
        input.parent().addClass('has-error');
    } else {
        $.ajax({
                   url     : '/offer',
                   type    : 'POST',
                   data    : data,
                   dataType: 'JSON'
               })
         .done(function (data) {
             console.log(data);
             if (data.status == 'success')
                 window.location.href = data.url;

             if (data.status == 'false')
                 appAlert('', data.msg, 'warning');

         })
         .fail(function (data) {
             appAlert('', 'Something went wrong... :(', 'warning');
         });
    }
});

$formOffer.find('input').focus(function () {
    $(this).parent().removeClass('has-error');
});

$formOffer.on('click', '[name="type"]', function () {
    var $this = $(this);

    $('.form-control').attr('readonly', 'readonly');

    if ($this.val() !== 'current')
        $('[name="' + $this.val() + '"]').removeAttr('readonly');

});

function toggleBtn($this) {
    var modal = jQuery('#offer');

    if (jQuery($this).attr('id') === 'price1') {
        modal
            .find('.btn-take').removeClass('hidden')
            .end()
            .find('.btn-offer').addClass('hidden');
    } else {
        modal
            .find('.btn-take').addClass('hidden')
            .end()
            .find('.btn-offer').removeClass('hidden');
    }

}

$('body').on('click', '[data-target="#offer"]', function () {
    let modal    = jQuery('#offer'),
        parent   = jQuery(this).parents().eq(1),
        price    = parent.find('.sum').text().trim().replace(' ', ''),
        currency = parent.find('.currency').text().trim(),
        order    = $(this).attr('order-id'),
        discount = (price > 0) ? (price - (price * 0.05)) : 0;

    resetModal(modal);

    modal.find('#orderId').val(order);
    modal.find('input[name="discount"]').val(discount.toFixed(2));
console.log(order);
    if (price === '')
        return onlyOnePrice(modal);

    modal
        .find('.discount-price, .customer-price').show()
        .end()
        .find('#customerPrice').val(price)
        .end()
        .find('.currency').text(currency);
});

function resetModal(modal) {
    modal
        .find('.discount-price, .customer-price').show()
        .end()
        .find('input[type="radio"]').prop('checked', false)
        .end()
        .find('.btn-take, .btn-offer').addClass('hidden');
}

function onlyOnePrice(modal) {
    modal
        .find('.discount-price, .customer-price')
        .hide();
}

function likeOrder($this, orderId) {
    event.preventDefault();

    var like = $this.hasClass('liked') ? 0 : 1;

    $.get('/order-like/' + orderId + '/' + like)
     .done(function (response) {
         console.log(response);
         if (response.status === 'success') {
             $this.toggleClass('liked');
         }
     })
     .fail(function (response) {
         console.log(response);
     });
}
