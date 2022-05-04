<li class="list-group-item" data-notification="{{$unreadNotification->id}}">
    <div class="row" style="padding: 15px; margin: auto">
        <div class="col-md-12">
            @php
                $notifications = \App\Models\User::find($unreadNotification->data['user']);
                $order = (isset($unreadNotification->data['order_id'])) ? $unreadNotification->data['order_id'] : '';
                $name = ($notifications) ? $notifications->name : '';
            @endphp
            {{ trans('notification.driver_change_status', ['Name' => $name, 'Order' => $order, 'Status' => $unreadNotification->data['status']]) }}
        </div>
        <div class="col-md-12 m-2">
            <a class="btn btn-info btn-lg button-green transition btn-notification" href="" role="button" data-notification="{{ $unreadNotification->id }}">Ok</a>
            @if(isset($unreadNotification->data['order_id']))
                <a class="btn btn-info btn-lg button-green transition btn-notification" href="/orders/{{$unreadNotification->data['order_id']}}" role="button" data-notification="{{ $unreadNotification->id }}">{{ trans('notification.go_to_order') }}</a>
            @endif
        </div>
    </div>
</li>