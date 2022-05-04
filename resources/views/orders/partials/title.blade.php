@php($statusName = $order->getStatus()->name)

<label>{{ trans('handbook.' . $order->getCategoryName()) }}</label>

<div class="content-box__header">
    <div class="content-box__title">
        <h1 class="h1 title-blue"><span class="num-title-order">#{{ $order->inner_id }}({{ $order->id }})</span> <span>{{ $order->addresses->first()->address }}
                - {{ $order->addresses->last()->address }}</span></h1>

        @if(!$order->hasStatus('search'))
            <i class="marker-status marker-{{ $statusName }} transition">{{ trans('all.status_' . $statusName ) }}</i>
        @endif

        @isset($order->meta_data['comment'])
            <i class="info-notification rejection transition">?
                <span class="info-notification transition"><em>{{ $order->meta_data['comment'] }}</em></span></i>
        @endisset
    </div>
</div>