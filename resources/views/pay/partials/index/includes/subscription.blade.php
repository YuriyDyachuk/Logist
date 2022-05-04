<div class="row">
    <div class="col-xs-12 col-lg-12 text-left">
        <h2 class="title pay_current_plan_title" >
            {{trans('all.your_current_plan')}}<span class="upgradeBtn" id="subscription_name">{{ $selected_subscription['name'] }}</span> <span id="subscription_date">{{trans('all.pay_valid_until')}} <b>{{$date_at}}</b></span>
        </h2>
    </div>
</div>
<div class="row-eq-height pay_container">
    <div class="col-xs-12 col-lg-6 text-left panel margin-right-md pay_panel">
        <h3 class="title text-center">
            {{trans('pay.transport')}}
        </h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.count_transport')}}
        </h3>

        <h3 class="title text-center label-card">
            {{ $as_count_car }}
        </h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.change_count_transport')}}
        </h3>

        <input type="number" id="count_car" value="0" min="{{ $as_count_car ? (-1) * $as_count_car : 0 }}" max="1000" step="1"/>
        <input type="hidden" id="prica_by_car" value="{{ $selected_subscription['price'] }}"/>
        <input type="hidden" id="subscription_id" value="{{ $selected_subscription['id'] }}"/>
        <input type="hidden" id="amount" value="0"/>
        <input type="hidden" id="as_id" value="{{ $as_id }}"/>
        <input type="hidden" id="as_prica_by_car" value="{{ $as_prica_by_car }}"/>
        <input type="hidden" id="as_month_count" value="{{ $as_month_count }}"/>
        <input type="hidden" id="as_count_car" value="{{ $as_count_car }}"/>
        <input type="hidden" id="period_month" value="0"/>

    </div>
<!--    
    <div class="col-xs-12 col-lg-4 text-left panel margin-right-md pay_panel">

        <h3 class="title text-center label-card">
            {{trans('pay.period')}}
        </h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.period_to')}}
        </h3>

        <h3 class="title text-center label-card">
            {{ Carbon\Carbon::parse($date_at)->format('d.m.Y') }}
        </h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.renew_subscription')}}
        </h3>

        <input type="number" id="period_month" value="0" min="0" max="1000" step="1"/>

    </div>
-->    
    <div class="col-xs-12 col-lg-6 text-left panel margin-right-md pay_panel">
   
        <h3 class="title text-center label-card">
            {{trans('pay.cost')}}
        </h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.cost_subscription')}}
        </h3>

        <h3 class="title text-center label-card" id="pay_total_html"></h3>

        <h3 class="title-grey text-center label-card">
            {{trans('pay.total_cost')}}
        </h3>

        <h3 class="title text-center label-card pay_surcharge" style="display:none" id="pay_surcharge_html"></h3>

        <h2 class="title text-center label-card" id="pay_total_number"></h2>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-7 payColumn text-right padding-right-md">
                <button type="button" class="btn button-style1 payNow">
                    <i class="fa fa-credit-card"></i>
                    <span class="title" data-pay="{{trans('all.pay')}}" data-submit="{{ trans('all.submit')  }}">{{trans('all.pay')}}</span>
                </button>
            </div>
        </div>
    </div>
</div>
{{--{{var_dump($active_subscription->toArray())}}--}}
{{--@if ($active_subscription && $active_subscription->plan_id == 1)--}}


<div class="row">
    <div class="col-xs-12 col-lg-12 text-left">
        <h2 class="title pay_current_plan_title" >
            @if ($active_subscription && $active_subscription->plan_id != 1)
                {{ trans('pay.count_transport_paid') }}: {{checkPaymentFeatureUsage('transports')}}
            @else
                {{trans('pay.no_plan')}}
            @endif
        </h2>
    </div>
</div>
