@extends('layouts.app')
@section('content')

    <div class="content-box profile-page dashboard-content" id="dashboard">
            <!-- header page custom -->
        @include('dashboard.partials.header')

        <!-- nav-bar menu -->
        @include('dashboard.partials.nav')

        <div class="content-box analytics-page">
            <div class="tab-content">
                @include('dashboard.partials.logistics_block')
                @include('dashboard.partials.orders_block')
            </div>
        </div>

        <div class="clear"></div>
    </div>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.js"></script>

    @include('analytics.includes.graph')

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: '2020-10-07',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'All Day Event',
                        start: '2020-10-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2020-10-07',
                        end: '2020-10-10'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2020-10-09T16:00:00'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2020-10-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2020-10-11',
                        end: '2020-10-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-10-12T10:30:00',
                        end: '2020-10-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2020-10-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-10-12T14:30:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2020-10-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2020-10-28'
                    }
                ]
            });

            calendar.render();
        });


        document.addEventListener("DOMContentLoaded", function(event) {
            let element_one = document.querySelector('.content-box__title');
            let element_two = document.querySelector('.header-tools.mail-block');

            function resize() {
                if (window.innerWidth < 865) {
                    element_one.classList.remove('col-xs-7');
                    element_one.classList.add('col-xs-12');

                    element_two.classList.remove('col-xs-5');
                    element_two.classList.add('col-xs-12');
                } else {
                    element_one.classList.remove('col-xs-12');
                    element_one.classList.add('col-xs-7');

                    element_two.classList.remove('col-xs-12');
                    element_two.classList.add('col-xs-5');
                }
            }

            window.onresize = resize;
        });

        let ctx = document.getElementById('myChart');
        let myChart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 7, 5, 2, 12, 6, 9]
                }]
            },

            // Configuration options go here
            options: {}
        });


        <!--[  Location position block  ]-->
        $(function() {

            if ($("#scrollbarAddress").length) {
                var sortable = new Sortable(scrollbarAddress, {
                    draggable: ".draggable",
                    onEnd: function (evt) {
                        console.log(evt);
                        updSortEl();
                    },
                });
            }

            if ($("#pos__1").length) {
                var sortableChild = new Sortable(pos__1, {
                    draggable: ".nested-1",
                    onEnd: function (evt) {
                        updSortChildEl();
                    }
                });
            }

            if ($("#pos__4").length) {
                var sortableChildTwo = new Sortable(pos__4, {
                    draggable: ".nested-1",
                    onEnd: function (evt) {
                        updSortChildTwoEl();
                    }
                });
            }
        });

        function updSortEl(){

            let elements_sorted = {};

            $('.draggable').each(function(index){
                let el_id = $(this).attr('id').split('__');
                elements_sorted[index] = el_id[1];
            });

            $.ajax({
                url     : '{{ route('location.position') }}',
                type    : 'post',
                data    : {'position_dashboard' : elements_sorted},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
                .done(function (data) {

                })
                .fail(function (data) {
                    console.warn(data);
                });
        }
        function updSortChildEl(){

            let elements_sorted_child = {};
            $('#pos__1 .nested-1').each(function(index){
                let el_id_child = $(this).attr('id').split('__');
                elements_sorted_child[index] = el_id_child[1];
            });

            $.ajax({
                url     : '{{ route('location.position') }}',
                type    : 'post',
                data    : {'position_dashboard_child' : elements_sorted_child},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
                .done(function (data) {

                })
                .fail(function (data) {
                    console.warn(data);
                });
        }
        function updSortChildTwoEl(){

            let elements_sorted_child_two = {};
            $('#pos__4 .nested-1').each(function(index){
                let el_id_child_two = $(this).attr('id').split('__');
                elements_sorted_child_two[index] = el_id_child_two[1];
            });

            $.ajax({
                url     : '{{ route('location.position') }}',
                type    : 'post',
                data    : {'position_dashboard_child_two' : elements_sorted_child_two},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                }})
                .done(function (data) {

                })
                .fail(function (data) {
                    console.warn(data);
                });
        }
        <!--[ End location position block  ]-->

        <!--[ mouse drag&drop visible ]-->
        $(document).ready(function()
        {
            $('.nested-1').hover(
                function(){ $(this).children('.drag_block_move').show();$(this).parent().children()[0].classList.add('top'); },
                function(){ $(this).children('.drag_block_move').hide();$(this).parent().children()[0].classList.remove('top'); }
            )

            $('#pos__1, #pos__2, #pos__3, #pos__4, #pos__5').hover(
                function(){ $(this).children('.drag_block_move').show(); },
                function(){ $(this).children('.drag_block_move').hide(); }
            )
        });
        <!--[ End mouse drag&drop ]-->

        <!--[ block width window 100% ]-->
        $(document).ready(function()
        {
            $('#pos__1 .gps_block_open, #pos__4 .gps_block_open').on('click', function(e){
                e.preventDefault();
                let parentEl = $(this).parent().parent().parent();
                console.log(parentEl);

                if(parentEl.hasClass( 'col-sm-12' )){
                    parentEl.removeClass('col-sm-12');
                    parentEl.addClass('col-sm-4');
                    parentEl.children().css("marginBottom", "0px");
                    parentEl.children().css("marginTop", "0px");
                    return;
                }

                if(parentEl.hasClass( 'col-sm-4' )){
                    parentEl.removeClass('col-sm-4');
                    parentEl.addClass('col-sm-12');
                    parentEl.children().css("marginBottom", "10px");
                    parentEl.children().css("marginTop", "10px");
                    return;
                }
            });

            $('#pos__3 .gps_block_open').on('click', function(e){
                e.preventDefault();
                let parentEl = $(this).parent().parent().parent();

                if(parentEl.hasClass( 'col-sm-12' )){
                    parentEl.removeClass('col-sm-12');
                    parentEl.addClass('col-sm-6');
                    parentEl.children().css("marginBottom", "0px");
                    parentEl.children().css("marginTop", "0px");
                    return;
                }

                if(parentEl.hasClass( 'col-sm-6' )){
                    parentEl.removeClass('col-sm-6');
                    parentEl.addClass('col-sm-12');
                    parentEl.children().css("marginBottom", "10px");
                    parentEl.children().css("marginTop", "10px");
                    return;
                }
            });
        });
        <!--[ End width window ]-->

        let map,
            marker = [];

        /**
         * Init map on page load
         */
        function initMap() {

            let myLatlng = new google.maps.LatLng( 50.415, 30.544);
            let mapOptions = {
                zoom: 4,
                center: myLatlng
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            marker = new google.maps.Marker({
                position: myLatlng,
                title:"Hi!"
            });
            marker.setMap(map);

        }

    </script>

    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&libraries=places&callback=initMap"
            defer></script>

@endpush