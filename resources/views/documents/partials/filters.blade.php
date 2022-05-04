<div class="content-box__filters">
    <form method="POST" action="" id="formFilters" class="clearfix">
    <div class="content-box__filter-date" style="display: none;">
        <label for="date" class="h5 title-grey">{{trans('all.date')}}:</label>
        <input id="date" type="text" name="filters[date]" class="datepicker" value="@if(isset($filters['date'])) {{$filters['date']}} @endif" onblur="">
    </div>

    <div class="content-box__filter content-box__filter-period filter-mr-2">
        <label for="date" class="label-filter">{{ trans('all.period') }}</label>
        <input type="text" name="filters[dates]" class="inputDaterangepicker" value="" onblur="">
    </div>

    <div id="orderFilter" class="content-box__filter content-box__filter-status">
        <label for="order_status" class="label-filter">{{ trans('all.status') }}</label>
        <select id="status" name="filters[status]" class="form-control selectpicker" item-filter>
            <option value="" selected>{{trans('all.all' )}}</option>
        </select>
    </div>
    </form>
</div>

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>


    $(document).ready(function () {
//        $('.datepicker').datetimepicker({
//            format: 'DD/MM/YYYY',
//            showClear: true,
//            showTodayButton: true
//        });
//
//
//        $('.datepicker').on('dp.change', function(){
//            console.log('d');
//            form_submit();
//        });
//
//
//        $('#status').on('change', function() {
//            form_submit();
//        });


        moment.locale('{{ app()->getLocale() }}');

        $('input[name="filters[dates]"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                "format": "DD/MM/YYYY",
                "separator": "-",
                "applyLabel": "{{ trans('all.select') }}",
                "cancelLabel": "{{ trans('all.clean') }}",
                "firstDay": 1
            },
        });

        @php
            if(isset($filters['dates']) && $filters['dates'] != ''){
                $dates = explode('-', $filters['dates']);
                $start = $dates[0];
                $end = $dates[1];
            }
        @endphp

	    <?php if(isset($start) &isset($end)  ){?>
        $('input[name="filters[dates]"]').data('daterangepicker').setStartDate(<?php echo $start;?>);
        $('input[name="filters[dates]"]').data('daterangepicker').setEndDate(<?php echo $end;?>);
        $('input[name="filters[dates]"]').val('<?php echo $start;?>-<?php echo $end;?>')
	    <?php } ?>


        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="filters[dates]"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
            form_submit();
        });


        $('input[name="filters[dates]"]').on('cancel.daterangepicker', function(ev, picker) {
            $('input[name="filters[dates]"]').val('');
            form_submit();
        });

        function form_submit() {
            var data = $('#formFilters').serialize();
            console.log(data);
            window.location.href = "?"+data;
        }
    });



</script>
@endpush