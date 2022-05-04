@if($user->isLogistic() || $user->isLogist())
    {{--<div class="content-box__body">--}}
        <div class="content-box__body-tabs" style="z-index: 3">
            <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
                <li role="presentation" class="transition active" >
                    <a href="#orders" data-order-filter="order" class="ajax-tab"><span>{{ trans('all.orders') }}</span></a>
                </li>
                <li role="presentation" class="transition">
                    <a href="#requests" class="{{ empty($notifications) ? '' : 'dot-notification' }} ajax-tab"
                       data-order-filter="requests"><span>{{ trans('all.requests') }}</span></a>
                </li>
            </ul>
        </div>
    {{--</div>--}}


    {{--<div class="content-box__filter page-order-filter-nav">--}}
        {{--<div class="row">--}}
            {{--<div class="content-box__body-tabs col-xs-12">--}}
                {{--<!-- Tab navigation: BEGIN -->--}}
                {{--<ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">--}}
                    {{--<li role="presentation" class="transition active" >--}}
                        {{--<a href="#orders" data-order-filter="order" class="ajax-tab"><span>{{ trans('all.orders') }}</span></a>--}}
                    {{--</li>--}}
                    {{--<li role="presentation" class="transition">--}}
                        {{--<a href="#requests" class="{{ empty($notifications) ? '' : 'dot-notification' }} ajax-tab"--}}
                           {{--data-order-filter="requests"><span>{{ trans('all.requests') }}</span></a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- Tab navigation: END -->--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="clearfix"></div>--}}
    {{--</div>--}}

    <div class="content-box__body-tabs /*page-order-filter-nav*/ page-request-filter-nav" style="display: none;">
        <!-- Tab navigation: BEGIN -->
        <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab2">
            <li role="presentation" class="transition active">
                <a href="#innlogist_request" data-order-filter1="innlogist" aria-controls="innlogist_request" role="tab" data-toggle="tab">INN.LOGIST</a>
            </li>
            <!-- -->
            {{--<li role="presentation" class="transition">--}}
            {{--<a href="#larditrans_request" data-order-filter1="larditrans" aria-controls="larditrans_request" role="tab" data-toggle="tab">LARDI-TRANS</a></li>--}}
            {{--<!-- -->--}}
        </ul>
        <!-- Tab navigation: END -->
    </div>

    {{--<div class="page-order-filter-nav page-request-filter-nav" style="display: none;">--}}
        {{--<div class="row">--}}
            {{--<div class="content-box__body-tabs col-xs-12" data-class="dragscroll">--}}
                {{--<!-- Tab navigation: BEGIN -->--}}
                {{--<ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab2">--}}
                    {{--<li role="presentation" class="transition active">--}}
                        {{--<a href="#innlogist_request" data-order-filter1="innlogist" aria-controls="innlogist_request" role="tab" data-toggle="tab">INN.LOGIST</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- Tab navigation: END -->--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endif

<div class="content-box__filters" id="content-box__forms">
    <form method="POST" action="" id="formFilters" class="clearfix">
        {{-- HIDDEN --}}
        <input type="hidden" name="filters[type]" value="orders">

        <div class="content-box__filter-category content-box__filter filter-mr-2 ">
            <label for="order_category" class="label-filter">{{trans('all.category')}}</label>
            <select id="filter-specialization" name="filters[specialization]"
                    class="form-control selectpicker" item-filter>
                <option value="" selected>{{trans('all.categories_all')}}</option>
                @foreach($specializations as $specialization)
                    @if($specialization->name == 'car_transport')
                        <option value="{{ $specialization->id }}">{{ trans('all.' . $specialization->name) }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div id="clearForm" class="clear-form">
            <a href="{{ route('orders') }}" class="btn btn-filter transition" type="button">
                <i class="fa fa-refresh"></i>
            </a>
        </div>

        <div class="content-box__filter-date content-box__filter filter-float__right">
            <label for="date" class="label-filter">{{trans('all.date')}}</label>
            <input type="text" name="filters[date]" class="datetimepicker" value="" onblur="changeDate($(this))">
        </div>

        <div id="orderFilter" class="content-box__filter-status content-box__filter filter-float__right filter-mr-2">
            <label for="order_status" class="label-filter">{{trans('all.status')}}</label>
            <select id="filter-status" name="filters[status]" class="form-control selectpicker" item-filter>
                <option value="" selected>{{trans('all.all')}}</option>
                @php($logist = $user->isLogistic())
                @foreach($statuses as $status)
                    @if($logist && $status->name == 'search')
                        @continue
                    @endIf
                    <option value="{{ $status->id }}">{{ trans('all.status_' . $status->name) }}</option>
                @endforeach
            </select>
        </div>

        <div id="requestFilter" class="content-box__filter content-box__filter-status offer hidden">
            <label for="offeroffer_chosen" class="label-filter">{{trans('all.proposal')}}</label>
            <select name="filters[offer]" class="form-control selectpicker" item-filter>
                <option value="" selected>{{trans('all.proposal_all')}}</option>
                <option value="1">{{trans('all.proposal_favorites')}}</option>
            </select>
        </div>

    </form>
    <div class="clearfix"></div>
</div>

@push('scripts')
    <script ></script>
    <script>

        var tab = window.location.hash.substr(1);

        if(tab === 'requests'){
            $('#rowTab a[href="#requests"]').tab('show');
        }

        // $(function () {
        var currentDate = '';

        $('[item-filter]').change(function () {
            filters();
        });

        function select(el){
            var $this          = $(el),
                type           = $this.attr('data-order-filter'),
                $orderFilter   = $('#orderFilter'),
                $requestFilter = $('#requestFilter');
                $boxFilter     = $('#content-box__forms');
                $requestNav    = $('.page-request-filter-nav');

            switch (type) {
                case 'requests':
                    $orderFilter.addClass('hidden');
                    $requestFilter.removeClass('hidden');
                    $boxFilter.removeClass('hidden');
                    $requestNav.slideDown();
                    break;

                case 'order':
                    $orderFilter.removeClass('hidden');
                    $requestFilter.addClass('hidden');
                    $boxFilter.removeClass('hidden');
                    $requestNav.slideUp();
                    break;
            }

            $('#titleType').text($this.text());
            $('#formFilters').find('[name="filters[type]"]').val(type);

            filters();
        }

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = e.target.hash;
            $boxFilter = $('#content-box__forms');

            switch (target) {
                case '#innlogist':
                    $boxFilter.removeClass('hidden');
                    break;
                case '#larditrans':
                    $boxFilter.addClass('hidden');
                    break;
            }
        });

        function filters() {
            var form = $('#formFilters');
            var data = form.serialize();
            if (window.completedAjax) {

                if(typeof window.progressBar === "function") {
                    window.progressBar(60);
                }

                $.ajax({
                    url     : "/orders",
                    type    : 'GET',
                    data    : data,
                    dataType: 'JSON',
                    success : function (data) {
                        if (data.status === 'ok') {

                            $('.ordersBox').empty();

                            if(data.type == 'requests'){
                                $('#ordersBox_requests').html(data.html);
                            }
                            else {
                                $('#ordersBox').html(data.html);
                            }

                            $('[data-toggle="tooltip"]').tooltip({container: 'body'});
                        }
                    },
                    error   : function (data) {
                        console.log(data)
                    }
                })
                .always(function () {
                    if(typeof window.progressBar === "function") {
                        window.progressBar( 100 );
                    }
                });
            }
        }

        function changeDate($this) {
            setTimeout(function () {
                if (currentDate != $this.val()) {
                    currentDate = $this.val();
                    filters();
                }
            }, 500);
        }

        var hash = window.location.hash;
        $block   = $('#rowTab a[href="' + hash + '"]');
        window.completedAjax = true;
//        select($block); // TODO REMOVE 2020-08-11

        // });
    </script>
@endpush
