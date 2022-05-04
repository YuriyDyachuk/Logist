@extends('layouts.app')

@section('content')
<div class="content-box">
    <div class="content-box__header clearfix">
        <div class="content-box__title">
            <h1 class="title-blue">{{trans('all.mailer')}}</h1>
        </div>
    </div>

    <div class="content-box__body-tabs" data-class="dragscroll">
        <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
            <li class="{{ \Request::get('tab') === null ? ' active':''}} transition"><a href="#mailer" role="tab" data-toggle="tab">{{trans('all.mailer')}}</a></li>
            <li class="{{ \Request::get('tab') === 'settings' ? ' active':''}} transition"><a href="#settings" role="tab" data-toggle="tab">{{trans('all.settings')}}</a></li>
        </ul>
    </div>

    <div class="tab-content">
        @include('mailer.layouts.mailer')
        @include('mailer.layouts.settings')
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $('#btn-upd-email-service').on('click', function (e) {
            e.preventDefault();
            let data = new FormData();

            $.each($('.user_info__input input, .user_info__input select'), function(i, input) {
                data.append(input.name, input.value);
            });

            $.ajax({
                url: '{{ route('mailer.settings.update') }}',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "cache-control": "no-cache, no-store"
            }})
            .done( function (data) {
                if(data.redirect !== undefined){
                    window.location.replace(data.redirect);
                }
            })
            .fail(function (res) {
                if (res.status === 422) {
                    let msg = '';
                    $.each(res.responseJSON.errors, (index, value) => {
                        msg += '<p>' + index + ' : ' + value + '</p>';
                    });
                    appAlert('', msg, 'warning');
                } else {
                    let msg = '';
                    $.each(res.responseJSON.errors, (index, value) => {
                        msg += '<p>' +  value + '</p>';
                    });
                    appAlert('', msg, 'warning');
                }
            });
        });
    </script>
@endpush
