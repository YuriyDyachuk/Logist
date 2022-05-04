<!-- Modal Select subscription: BEGIN -->
<div id="selectSubscription" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content transition">
            {{--<div class="modal-header">--}}
                {{--<div class="h1 title-blue modal-title">{{ trans('pay.select_subscription') }}</div>--}}
            {{--</div>--}}
            <section class="plans">
                <div class="container">
                    <h2 class="d-md-none">{{ trans('pay.select_subscription') }}</h2>
                    <p class="d-md-none tit">{{ trans('pay.select_subscription_text') }}</p>
                    <div class="row-head js-sidebar-menu">
                        <div class="p-col">
                            <h4>{{ trans('pay.plans_features') }}</h4>
                            <p>{{ trans('pay.plans_features_dscr') }}</p>
                        </div>
                        <div class="p-col">
                            <h4 class="basic">{{ trans('pay.plan_basic') }}</h4>
                            <p>{{ trans('pay.plan_basic_description') }}</p>
                        </div>
                        <div class="p-col">
                            <h4 class="individual">{{ trans('pay.plan_individual') }}</h4>
                            <p>{{ trans('pay.plan_individual_description') }}</p>
                        </div>
                        <div class="p-col pro">
                            <h4 class="pro">{{ trans('pay.plan_pro') }}</h4>
                            <p>{{ trans('pay.plan_pro_description') }}</p>
                        </div>
                        <div class="p-col">
                            <h4 class="enterprice">{{ trans('pay.plan_enterprice') }}</h4>
                            <p>{{ trans('pay.plan_enterprice_description') }}</p>
                        </div>
                    </div>

                    <div class="price_body">
                        <div class="block block-0">
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                </div>
                                <div class="p-col b">
                                    <a href="#" class="btn-default change_plan" data-id="1">{{ trans('pay.plan_basic_button') }}</a>
                                </div>
                                <div class="p-col i">
                                    <a href="#" class="btn-default change_plan" data-id="2">{{ trans('pay.plan_individual_button') }}</a>
                                </div>
                                <div class="p-col p">
                                    <a href="#" class="btn-default change_plan" data-id="3">{{ trans('pay.plan_pro_button') }}</a>
                                </div>
                                <div class="p-col e">
                                    <a href="#" class="btn-default custom">{{ trans('pay.plan_enterprice_button') }}</a>
                                </div>
                            </div>



                        </div>
                        <div class="block block-1">
                            <div class="block-title">
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#profile"></use>
                                </svg>
                                <p>{{ trans('pay.profile_collaboration') }}</p>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_profile') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">

                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_company') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">

                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_company_department') }}</p>
                                </div>
                                <div class="p-col b">
                                </div>
                                <div class="p-col i">
                                </div>
                                <div class="p-col p">
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_staff') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_partners') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">

                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_testimonial') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_staff_driver') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_staff_manager') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_staff_driver_stat') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_clients') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div><div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_clients_tracking') }}</p>
                                    </div>
                                    <div class="p-col b">

                                    </div>
                                    <div class="p-col i">

                                    </div>
                                    <div class="p-col p">

                                    </div>
                                    <div class="p-col e">

                                    </div>
                                </div>
                            </div>

                            <!-- <a href="#" class="view_more"><span>View More</span>
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#arrow_sm"></use>
                                </svg>
                            </a> -->
                        </div>

                        <!-- Block2 -->
                        <div class="block block-2">
                            <div class="block-title">
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#orders"></use>
                                </svg>
                                <p>{{ trans('pay.orders_requests') }}</p>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_requests_from_clients') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">

                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_partners_price') }}.</p>
                                </div>
                                <div class="p-col b">
                                </div>
                                <div class="p-col i">
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_order_creating') }}</p>
                                </div>
                                <div class="p-col b">
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_order') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">

                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_order_progress') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">

                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- <a href="#" class="view_more"><span>View More</span>
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#arrow_sm"></use>
                                </svg>
                            </a> -->
                        </div>

                        <!-- Block3 -->
                        <div class="block block-3">
                            <div class="block-title">
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#transport"></use>
                                </svg>
                                <p>{{ trans('pay.transport') }}</p>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_transports') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_app_gps') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_transports_search') }}</p>
                                </div>
                                <div class="p-col b">
                                </div>
                                <div class="p-col i">

                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>

                        </div>

                        <!-- Block4 -->
                        <div class="block block-4">
                            <div class="block-title">
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#finance"></use>
                                </svg>
                                <p>{{ trans('pay.finance_analytics') }}</p>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_analytics_company') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_analytics_deal') }}</p>
                                </div>
                                <div class="p-col b">

                                </div>
                                <div class="p-col i">

                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_analytics_logist') }}</p>
                                </div>
                                <div class="p-col b">
                                </div>
                                <div class="p-col i">

                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_analytics_driver') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="row-5" data-hidden="true">
                                    <div class="p-col">
                                        <p>{{ trans('pay.tms_control_1с') }}</p>
                                    </div>
                                    <div class="p-col b">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col i">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col p">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                    <div class="p-col e">
                                        <svg>
                                            <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- <a href="#" class="view_more"><span>View More</span>
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#arrow_sm"></use>
                                </svg>
                            </a> -->
                        </div>

                        <!-- Block5 -->
                        <div class="block block-5">
                            <div class="block-title">
                                <svg>
                                    <use xlink:href="/images/svg/payment/sprite/sprite.svg#documents"></use>
                                </svg>
                                <p>{{ trans('pay.documents') }}</p>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_doc_e') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_doc_auto_creating') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                    <p>{{ trans('pay.tms_control_doc_templates') }}</p>
                                </div>
                                <div class="p-col b">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col i">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="p-col p">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                                <div class="stopper"></div>
                                <div class="p-col e">
                                    <svg>
                                        <use xlink:href="/images/svg/payment/sprite/sprite.svg#check"></use>
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row-head js-sidebar-menu row-footer">
                        <div class="p-col">
                            <h4>{{ trans('pay.plans_features') }}</h4>
                            <p>{{ trans('pay.plans_features_dscr') }}</p>
                        </div>
                        <div class="p-col">
                            <h4 class="basic">{{ trans('pay.plan_basic') }}</h4>
                            <p>Up to 2 vehicles Free</p>
                        </div>
                        <div class="p-col">
                            <h4 class="individual">{{ trans('pay.plan_individual') }}</h4>
                            <p>Up to 5 vehicles<br> 3$/Month per vehicle</p>
                        </div>
                        <div class="p-col pro">
                            <h4 class="pro">{{ trans('pay.plan_pro') }}</h4>
                            <p>Up to 5 vehicles<br> 8$/Month per vehicle</p>
                        </div>
                        <div class="p-col">
                            <h4 class="enterprice">{{ trans('pay.plan_enterprice') }}</h4>
                            <p>Up to 50 vehicles<br> Custom</p>
                        </div>
                    </div>
                    <div class="price_body price_footer">
                        <div class="block block-0">
                            <div class="row-5" data-hidden="false">
                                <div class="p-col">
                                </div>
                                <div class="p-col b">
                                    <a href="#" class="btn-default change_plan" data-id="1">{{ trans('pay.plan_basic_button') }}</a>
                                </div>
                                <div class="p-col i">
                                    <a href="#" class="btn-default change_plan" data-id="2">{{ trans('pay.plan_individual_button') }}</a>
                                </div>
                                <div class="p-col p">
                                    <a href="#" class="btn-default change_plan" data-id="3">{{ trans('pay.plan_pro_button') }}</a>
                                </div>
                                <div class="p-col e">
                                    <a href="#" class="btn-default custom">{{ trans('pay.plan_enterprice_button') }}</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- Modal Select subscription: END -->
@if($link)
    @push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $( "#pay_enterprise" ).click(function(event) {
                event.preventDefault();
                $('#selectSubscription').modal('hide');
                $('#modal-form').modal('show');
            });
            $( ".change_plan" ).click(function(event) {
                event.preventDefault();
                
                var selected_slug = $('.subscription.active').data('slug');
//                if (selected_slug == 'enterprise') return false;
//                var selected = $('.subscription.active').data('id');
                var selected = $(this).data('plan');
                var url = $(this).attr('href')+'?id='+selected;
                console.log(selected);
                console.log(url);
                //window.location.href = url;
            });
        });
    </script>
    @endpush
@endif