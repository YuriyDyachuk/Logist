<div class="admining_list">
    <h2>{{trans('all.trailer')}}</h2>
    <table class="table table-bordered">
        @forelse($transports['trailer'] as $transport)
            <tr class="@if($transport->verified == 0)danger @else success @endif">
                <td colspan="2">
                    <span class="bg bg-sp">{{$transport->model}} {{$transport->year}}({{$transport->number}})</span>
                </td>
            </tr>
        @empty
            {{'<' . trans('all.empty') . '>'}}
        @endforelse
    </table>
</div>