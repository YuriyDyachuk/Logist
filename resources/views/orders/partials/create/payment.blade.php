<!-- Step #4: BEGIN -->
<div id="step-3" class="/*content-box__body-tabs*/ content-box__body tab-pane__row hidden animated fadeIn">
  <div class="tab-pane_col-left">
    <h2 class="h2 title-grey"><i class="fa fa-angle-left link-back" data-step="2"></i>3/3</h2>
    <h2 class="h2 title-block">{{trans('all.payment_information')}}</h2>
  </div>

  <div class="tab-pane_col-right">
    <div id="formPayment" class="content-box__body-content">

      <div class="duplex select" style="margin-bottom: 26px">
        <label class="control-label" for="sum">{{trans('all.recommended_price')}}</label>

        <div class="row">
          <div class="col-xs-5 group">
            <input class="form-control" type="number" name="recommend_price" placeholder="0.00" maxlength="10" required>
            {{-- Validation msg --}}
            {{--<span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>--}}
            <small id="error_recommend_price" class="text-danger"></small>
          </div>

          <div class="col-xs-3">
            <select class="form-control selectpicker" name="currency">
              <option value="UAH" selected>{{strtolower(trans('all.UAH'))}}</option>
              {{--<option value="usd">доллар</option>--}}
              {{--<option value="eur">евро</option>--}}
            </select>
          </div>

          <div class="col-xs-3 vat">
            <input type="checkbox" value="1" name="is_vat" id="is_vat">
            <label for="is_vat" class="text-inherit">{{trans('all.VAT_with')}}</label>
          </div>
        </div>
        <span class="cap-box"></span>
      </div>

      <p class="select group error-for-selectpicker">
        <label class="control-label" for="payment_type">{{trans('all.payment_type')}}</label>
        <select class="form-control selectpicker" title="{{trans('all.select_type_payment')}}" name="payment_type" required>
          @foreach($payment_type as $type)
          <option value="{{$type->id}}">{{ trans('all.order_'.$type->name) }}</option>
          @endforeach
        </select>
        {{-- Validation msg --}}
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
        <small id="error_payment_type" class="text-danger"></small>
      </p>

      <p class="select group error-for-selectpicker">
        <label class="control-label" for="payment_terms">{{trans('all.terms_type')}}</label>
        <select class="form-control selectpicker" title="{{trans('all.select_payment_terms')}}" name="payment_terms" required>
          @foreach($payment_term as $term)
          <option value="{{$term->id}}">{{ trans('all.order_'.$term->name) }}</option>
          @endforeach
          <option value="{{trans('all.order_payment_safe')}}" disabled="disabled">{{trans('all.order_payment_safe')}}</option>
        </select>
        {{-- Validation msg --}}
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
        <small id="error_payment_terms" class="text-danger"></small>
      </p>


      <p>
        <label class="control-label" for="debtdays">{{ trans('all.order_debtdays') }}</label>
        <input type="text" id="debtdays" name="debtdays" class="form-control">
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
        <small id="error_debtdays" class="text-danger"></small>
      </p>




      <div class="group">
        <p>
          <label class="control-label" for="comment">{{ trans('all.comment') }}</label>
          <textarea id="comment" name="comment" class="form-control"></textarea>
        </p>
      </div>

      {{--            <p class="duplex checkbox select">
        <span style="margin-right: 0">
          <input type="checkbox" name="secure_deal" id="secure_deal">
          <label for="secure_deal">Безопасная сделка</label>
        </span>
      </p>--}}
    </div>
  </div>
  <div class="clearfix"></div>
  {{-- FOOTER --}}
  <div class="content-box__body-footer with-checkbox">
    <div class="type-checkbox" style="width: 40%">
      <input type="checkbox" id="asTemplate" name="save_as_template" value="">
      <label for="asTemplate">{{trans('all.save_as_template')}}</label>
    </div>
    <div class="__bottons" style="width: 60%">
      <a href="javascript://" class="btn button-cancel" data-cancel="flight">{{ trans('all.cancel') }} <i>×</i></a>
      <button id="submit" type="button"
      class="btn content-box__body-tabs-btn button-style1 transition"
      data-validate="Payment">{{ trans('all.save') }} <span class="arrow-right"></span></button>

      {{--<div class="__btn-cancel">--}}
        {{--<a href="javascript://" class="btn transition" data-cancel="flight">{{ trans('all.cancel') }} <i>×</i></a>--}}
        {{--</div>--}}
        {{--<div>--}}
          {{--<button id="submit" type="button"--}}
          {{--class="btn transition content-box__body-tabs-btn transition"--}}
          {{--data-validate="Payment">{{ trans('all.save') }} <i>–›</i></button>--}}
          {{--</div>--}}
        </div>
      </div>
    </div>
    <!-- Step #4: END -->
