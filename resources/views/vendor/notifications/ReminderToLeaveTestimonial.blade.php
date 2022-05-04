<li class="list-group-item">
    <a href="{{ route('notification.show', $unreadNotification->id ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        {{ trans('all.testimonial_send_msg') }} <strong># {!!$unreadNotification->data['order_id'] !!}</strong>
    </a>
</li>