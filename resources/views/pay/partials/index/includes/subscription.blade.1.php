<div class="row-eq-height">
    <div class="col-xs-12 col-lg-3 text-left panel margin-right-md">

        <h5 class="title-grey label-card">
            {{trans('all.your_current_plan')}} :
        </h5>

        <span class="sum bold">{{ $selected_subscription['name'] }}</span>
        <div class="clearfix"></div>

        <h3>
            <span class="transports">
                {{ $active_subscription->pivot->transports }}
            </span>
            / {{ $selected_subscription->limit != 0 ? $selected_subscription->limit : '50+' }} {{trans('all.vehicles')}}
        </h3>

        <button type="button" class="btn btn-success btn-xs plusTransports">+</button>
        <button type="button" class="btn btn-warning btn-xs minusTransports">-</button>
    </div>
    <div class="col-xs-12 col-lg-3 text-left panel margin-right-md">

        <h5 class="title-grey label-card">
            {{trans('all.expiration_date')}} :
        </h5>

        <p>{{ $active_subscription->pivot->expire_at ? Carbon\Carbon::parse($active_subscription->pivot->expire_at)->format('d.m.Y') : '-' }}</p>
        <div class="clearfix"></div>
        @if(!is_null($days_left))
            <span class="@if($days_left > 7) text-success @else text-danger @endif">{{$days_left}} {{trans('all.days')}}</span>
        @else
            <span class="text-danger">{{ trans('all.free_subscription') }}</span>
        @endif
    </div>
    <div class="col-xs-12 col-lg-3 text-left panel margin-right-md">

        <h5 class="title-grey label-card">
            {{trans('all.period')}} :
        </h5>

        <div class="form-group radio filter d-inline-block clearfix">
            <input type="radio" name="subscriptionType" id="subscriptionType" value="1" class="subscriptionType" @if($active_subscription->pivot->period == 1) checked="checked" @endif>
            <label for="subscriptionType">
                <span class="label_radio">{{trans('all.month')}}</span>
            </label>
        </div>

        <div class="form-group radio filter d-inline-block clearfix">
            <input type="radio" name="subscriptionType" id="subscriptionType2" value="12" class="subscriptionType" @if($active_subscription->pivot->period == 12) checked="checked" @endif>
            <label for="subscriptionType2">
                <span class="label_radio">{{trans('all.year')}}</span>
                <span class="label label-status label-danger">{{trans('all.discount')}} 10%</span>
            </label>
        </div>
    </div>
    <div class="col-xs-12 col-lg-3 text-left panel">
        <h5 class="title-grey label-card">
            {{trans('all.total')}} :
        </h5>
        <div>
            <div>
                <div class="col-xs-12 col-md-12 col-lg-5 padding-left-0 padding-right-0">
                    <h4 class="title-black label-card totalSubscription"><span>{{ $selected_subscription->price }}</span> {{trans('all.UAH')}}</h4>

                    <div class="newPrice">
                        <div class="discount" style="display: none">
                            <span data-title="" data-body="{{ trans('tooltips.1_year_discount') }}"></span> {{ trans('all.UAH') }}
                        </div>
                        <div class="return" style="display: none">
                            -<span data-title="" data-body="{{ trans('tooltips.will_be_returned') }}"></span> {{ trans('all.UAH') }}
                        </div>

                        <div class="saving" style="display: none">
                            -<span data-title="" data-body="{{ trans('tooltips.deducted_from_savings') }}"></span> {{ trans('all.UAH') }}
                        </div>
                    </div>

                    <div id="recommendation" style="">
                        {!!   trans('all.recommendation_enterprise') !!}
                        <div class="clearfix"></div>
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-form">{{ trans('all.contact_us') }}</button>
                    </div>
                    <div id="subscriptionData" class="hidden" data-subscription="{{ $selected_subscription->toJson() }}"></div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-7 payColumn text-right padding-right-md">
                    <button type="button" class="btn btn-success payNow">
                        <i class="fa fa-credit-card"></i></span>
                        <span class="title" data-pay="{{trans('all.pay')}}" data-submit="{{ trans('all.submit')  }}">{{trans('all.pay')}}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
