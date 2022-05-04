@extends("layouts.app")

@section("content")

    <div class="content-box transport-page">

        <!-- Page title -->
        <div class="content-box__header clearfix">
            <div class="content-box__title">
                <h1 class="title-blue">{{trans('all.transport')}}</h1>
            </div>

            @can('create-transport')
            <div class="content-box__add-client">
                @if(\App\Services\SubscriptionService::checkAutoLimit())
                    <a href="{{ route('transport.create') }}" class="btn button-style1 transition">
                        <i class="fa fa-truck"></i>
                        {{ trans('all.add_transport') }}
                    </a>
                @else
                    <button type="button" class="btn button-block transition" disabled>
                        <span class="glyphicon glyphicon-lock" aria-hidden="true" style="margin-bottom: 10px;"></span>
                        <span>{{ trans('all.add_transport') }}</span>
                    </button>
                @endif
            </div>
            @endcan
        </div>

        <!-- Page filters -->
        @include('transport.partials.filters')

        <!-- Content -->
        <div class="app-progress-group">
            <div class="progress app-progress-bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                     aria-valuemax="100" style="width: 0%;"></div>
            </div>

            <!-- Tab panes -->
            <div id="transportsBox">
                @include('transport.partials.list-transports')
            </div>
        </div>
    </div>
    {{-- tutorials --}}
    @include('tutorials.tutorials')

@endsection
@section('modals')

    @include('profile.partials.create-edit-partner')

    @can('create-transport')
        @include('transport.partials.modals-tutorial')
    @endcan

@endsection

@push('scripts')
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/slick-carousel/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('bower-components/slick-carousel/slick/slick-theme.css') }}"/>
@endpush

@push('scripts')
    <script>
        var transport_text_delete = '{{ __('all.transport_modal_text_delete') }}';
        var btn_cancel = '{{ __('all.cancel') }}';
    </script>
    <script type="text/javascript" src="{{ url('bower-components/slick-carousel/slick/slick.min.js') }}" defer></script>
    <script type="text/javascript" src="{{url('/main_layout/js/transports.js')}}"></script>
    <script defer>
        $(function () {

            // Pagination
            $('#transportsBox').on('click', '.link-paginav a', function (e) {
                e.preventDefault();
                var url = $(e.target).attr('href');

                if (window.completedAjax) {
                    if(typeof window.progressBar === "function") {
                        window.progressBar( 70 );
                    }
                    $.get(url)
                     .done(function (data) {
                         if (data.status === 'success') {
                             $('#transportsBox').html(data.html);
                             $('#transportsBox .selectpicker').selectpicker('refresh');
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

            $('#transportsBox').on('click', '.panel-transport .panel-heading-trans', function (e) {
                let target  = $(e.target),
                    stopped = target.is(".btn-collapse") || target.is(".trash") || target.is(".filter-option") || target.is("span.text") || target.is(".label-status") || target.is('.transport-active') || target.is('.transport-active-span') || target.is('.toggle') || target.is('.caret');

                if (!stopped) {
                    $(this)
                        .find('.btn-collapse').toggleClass('collapsed').end()
                        .parent().find('.panel-collapse').collapse('toggle');
                }
            });
        });
    </script>
@endpush