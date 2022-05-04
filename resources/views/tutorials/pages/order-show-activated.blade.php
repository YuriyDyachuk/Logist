@push('tutorials')
    @extends('tutorials.includes.layout')
    @section('titleTutorial', trans('tutorials.order-show-activated-title').' '.$order->id)
@section('tutorial')
    <div class="overlay_tutorial__text">{!! trans('tutorials.order-show-activated', ['num' => $order->id]) !!}</div>
@endsection
@endpush


@push('styles')
    <style>
        .overlay_tutorial__links {
            visibility: hidden;
        }

        .overlay_tutorial__arrow {
            display: none;
        }
    </style>
@endpush


@push('scripts')
    <script>

        $(window).on('load', function() {



        });

        function reset_css(){

        }

    </script>

@endpush

@include('tutorials.includes.common')