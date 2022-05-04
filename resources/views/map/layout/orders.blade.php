<div class="row">
    @forelse($orders as $order)
        <div>
            <div class="col-xs-12">
                <button class="btn text-capitalize
                @if($order->status->name=="active"){{"btn-success draw_route_map"}} @endif
                @if($order->status->name == "completed"){{"btn-info draw_route_map"}} @endif
                @if($order->status->name == "canceled"){{"btn-danger"}} @endif
                @if($order->status->name == "search"){{"btn-warning"}} @endif
                @if($order->status->name == "planning"){{"btn-warning"}} @endif"
                @if($order->status->name == "active") url="{{route('map.route.ajax' ,$order->id)}}"@endif
                >{{$order->status->name}}
                </button>
                #{{$order->id}} {{$order->places['download'][0]['address']}} - {{$order->places['upload'][0]['address']}}
            </div>
            <div class="table">
                <div>
                    <div class="hidden-sm col-md-2">{{trans('all.client')}}</div>
                    <div class="hidden-sm col-md-3">{{trans('all.cargo')}}</div>
                    <div class="hidden-sm col-md-3">{{trans('all.transport')}}</div>
                    <div class="hidden-sm col-md-2">{{trans('all.date_download')}}</div>
                    <div class="hidden-sm col-md-2">{{trans('all.date_upload')}}</div>
                </div>
                <div>
                    <div class="col-sm-2">
                        {{$order->owner->name}}
                    </div>
                    <div class="col-sm-3">
                        {{$order->cargo['name']}}
                    </div>
                    <div class="col-sm-3">{{$order->transport->number}},
                        @foreach($order->performers as $performer)
                            {{$performer->name}} {{$performer->phone}}
                        @endforeach</div>
                    <div class="col-sm-2">{{$order->download_date}}</div>
                    <div class="col-sm-2">{{$order->upload_date}}</div>
                </div>
            </div>
        </div>
    @empty
        <div>{{trans('all.empty')}}</div>
    @endforelse
</div>