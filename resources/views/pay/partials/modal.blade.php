<!-- Modal Payment: BEGIN -->
<div id="paySubscription" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content transition">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">{{ trans('pay.select_payment_method') }}</div>
            </div>

            <div class="margin-top-lg margin-left-lg margin-right-lg" id="liqpay">
                <form class="form-horizontal" method="POST" target="_blank" id="payment-form" role="form" action="https://www.liqpay.ua/api/3/checkout" >
                    <input type="hidden" id="pay_param_data" name="data">
                    <input type="hidden" id="pay_param_signature" name="signature"/>
                    <div class="row">
                        <div class="col-md-4 col-xs-offset-1 paymentForm paymentImg margin-right-sm">
                            <img src="{{ url('img/payments/liqpay.svg') }}" class="img">
                        </div>
                        <div class="col-md-6 paymentForm paymentDescription">
                            <div>{{ trans('pay.liqpay_description') }}</div>
                            <div class="margin-top-sm">
                                <a href="https://www.liqpay.ua">https://www.liqpay.ua</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default transition" data-dismiss="modal">{{ trans('all.cancel') }} <i>&times;</i></button>
            </div>

        </div>
    </div>
</div>
<!-- Modal Payment: END -->

<!-- Modal Cancel Subscription: BEGIN -->
<div id="cancelSubscription" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content transition">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">{{ trans('pay.cancel_subscription') }}</div>
            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn button-cancel transition" data-dismiss="modal">{{ trans('all.cancel') }} <i>&times;</i></button>
                <button type="button" class="btn button-style1 transition" id="cancelSubscription">OK</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal Payment: END -->

@include('pay.partials.modal_subscriptions', ['link' => false]);

<!-- Modal Contact form: BEGIN -->
<div class="modal fade bd-example-modal-lg" id="modal-form" tabindex="-1" role="dialog"
     aria-labelledby="modal-formTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="feedback">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span>Связаться</span>
                        <span>с нами</span>
                    </h5>
                    <button type="button" class="close transition" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body form-feedback">
                    <fieldset>
                        <div>
                            <input class="transition" type="text" name="name" value="" required>
                            <label class="transition">Имя</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>

                        <div>
                            <input class="transition" type="text" name="email" value="" required>
                            <label class="transition">Email</label>
                            <div class="modal-error transition">Неверные данные</div>
                        </div>

                        <div>
                            <input class="transition" type="text" name="subject" value="" required>
                            <label class="transition">Тема</label>
                            <div class="modal-error transition">Поле обязательно</div>
                        </div>
                    </fieldset>

                    <fieldset class="text-message">
                        <div>
                            <textarea name="message" required></textarea>
                            <label>Сообщение</label>
                            <div class="modal-error message transition">Поле обязательно</div>
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button id="modal-send" type="button" class="button-green transition btn btn-primary">Отправить</button>
                </div>
            </div>

            <div class="correct-send hidden transition">
                <div class="correct-send_wrapper">
                    <div class="correct-send_table">
                        <span>Сообщение успешно</span>
                    </div>
                    <div class="correct-send_table">
                        <span>отправленно</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Contact form: END -->