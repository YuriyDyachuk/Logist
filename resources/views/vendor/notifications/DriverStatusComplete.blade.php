<li class="list-group-item">
    <div class="row" style="padding: 15px; margin: auto">
        <div class="col-md-12">
            {{ trans('all.driver_finish_order' , ['name' => \App\Models\User::find($unreadNotification->data['user'])->name]) }}
        </div>
        <div class="col-md-5 m-2">
            <form action="{{ route('orders.action') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="completed">
                <input type="hidden" name="orderId" value="{{$unreadNotification->data['order']}}">
                <input type="hidden" name="notificationId" value="{{$unreadNotification->id}}">
                <button type="submit" class="btn btn-info btn-lg button-green transition">{{ trans('all.finish') }}</button>
            </form>
        </div>
    </div>
</li>
