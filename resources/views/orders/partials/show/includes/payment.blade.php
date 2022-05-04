<div role="tabpanel" class="tab-pane fade transition animated fadeIn" id="payment">

    <div class="tab-pane__row row">
        <div class="col-xs-12">
            <h2 class="h2 title-block">{{ trans('all.payment_information') }}</h2>
        </div>


        {{--@if(!$partner_view_check)--}}
        <div class="form-group col-sm-6">
            <label for="paiment_sum" class="control-label">{{ trans('all.amount') }} ({{ $order->currency }})</label>
            <input type="text" class="form-control" name="recommend_price"
                   {{--value="{{ $order->amount_fact ? $order->amount_fact : $order->amount_plan }}" @if($user->isUserClient || \App\Models\User::getUserRoleName($order->user_id) == \App\Enums\UserRoleEnums::CLIENT)disabled @endif>--}}
                   value="{{ ($order->getPerformer() && $order->getPerformer()->amount_fact !== null) ? $order->getPerformer()->amount_fact : $order->getPerformer()->amount_plan }}" @if($user->isClient() || \App\Models\User::getUserRoleName($order->user_id) == \App\Enums\UserRoleEnums::CLIENT)disabled @endif>
            <small id="error_recommend_price" class="text-danger"></small>
        </div>
        {{--@endif--}}

        <div class="clearfix"></div>
        <div class="form-group col-sm-6 vat">
            <input type="checkbox" value="1" @if($order->getPerformer() && $order->getPerformer()->vat !== null)checked @endif name="is_vat" id="is_vat" disabled="">
            <label for="is_vat" class="text-inherit">{{trans('all.VAT_with')}}</label>
        </div>
        @if($order->getPerformer() && $order->getPerformer()->amount_fact !== null)
        <div class="clearfix"></div>
        <div class="form-group col-sm-6" id="amount_partner">
            <label for="paiment_sum" class="control-label">{{ trans('all.amount_initial') }} ({{ $order->currency }})</label>
            <input disabled id="amount_plan_input" type="text" class="form-control" name="plan" value="{{ $order->getPerformer()->amount_plan }}">
        </div>
        @endif
        {{--@if(!$user->isClient())--}}
        {{--<div class="clearfix"></div>--}}
        {{--<div class="form-group col-sm-6" id="amount_partner" @if(!$order->partner) hidden @endif>--}}
            {{--<label for="paiment_sum" class="control-label">{{ trans('all.amount_partner') }} ({{ $order->currency }})</label>--}}
            {{--<input @if($partner_view_check || \Auth::user()->isClient()) disabled @endif id="amount_partner_input" type="text" class="form-control" name="price_partner"--}}
                   {{--value="{{ $order->amount_partner }}">--}}
        {{--</div>--}}
        {{--@endif--}}

        <div class="clearfix"></div>

        <div class="form-group col-sm-6">
            <label for="payment_type" class="control-label">{{ trans('all.payment_type') }}</label>
            <input type="text" name="payment_type" class="form-control" value="{{ ($order->getPerformer() && $order->getPerformer()->payment_type !== null) ? trans('all.order_'.$order->getPerformer()->payment_type->name) : ''}}" disabled>
        </div>

        <div class="clearfix"></div>

        <div class="form-group col-sm-6">
            <label for="paiment_cond" class="control-label">{{ trans('all.terms_type') }}</label>
            <input type="text" name="terms" class="form-control" value="{{ ($order->getPerformer() && $order->getPerformer()->payment_term !== null) ? trans('all.order_'.$order->getPerformer()->payment_term->name) : ''}}" disabled>
        </div>

        <div class="clearfix"></div>

        <div class="form-group col-xs-4 col-sm-2">
            <label class="control-label" for="debtdays">{{ trans('all.order_debtdays') }}</label>
            <input class="form-control input_numbers" type="text" name="debtdays" value="{{ ($order->getPerformer() && $order->getPerformer()->debtdays !== null && $order->getPerformer()->debtdays !== 0) ? $order->getPerformer()->debtdays : ''}}" disabled>
        </div>

        {{--<div class="clearfix"></div>--}}
        {{--<div class="form-group col-sm-6">--}}
            {{--<label class="control-label" for="comment">{{ trans('all.comment') }}</label>--}}
            {{--<textarea id="comment" name="comment" class="form-control" disabled>{{$order->comment}}</textarea>--}}
        {{--</div>--}}

        @if(\Auth::user()->isLogistic() && !$order_to_partner)
            <div class="col-xs-12 sub-name">
                {{--{{ trans('all.profitability_of_the_transaction') }}--}}
                <h2 class="h2 title-block">{{ trans('all.profitability_of_the_transaction') }}</h2>
            </div>

            <div class="form-group col-sm-3">
                <label for="trade_sum" class="control-label">{{ trans('all.amount') }}</label>
                <input type="text" class="form-control money"
                       value="{{ isset($order->profitability->amount) ? number_format((float)$order->profitability->amount, 2, '.', '') : ''}}"
                       name="amount" placeholder="0.00" inn-bind-update maxlength="10">
            </div>

            <div class="form-group col-sm-3">
                <label for="trade_com" class="control-label">{{ trans('all.manager_commission') }} (%)</label>
                <input type="text" class="form-control percent"
                       value="{{ $order->profitability->commission ?? '' }}"
                       name="commission" placeholder="0.00" inn-bind-update>
            </div>
        @endif

    </div>

</div>
