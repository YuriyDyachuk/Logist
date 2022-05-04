@extends("layouts.app")

@section("content")
    <div class="content-box order-new-page flight">
        <!-- Page title: BEGIN -->
        <div class="__header">
            <div class="content-box__title">
                <h1 class="h1">{{ trans('all.new_order') }}</h1>
            </div>
            <div class="__templates">
                <select id="select-template" class="form-control selectpicker" title="{{trans('all.order_templates')}}">
                    @forelse($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @empty
                        <option value="" disabled>{{ __('all.empty_list')}}</option>
                    @endforelse
                </select>
            </div>
        </div>
        <!-- Page title: END -->
        <form name="new-order" id="newOrder" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="order">
            <input type="hidden" name="order_id" value="{{ $orderId }}">

            <!-- Step #1 -->
            {{--@include('orders.partials.create.type')--}}

            <!-- Step #2 -->
            @include('orders.partials.create.flight')

                    <!-- Step #3 -->
            @include('orders.partials.create.cargo')

                    <!-- Step #4 -->
            @include('orders.partials.create.payment')
        </form>

        {{-- Additional field --}}
        {{--<div id="additionalField" style="display: none">--}}
        {{--@include('orders.partials.create.international-freight-block')--}}
        {{--</div>--}}

    </div>

    <style>
        #step-2 .panel-transport .btn-collapse:after{
            /*top: 16px;*/
            /*left: -225px;*/
        }
        #step-2 .panel-transport .btn-collapse{
            position: relative;
            margin-left: 16px;
        }
    </style>

    {{-- tutorials --}}
    @include('tutorials.tutorials')
@endsection
@push('scripts')

<script src="{{ url('main_layout/js/points.js') }}"></script>

<script async
        src="https://maps.googleapis.com/maps/api/js?key={{config('google.api_key')}}&language={{app()->getLocale()}}&libraries=places&callback=initMap"
        defer></script>
@endpush
