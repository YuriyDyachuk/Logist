var $subscriptionBody, $payNowBtn, $upgradeBtn, $subscriptionType,
    $totalSubscription, $modal, $ammount, $subscription_id, $subscription_period,
    $plusTransports, $minusTransports, $transport_input, $submitSubscription,
    $recommendation;

var $newExpire, $newTransport, $newPrice, $subscriptionData, $newReturn, $additionalTransport;
var $paymentForm;
/* Static elements */

$upgradeBtn         = $('.upgradeBtn');
$subscriptionBody   = $('#subscriptionBody');
$modal              = $('#paySubscription');
$modalSubscriptions = $('#selectSubscription');
$submitSubscription = $('#submitSubscription');
$newExpire          = $('#newExpire span');
$newTransport       = $('#newTransport span');

$newPrice           = $('#newPrice .total span');
$newReturn          = $('.newPrice .return span');
$newSaving          = $('.newPrice .saving span');
$newDiscount        = $('.newPrice .discount span');
$additionalTransport= $('#additionalTransport');

$subscriptionData   = '#subscriptionData';
$ammount            = $modal.find('.amount');
$subscription_id    = $modal.find('.subscription_id');
$subscription_period= $modal.find('.subscription_period');
$transport_input    = $modal.find('.transport_input');


/* Dynamic loaded elements */
$subscriptionType   = '.subscriptionType';
$totalSubscription  = '.totalSubscription span';
$transportsCounter  = 'span.transports';
$plusTransports     = '.plusTransports';
$minusTransports    = '.minusTransports';
$newPriceBody       = '.newPrice';
$payNowBtn          = '.payNow';
$recommendation     = '#recommendation';
$paymentForm        = '.paymentForm';

var $popovers = [
    {'el' : $newExpire,     'container': $newExpire},
    {'el' : $newReturn,     'container': $newReturn},
    {'el' : $newSaving,     'container': $newSaving.parent()},
    {'el' : $newDiscount,   'container': $newDiscount}
];

var csrf = $('meta[name="csrf-token"]').attr('content');

