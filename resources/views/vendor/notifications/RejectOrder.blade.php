<li class="list-group-item">
    <a href="{{ route('orders.show', $unreadNotification->data['order_id'] ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        <strong>{{ $unreadNotification->data['executor_name'] }}</strong> отказался от заказа #{{ $unreadNotification->data['order_id'] }}
    </a>
</li>