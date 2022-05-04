<li class="list-group-item">
    <a href="{{ route('notification.show', $unreadNotification->id ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        {{ trans('all.activate_order_full') }} <strong># {!!$unreadNotification->data['order_id'] !!}</strong>
    </a>
</li>