subscription = {
    id:0,
    price:0,
    type:1,
    transports:1,
    total:0,
    limit:0,
    min:1,
    paid: true,
    active_transport : 1,
    disabled_minus : false,
    disabled_plus : false,
    expire: '',
    init: function(){

        var $data = $($subscriptionData).data('subscription');

        $data.pivot ? subscription.type = $data.pivot.period                    : subscription.type = subscription.getType();
        $data.pivot ? subscription.transports = $data.pivot.transports          : subscription.transports = $data.min;
        $data.pivot ? subscription.active_transport = $data.pivot.transports    : subscription.active_transport = $data.min;
        $data.pivot ? subscription.expire = Date.parse($data.pivot.expire_at)   : Date.now();

        subscription.price      = $data.price;
        subscription.id         = $data.id;
        subscription.total      = $data.price;

        subscription.limit      = $data.limit;
        subscription.min        = $data.min;

        $data.type == 'free' ? subscription.paid = false : subscription.paid = true;

        subscription.updateRecommendation();
        subscription.updateTransport(subscription.transports);
        $newTransport.html(0);
        subscription.updatePrice();
        subscription.init_popovers();
    },
    init_popovers: function(){
        $popovers.forEach(function(element) {
            var $el         = element.el;
            var $container  = element.container;

            $el.each(function( index ) {
                $el.eq(index).popover({
                    container: $container.eq(index),
                    html     : true,
                    placement: 'auto right',
                    title    : $el.eq(index).data('title'),
                    content  : $el.eq(index).data('body'),
                    trigger  : 'hover'
                });
            });
        });
        $newPrice.hover(
            function() {
                var now = new Date();
                $newPrice.popover({
                    container: $newPrice,
                    html     : true,
                    placement: 'auto right',
                    title    : $newPrice.data('title'),
                    content  : function() {
                        return $newPrice.data('body')+ ' : '+subscription.getDate(now)+' - '+subscription.getExpire();
                    },
                    trigger  : 'hover'
                });
                $newPrice.popover("show");
            }, function() {}
        );
    },
    get: function($id){
        $.ajax({
            url        : '/pay/subscription/'+$id+'/',
            type       : 'GET',
            data       : [],
            processData: false,
            contentType: false
        }).done(function (data) {
            $subscriptionBody.html(data);
            var $data = $($subscriptionData).data('subscription');
            subscription.price  = $data.price;
            subscription.total  = $data.price;
            subscription.id     = $data.id;
            subscription.transports ? subscription.active_transport = subscription.transports : subscription.active_transport = 0;
            subscription.transports = $data.min;
            subscription.limit      = $data.limit;
            subscription.min        = $data.min;

            $data.type == 'free' ? subscription.paid = false : subscription.paid = true;

            $($transportsCounter).html(subscription.transports);
            subscription.updateRecommendation();
            subscription.updatePrice();
            subscription.init_popovers();

        }).fail(function (data) {
            appAlert('', 'Something went wrong... :(', 'warning');
        }).always(function() {
            btnLoader(null)
        });

    },
    save: function(){
        $.ajax({
            url        : '/pay/submit',
            type       : 'POST',
            data       : {_token: csrf, sid: subscription.id, type : subscription.type, transports: subscription.transports},
            dataType   : 'JSON',
        }).done(function (data) {
            window.location.href = '/pay'
        }).fail(function (data) {
            appAlert('', 'Something went wrong... :(', 'warning');
        }).always(function() {
            btnLoader(null)
        });
    },
    updateTransport: function(transport){

        /* if user select free subscription, and set maximal transport number */
        /* We show pop up with subscriptions list */

        if(!subscription.paid && subscription.limit < transport) {
            $modalSubscriptions.modal('show');
            return false;
        }

        if(transport > subscription.limit && subscription.limit != 0)
            return false;

        if(transport < 1)
            return false;

        subscription.transports = transport;

        /*Disable / enable minus button */
        subscription.transports <= subscription.min ? subscription.disabled_minus = true : subscription.disabled_minus = false;
        $($minusTransports).prop('disabled', subscription.disabled_minus)


        /*Disable / enable plus button */
        if(subscription.limit != 0 && subscription.paid) {
            subscription.transports == subscription.limit ? subscription.disabled_plus = true : subscription.disabled_plus = false;
            $($plusTransports).prop('disabled', subscription.disabled_plus)
        }

        $($transportsCounter).html(subscription.transports);
        subscription.updatePrice();
        subscription.updateRecommendation();

        return true;
    },
    updatePrice: function(){
        $.ajax({
            url        : '/pay/calculate',
            type       : 'POST',
            data       : {_token: csrf, sid: subscription.id, type : subscription.type, transports: subscription.transports},
            dataType   : 'JSON',
        }).done(function (data) {

            /* Getting data, from loaded subscription  */
            $newTransport.html(data.new_transport);
            $newExpire.html(data.expire);

            /* Show or hide total block */
            if(!subscription.paid){
                $newPrice.parent().hide();
            } else {
                $newPrice.html(data.total);
                $newPrice.parent().show();
            }

            /* Setting expire date block */
            subscription.total      = data.total;
            if(data.datetime_expire) {
                if(typeof data.datetime_expire.date !== 'undefined') {
                    subscription.expire = Date.parse(data.datetime_expire.date);
                } else {
                    subscription.expire = Date.parse(data.datetime_expire);
                }
            } else {
                subscription.expire = Date.now();
            }

            var title = $($payNowBtn).find('.title');

            /* Hide or show returned balance blocks */
            if(data.return_balance > 0){
                $newReturn.each(function( index ) {
                    $(this).html(data.return_balance);
                });
                $newReturn.parent().show();
            } else {
                $newReturn.parent().hide();
            }

            /* Hide or show saving blocks */
            if(data.save > 0){
                $newSaving.each(function( index ) {
                    $(this).html(data.save);
                });
                $newSaving.parent().show();
            } else {
                $newSaving.parent().hide();
            }

            /* Hide or show discount blocks */
            if(data.discount > 0){
                $newDiscount.each(function( index ) {
                    $(this).html(data.discount);
                });
                $newDiscount.parent().show();
            } else {
                $newDiscount.parent().hide();
            }

            /* Hide or show addition block, when new transport was added or removed */
            if(data.new_transport > 0) {
                $subscriptionBody.find($payNowBtn).hide();
                $subscriptionBody.find($newPriceBody).hide();
                $additionalTransport.show();
                $($totalSubscription).html(0);
            } else {
                $subscriptionBody.find($payNowBtn).show();
                $subscriptionBody.find($newPriceBody).show();
                $additionalTransport.hide();
                $($totalSubscription).html(data.total);
            }

            if(data.total == 0)
                title.html(title.data('submit'));
            else
                title.html(title.data('pay'));


        }).fail(function (data) {
            //appAlert('', 'Something went wrong... :(', 'warning');
        }).always(function() {
            //btnLoader(null)
        });
    },
    updateRecommendation: function(){

        if(subscription.limit == 0 && subscription.transports >= 50){
            $($recommendation).show();
        } else {
            $($recommendation).hide();
        }

    },
    getExpire: function(){
        var date = new Date(subscription.expire);
        return subscription.getDate(date);
    },
    getDate: function(date){
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return (d < 10 ? '0' : '') + d + '.' +(m < 10 ? '0' : '') + m + '.' + y;
    },
    getType: function(){
        var $i = $($subscriptionType+':checked').val();
        return $i;
    }
};

/* EVENTS */
$upgradeBtn.click(function () {
    $modalSubscriptions.modal('show');
});

$submitSubscription.click(function () {
    $id = $('.subscription.active').data('id');
    subscription.get($id);
    $modalSubscriptions.modal('hide');
});

$(document).on("change", $subscriptionType, function() {

    /* Calculating discount, and count of months here */
    subscription.type = subscription.getType();
    subscription.updatePrice();

});

$(document).on("click", $payNowBtn, function(event) {

    if(subscription.total > 0) {
        $ammount.val(subscription.total);
        $subscription_id.val(subscription.id);
        $subscription_period.val(subscription.type);
        $transport_input.val(subscription.transports);
        $modal.modal('show');
    } else {
        event.preventDefault();
        subscription.save();
    }

});

$(document).on("click", $paymentForm, function(event) {
    var $form = $(this).parent().parent();
    $form.submit();
});


$(document).on("click", $plusTransports, function() {
    subscription.updateTransport(subscription.transports+1);
});

$(document).on("click", $minusTransports, function() {
    subscription.updateTransport(subscription.transports-1);
});


subscription.init();


