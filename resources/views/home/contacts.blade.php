@extends('layouts.app')

@section('content')
    <div class="content-box pay-page">

        <div class="content-box__header">
            <div class="content-box__title">
                <h1 class="h1 title-blue" id="titleType">
                    {{ trans('all.contacts') }}
                </h1>
            </div>
        </div>

        <!-- Content -->
        <div class="tab-content">
            <div class="col-xs-12 text-left panel contact-page padding-top-md">
                <div class="h4">
                    <i class="fa fa-envelope-open"></i> E-mail: <a href="mailto:info@inn-logist.com">info@inn-logist.com</a>
                </div>
                <div class="clearfix"></div>

                <div class="h4"><i class="fa fa-phone"></i> {{ trans('all.phone') }}: <a href="tel:+380505793560">+380505793560</a></div>
                <div class="clearfix"></div>

                <div class="h4"><i class="fa fa-address-card"></i> {{ trans('all.address') }}: Украина, г. Днепр, ул. Баррикадная 2</div>
                <div class="clearfix"></div>

                <div class="h4"><a href="https://www.facebook.com/inn.logist/" class="btn btn-facebook">&nbsp;</a></div>
                <div class="h4"><a href="https://t.me/inn_logist" class="btn btn-blue btn-telegramm"><i class="fa fa-telegram"></i></a></div>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
@endsection
