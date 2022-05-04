<div role="tabpanel" class="tab-pane fade transition animated fadeIn" id="history">

    <div class="tab-pane__row row">
        <div class="col-xs-12">
            <h2 class="h2 title-block">{{ trans('all.history') }}</h2>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <table class="table">
                @if($order->history)
                    @php
                        $i = 1;
                    @endphp
                    @foreach($order->history as $row)
                    <tr>
                        <td class="text-center">
                            {{$i}}
                        </td>
                        <td>
                            {{ $row->user->name }}
                        </td>
                        <td>
                            {{trans('all.role.'.$row->user->getRoleName())}}
                        </td>
                        <td class="text-center">
                            {{ trans('all.status_'.$row->status->name) }}
                        </td>
                        <td class="text-center">
                            {{Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i')}}
                        </td>
                        @php
                            $i++;
                        @endphp
                    </tr>
                    @endforeach
                @endif
        </table>
    </div>
</div>