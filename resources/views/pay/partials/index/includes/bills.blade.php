<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == 'bills' ? ' active in':''   }}" id="bills">
    <div class="col-xs-12 margin-bottom-lg padding-bottom-lg margin-top-lg text-left panel">
        {{ trans('all.bills') }}
        @if($transaction)
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('pay.transaction_created_at') }}</th>
                    <th>{{ trans('pay.transaction_amount') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i')}}</td>
                        <td>{{$item->amount}} {{$item->currency}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            {{ trans('pay.bills_no') }}
        @endif

    </div>
</div>