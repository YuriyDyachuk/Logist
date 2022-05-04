<div class="modal centered-modal" id="offer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <form id="formOffer">
            <div class="modal-header">
                <h1 class="modal-title title-blue">{{trans('all.order_send_proposal')}}</h1>
            </div>
            <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="order" id="orderId">
                    {{--<div class="form-group discount-price">--}}
                        {{--<input type="radio" id="price1" name="type" value="discount" onclick="toggleBtn(this)">--}}
                        {{--<label for="price1">Забрать заказ прямо сейчас</label>--}}

                        {{--<span>Хотите забрать заказ прямо сейчас? Сделайте скидку на перевозку и этот заказ будет Ваш.</span>--}}

                        {{--<div class="price-block">--}}
                            {{--<input type="text" class="form-control money" name="discount" placeholder="0.00" readonly maxlength="10">--}}
                            {{--<span class="currency"></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group customer-price">
                        <input type="radio" id="price2" name="type" value="current" onclick="toggleBtn(this)" checked>
                        <label for="price2">{{trans('all.order_proposal_amount_customer')}}</label>

                        <span>{{trans('all.order_proposal_text_customer_price')}}</span>

                        <div class="price-block">
                            <input type="text" id="customerPrice" class="form-control" name="current" placeholder="0.00" readonly>
                            <span class="currency"></span>
                        </div>
                    </div>

                    <div class="form-group executor-price">
                        <input type="radio" id="price3" name="type" value="own" onclick="toggleBtn(this)">
                        <label for="price3">{{trans('all.order_proposal_amount_my')}}</label>

                        <span>{{trans('all.order_proposal_text_executor_price')}}</span>

                        <div class="price-block">
                            <input type="text" class="form-control money" name="own" placeholder="0.00" readonly maxlength="10">
                            <span class="currency"></span>
                        </div>
                    </div>

            </div>
            <div class="modal-footer content-box__body-footer">
                <button type="button" class="btn  button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}</button>
                <button type="submit" class="btn  button-style1 hidden btn-take add-offer">Принять заказ <span
                            class="arrow-right"></span></button>
                <button type="submit" class="btn  button-style1 hidden btn-offer add-offer">{{trans('all.order_send_proposal')}} <span
                            class="arrow-right"></span></button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@push('scripts')
    <script type="text/javascript" src="{{url('/main_layout/js/offer.js')}}"></script>
@endpush