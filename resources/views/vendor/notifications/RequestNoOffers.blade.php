<li class="list-group-item">
    <a class="btn-notification" href="{{ route('orders.show', $unreadNotification->data['order_id'] ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        <div class="description">
            {{ trans('notification.request_no_offers') }} <strong># {{ $unreadNotification->data['order_id'] }}</strong>
        </div>
        <div class="list-group-date"><small>{{ Carbon\Carbon::parse($unreadNotification->created_at)->format('d-m-Y H:i') }}</small></div>
    </a>
</li>
