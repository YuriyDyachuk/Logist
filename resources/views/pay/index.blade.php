@extends('layouts.app')
@section('content')

    <div class="content-box pay-page">

        @include('pay.partials.header')

        <div class="content-box__body-tabs" data-class="dragscroll">
            @include('pay.partials.index.nav-tabs')
        </div><!-- \dragscroll -->

        <!-- Content -->
        <div class="tab-content">

            @include('pay.partials.index.includes.payment')

            @include('pay.partials.index.includes.bills')

            @include('pay.partials.index.includes.referral')

        </div>

    </div>

    @push('scripts')
    <script type="text/javascript" src="{{ url('/bower-components/bootstrap-input-spinner/src/bootstrap-input-spinner.js') }}"></script>
    <script type="text/javascript" src="{{ url('/main_layout/js/landing.js') }}"></script>
    <script>
    $(document).ready(function () {
        var $countcar = $("#count_car");
        var $periodmonth = $("#period_month");
        var $upgradeBtn = $('.upgradeBtn');
        var cancelBtn = $('.unsubscribeBtn');
        var $modalSubscriptions = $('#selectSubscription');
        var $submitSubscription = $('#submitSubscription');
        var $modal              = $('#paySubscription');
        var modalCancel         = $('#cancelSubscription');

        var $payNowBtn          = '.payNow';
        var $paymentForm        = '.paymentForm';

        $('#card').mask('9999-9999-9999-9999');
        $('#card_cvv').mask('999');

        $countcar.inputSpinner();
        
        $countcar.on("input", pay_onchange);

        $countcar.on("change", pay_onchange);

        function pay_onchange(event) {
            calculate(parseInt($countcar.val()), parseInt($periodmonth.val()));
        }

        function calculate(countcar, periodmonth) {

            var price = parseInt($("#prica_by_car").val());
            var as_id = $('#as_id').val();

            var total = countcar*price;
            $('#amount').val(total);
            $("#pay_total_html").html(countcar+"{{ trans('pay.auto') }}*"+price+"{{ trans('all.UAH') }}");
            $("#pay_total_number").html(total+" {{ trans('all.UAH') }}");
        }

        pay_onchange(null);

        $upgradeBtn.click(function () {
            $modalSubscriptions.modal('show');
        });

        cancelBtn.click(function () {
            modalCancel.modal('show');
        });

        $( "#pay_enterprise" ).click(function(event) { 
            event.preventDefault();
            $('#selectSubscription').modal('hide');
            $('#modal-form').modal('show');
        });

        $('.change_plan').click(function () {
            var id = $(this).data('id');

            let result;

            result =  $.ajax({
                url: '{{route('pay.subscription.get')}}',
                type: "post",
                data: {'id' : id},
//                    global: false,
                async:false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }}).responseJSON;

            $("#subscription_name").html(result.name);
            $("#subscription_id").val(id);
            $("#prica_by_car").val(result.price);

            pay_onchange(null);

            $modalSubscriptions.modal('hide');
        });

        $('#cancelSubscription').click(function () {


            let result;

            $.ajax({
                url: '{{route('pay.liqpay.cancel')}}',
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                },
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                }
            });



//            $("#subscription_name").html(result.name);
//            $("#subscription_id").val(id);
//            $("#prica_by_car").val(result.price);
//
//            pay_onchange(null);

            $modalSubscriptions.modal('hide');
        });

//        $submitSubscription.click(function () {
//            var $id = $('.subscription.active').data('id');
//            var $price = $('.subscription.active').data('price');
//            var $name = $('.subscription.active').data('name');
//            var selected_slug = $('.subscription.active').data('slug');
//            if (selected_slug == 'enterprise') {
//                $modalSubscriptions.modal('hide');
//                $('#modal-form').modal('show');
//                return false;
//            }
//
//            $("#subscription_name").html($name);
//            $("#subscription_id").val($id);
//            $("#prica_by_car").val($price);
//
//            pay_onchange(null);
//
//            $modalSubscriptions.modal('hide');
//        });

        $(document).on("click", $payNowBtn, function(event) {
            var amount = $('#amount').val();
            if (!amount) {
                event.preventDefault();
            }
            var postData = {
                _token: CSRF_TOKEN,
                amount: amount,
                subscription_id: $('#subscription_id').val(),
                subscription_period: $('#period_month').val(),
                transport_input: $('#count_car').val(),
            }
            $.ajax({
                url: '/pay/liqpay/formparams',
                type: 'POST',
                data: postData,
                dataType: 'JSON',
                success: function (data) {
                    $('#pay_param_data').val(data.data);
                    $('#pay_param_signature').val(data.signature);
                    $modal.modal('show');
                },
                error: function (data) {
                }
            });
        });

        $(document).on("click", $paymentForm, function(event) {
            var $form = $(this).parent().parent();
            $form.submit();
        });


    });
    </script>    
    @endpush

@endsection

@section('modals')
    @include('pay.partials.modal')
@endsection