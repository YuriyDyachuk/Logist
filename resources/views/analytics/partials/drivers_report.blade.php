<div class="analytics-driver-report">

    <div class="container-fluid analytics-driver-report_table">
        <div class="content-box__filters">
            <form method="GET" action="" id="formFilters" class="form-inline">
                <div class="content-box__filter content-box__filter-username_search filter-float__right filter-ml-2">
                    <input name="filters[search]" id="search" class="form-control input-autocomplete" placeholder="{{ trans('all.search') }}" value="@if(isset($filters['search'])){{$filters['search']}}@endif" autocomplete="off">
                    <span id="searchclear">×</span>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>

        <div class="row analytics-driver-report__head">
            <div class="col-xs-12 col-sm-3">{{ trans('all.driver_fio') }}</div>
            <div class="col-xs-12 col-sm-2">{{ trans('all.transport_number') }}</div>
            <div class="col-xs-12 col-sm-3">Отчетный период</div>
            <div class="col-xs-12 col-sm-1">Сумма выплаты</div>
            <div class="col-xs-12 col-sm-3">{{ trans('all.status') }}</div>
        </div>
        {{--{{ var_dump($reports->toArray()) }}--}}
        @forelse ($reports as $report)
            <div class="row analytics-driver-report__card drv_report" data-driver="{{ $report->driver->id }}" data-report="{{ $report->id }}">
                <div class="col-xs-12 col-sm-3">
                    <div class="driver_name">{{ $report->driver->name }}</div>
                    <div class="driver_date">{{ \Carbon\Carbon::parse($report->updated_at)->format('Y.m.d') }}</div>
                </div>
                <div class="col-xs-12 col-sm-2 text-center">
                    <div class="text">{{ $report->transport->number }}</div>
                </div>
                <div class="col-xs-12 col-sm-3 text-center">
                    <div class="text">{{ $report->start_report }} - {{ $report->end_report ?? \Carbon\Carbon::now()->format('Y.m.d') }}</div>
                </div>
                <div class="col-xs-12 col-sm-1 text-center">
                    <div class="text"> {{ trans('all.UAH') }}</div>
                </div>
                <div class="col-xs-12 col-sm-3 text-center">
                    @if($report->status === 0)
                    <div class="status_sign sign"></div>
                    {{ trans('analytics.report_confirmed_wait') }}
                    @else
                        <div class="status_sign active"></div>
                        {{ trans('analytics.report_confirmed') }}
                    @endif
                </div>
            </div>
        @empty
            <div class="row analytics-driver-report__card drv_report" data-driver="1">
                <div class="col-xs-12 col-sm-3">
                    <p>{{ trans('all.empty') }}</p>
                </div>
            </div>
        @endforelse
        {{--
        <div class="row analytics-driver-report__card drv_report" data-driver="1">
            <div class="col-xs-12 col-sm-3">
                <div class="driver_name">Иванов Иван Петрович</div>
                <div class="driver_date">25.08.2020</div>
            </div>
            <div class="col-xs-12 col-sm-2 text-center">
                <div class="text">DAF 15456</div>
            </div>
            <div class="col-xs-12 col-sm-3 text-center">
                <div class="text">24.08.2020 - 23.09.2020</div>
            </div>
            <div class="col-xs-12 col-sm-1 text-center">
                <div class="text">15200 {{ trans('all.UAH') }}</div>
            </div>
            <div class="col-xs-12 col-sm-3 text-center">
                <div class="status_sign sign"></div>
                {{ trans('analytics.confirmed_wait') }}
            </div>
        </div>

        <div class="row analytics-driver-report__card drv_report">
            <div class="col-xs-12 col-sm-3">
                <div class="driver_name">Иванов Иван Петрович</div>
                <div class="driver_date">25.08.2020</div>
            </div>
            <div class="col-xs-12 col-sm-2 text-center">
                <div class="text">DAF 15456</div>
            </div>
            <div class="col-xs-12 col-sm-3 text-center">
                <div class="text">24.08.2020 - 23.09.2020</div>
            </div>
            <div class="col-xs-12 col-sm-1 text-center">
                <div class="text">15200 {{ trans('all.UAH') }}</div>
            </div>
            <div class="col-xs-12 col-sm-3 text-center">
                <div class="status_sign sign"></div>
                {{ trans('analytics.confirmed_wait') }}
            </div>
        </div>

        --}}

    </div>

    <div class="analytics-driver-report_details" style="">
    </div>
</div>
{{--
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">




            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
--}}



@push('scripts')
<script>
    $(function() {

        var driver_report_table = $('.analytics-driver-report_table');
        var driver_report_details = $('.analytics-driver-report_details');

        $('.drv_report').on('click', function(){

            let driver = $(this).data('driver');
            let report = $(this).data('report');

            console.log(driver);
            console.log(report);

            $.ajax({
                url: '{{route('analytics.drivers.report')}}',
                type: 'POST',
                dataType: 'JSON',
                data:{
                    driver: driver,
                    report : report
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
                },
                success: function (data) {
                    console.log(data);
                    driver_report_table.hide();
                    driver_report_details.empty().append(data.html).show();
                },
                error: function (data) {
                }
            });
        });

        $('#rowTab2 a').click(function (e) {
            driver_report_table.show();
            driver_report_details.hide();
        });

    });


</script>
@endpush
