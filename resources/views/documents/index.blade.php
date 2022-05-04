@extends('layouts.app')
@section('content')

    <div class="content-box pay-page__OLD documents-page">

        @include('documents.partials.header')


        {{--<div class="content-box__body-tabs" data-class="dragscroll">--}}
        @include('documents.partials.nav-tabs')
        {{--</div><!-- \dragscroll -->--}}

        <!-- Content -->
        <div class="tab-content">
            @include('documents.includes.documents')
            @include('documents.includes.templates')
        </div>

    </div>

    @push('scripts')

        <script>
            $(function () {
                let a = document.querySelector('a#s');
                let hash = window.location.hash;

                if (hash) {
                    setTimeout(function(){
                        $(a).trigger('click');
                    }, 50);
                }

            });
        </script>

    @endpush

@endsection

@section('modals')

@endsection