@extends("layouts.app")
@section("content")

    <div class="content-box profile-page">
        @include('clients.partials.header')

        <div class="content-box__body-tabs" data-class="dragscroll">
            <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
                <li class="active transition">
                    <a href="#info" aria-controls="info" role="tab" data-toggle="tab">{{ trans('all.general_information') }}</a>
                </li>

                <li class="transition">
                    <a href="#history" aria-controls="history" role="tab" data-toggle="tab">{{trans('all.history')}}</a>
                </li>
            </ul>
        </div>

        <div class="content-box__body">
            <div class="tab-content">
                @include('clients.partials.general-info')
                @include('clients.partials.history')
            </div>
        </div>

        <div class="clear"></div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{ url('/main_layout/js/profile.js') }}"></script>

    <script>

        $(document).ready(function () {

            $('#addClient').on('submit', function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:"{{ route('partner.store') }}",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType:'json',
                })
                .done(function (data) {
                    console.log(data.status);
                    if (data.status === 'success') {
                        window.location.reload();
                    }
                })
                .fail(function (data) {
                    console.log(data);
                    appAlert('', 'Something went wrong... :(', 'warning');

                })
            });

        });


    </script>
@endpush