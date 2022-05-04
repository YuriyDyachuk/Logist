@extends('layouts.app')
@section('content')

    <div class="content-box pay-page">

        @include('faq.partials.header')

        <div class="content-box__body-tabs" data-class="dragscroll">
            @include('faq.partials.nav-tabs')
        </div><!-- \dragscroll -->

        <!-- Content -->
        <div class="tab-content">
            @include('faq.includes.instructions')
            @include('faq.includes.faqs')
        </div>

    </div>



    @push('scripts')

    @endpush

@endsection

@section('modals')

@endsection