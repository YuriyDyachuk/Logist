<div class="admining_list">
    <h2>{{trans('all.transports')}}</h2>
    <table class="table table-bordered">
        @forelse($transports['transport'] as $transport)
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