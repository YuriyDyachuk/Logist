@extends("layouts.app")

@section("content")
    <div class="content-box orders-page">

        <!-- Page title -->
        @include('orders.partials.header')

        <!-- Page header -->
        {{--@include('settings.layouts.header')--}}

        <!-- Page map -->
        {{--@includeWhen($type != 'requests', 'orders.map.map')--}}

        <!-- Page filters -->
        @include('orders.partials.filters')

        <!-- Content -->
        <div class="app-progress-group">
            <div class="progress app-progress-bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                     aria-valuemax="100" style="width: 0%;"></div>
            </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="orders">
                    <div id="ordersBox" class="ordersBox">
                        @include('orders.partials.index.list-orders')
                    </div>
                </div>
            <div role="tabpanel" class="tab-pane" id="requests">
                <!-- Tab panes -->
                <div class="tab-content">
                     <!-- Page Inn-logist requesrs -->
                     <div role="tabpanel" class="tab-pane active" id="innlogist_request">
                        <div id="ordersBox_requests" class="ordersBox">

                        </div>
                    </div>
                     <!-- Page Lardi-Trans -->
                    {{--<div role="tabpanel" class="tab-pane" id="larditrans_request">--}}
                        {{--<div id="larditransBox">--}}
                            {{--@include('orders.partials.lardi-form')--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        </div>

    </div><!-- \.content-box.orders-page -->

    {{-- tutorials --}}
    @include('tutorials.tutorials')
@endsection

@section('modals')
    @include('orders.partials.modal-offer')
@endsection


@push('scripts')
    <script defer>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip({container: 'body'});
            // Pagination
//            $('.orders-page').on('click', '.link-paginav a', function (e) {
            $('.orders-page').on('click', '.page-item a', function (e) {
                e.preventDefault();
                var url = $(e.target).attr('href');

                if (window.completedAjax) {
                    if(typeof window.progressBar === "function") {
                        window.progressBar( 70 );
                    }
                    $.get(url)
                     .done(function (data) {
                         if (data.status === 'ok') {

                             if(data.type == 'requests'){
                                 $('#ordersBox_requests').html(data.html);
                             }
                             else {
                                 $('#ordersBox').html(data.html);
                             }
                             $('[data-toggle="tooltip"]').tooltip({container: 'body'});
                         }
                     })
                     .fail(function (data) {
                         console.log(data);
                     })
                     .always(function () {
                         if(typeof window.progressBar === "function") {
                             window.progressBar( 100 );
                         }
                     });
                }
            });
        });


            if ($(window).width() < 376) {
                document.querySelectorAll('.marker-planning.marker-status.transition').forEach(function (el){
                    el.classList.add("button-style1");
                    el.classList.add("btn");
                });
            } else {
                document.querySelectorAll('table [role="table"]').forEach(function (el){
                    el.classList.remove("button-style1");
                    el.classList.remove("btn");
                });
            }
    </script>
@endpush