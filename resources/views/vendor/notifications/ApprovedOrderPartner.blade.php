<li class="list-group-item">
    <div class="row" style="padding: 15px; margin: auto">
        <div class="col-md-12">
            {{ trans('notification.partners_approved') }}
        </div>
        <div class="col-md-12 flex">
            <a class="btn-success btn-lg button-green transition btn-notification" href="" role="button" data-notification="{{ $unreadNotification->id }}">
                <!-- TODO добавить перевод -->
                Ok
            </a>
        </div>
    </div>
</li>