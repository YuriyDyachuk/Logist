<li class="list-group-item">
    <a href="{{ route('notification.show', $unreadNotification->id ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        {!! trans('notification.partners_completed_order', ['Name' => '<strong>'.$unreadNotification->data['executor_name'] .'</strong>']) !!} <strong># {!!$unreadNotification->data['order_id'] !!}</strong>
    </a>
</li>