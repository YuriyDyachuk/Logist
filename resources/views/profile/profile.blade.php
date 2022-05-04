@extends("layouts.app")

@section("content")

    <div class="content-box profile-page">
        @include('profile.partials.header')

        {{--<div class="content-box__body">--}}
        <div class="content-box__body-tabs" data-class="dragscroll">
            <!-- Tab navigation: BEGIN -->
            <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
                @if(request('id') == null)
                    <li class="active transition">
                        <a href="#info" aria-controls="info" role="tab"
                           data-toggle="tab">{{ trans('all.general_information') }}</a>
                    </li>
                    @canany(['logistic', 'logist'])
                        <li class="transition">
                            <a href="#staffs" aria-controls="employees" role="tab" data-toggle="tab">{{trans('all.staff')}}</a>
                        </li>
                        <li class="transition">
                            <a href="#partners" id="s" aria-controls="employees" role="tab" data-toggle="tab">{{trans('all.partners')}}</a>
                        </li>
                        <li class="transition">
                            <a href="#structure" aria-controls="structure" role="tab" data-toggle="tab">{{trans('all.company_structure')}}</a>
                        </li>
                    @endcanany
                    <li class="transition">
                        <a href="#testimonial" aria-controls="testimonial" role="tab" data-toggle="tab">{{trans('all.testimonial')}}</a>
                    </li>
                @else
                    <li class="active transition">
                        <a href="#info" role="tab" data-toggle="tab">{{ trans('all.general_information') }}</a>
                    </li>
                    <li class="transition">
                        <a href="#testimonial" aria-controls="testimonial" role="tab" data-toggle="tab">{{trans('all.testimonial')}}</a>
                    </li>
                @endif
            </ul>
            <!-- Tab navigation: END -->
        </div><!-- \dragscroll -->
        {{--</div>--}}

        <div class="content-box__body">

                <!-- Tab content: BEGIN -->
                <div class="tab-content">

                <!-- First tab: BEGIN -->
                @include('profile.partials.general-info')
                <!-- First tab: END -->

                    <!-- Second tab: BEGIN -->
                    <div role="tabpanel" class="tab-pane fade transition" id="staffs">
                        {{--@include('profile.partials.filters-staff')--}}
                        <div id="boxStaffs">
                            @includeWhen($user->isLogistic() || $user->isLogist() /*&& app_has_access(['staff.crud', 'staff.position', 'staff.logout', 'staff.department.create', 'staff.department.edit', 'staff.access', 'personal.edit'])*/, 'profile.partials.staff')
                        </div>
                </div>
                <!-- Second tab: END -->

                    @canany(['logistic', 'logist'])
                    <div role="tabpanel" class="tab-pane fade transition" id="partners">
                        @if(checkPaymentAccess('partners'))
                            @include('profile.partials.partner')
                        @else
                            @include('includes.plan_change')
                        @endif
                    </div>
                    @endcanany

                    <!-- Third tab: BEGIN -->
                @includeWhen($user->isLogistic() || $user->isLogist() /*&& app_has_access(['staff.crud', 'staff.position', 'staff.logout', 'staff.department.create', 'staff.department.edit', 'staff.access'])*/, 'profile.partials.structure')
                <!-- Third tab: END -->

                <!-- Fourth tab: BEGIN -->
                @include('profile.partials.testimonial')
                <!-- Fourth tab: END -->

                </div>
                <!-- Tab content: END -->
        </div>
        <div class="clear"></div>
    </div>

    {{-- tutorials --}}
    @include('tutorials.tutorials')

@endsection

@section('modals')
    @include('profile.partials.modal')
    @include('profile.partials.modals-tutorial-partner')
    @include('profile.partials.modals-tutorial-driver')

    <div id="EditEmployee" class="modal" role="dialog"></div>

    @include('profile.partials.create-edit-partner')

@endsection

@push('scripts')
    <script>
        var staff_delete_msg_attention = '{{ trans('profile.staff_delete_msg_attention') }}';
        var staff_delete_msg_success = '{{ trans('profile.staff_delete_msg_success') }}';
    </script>

    <script type="text/javascript" src="{{ url('/main_layout/js/profile.js') }}"></script>

    <script>
        $(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                let target = $(e.target).attr('href');

                if(target == '#partners'){
                    modal_partner();
                }
                if(target == '#staffs'){
                    modal_driver();
                }
            });

            let tab_active = $(".content-box__body-tabs .nav-tabs li.active").children('a').attr('href');


            if(tab_active == '#partners'){
                modal_partner();
            }

            if(tab_active == '#staffs'){
                modal_driver();
            }

            function modal_driver(){
                @if($staffs->count() == 0 && $user->isLogistic())
                    $('#driver-tutorial-modal').modal('show');
                @endif
            }

            function modal_partner(){
                @if($partners->count() == 0 && checkPaymentAccess('partners'))
                    $('#partner-tutorial-modal').modal('show');
                @endif
            }

            $(function () {
                let a = document.querySelector('a#s');
                let hash = window.location.hash;

                if (hash) {
                    setTimeout(function(){
                        $(a).trigger('click');
                    }, 50);
                }

            });

        });

    </script>
@endpush