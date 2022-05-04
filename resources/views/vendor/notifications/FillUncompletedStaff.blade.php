<li class="list-group-item">
    <a href="{{ route('notification.show', $unreadNotification->id ) }}" role="button" data-notification="{{ $unreadNotification->id }}">
        Необходимо дозаполнить профиль пользователя {{ $unreadNotification->data['name'] }}
    </a>
</li>