<div class="admining_list">
    <h2>{{trans('all.specialization')}}</h2>
    <table class="table table-bordered">
        @foreach($user->specializations as $specialization)
        <tr class="@if($specialization->accepted == 0)danger @else success @endif">
            <td colspan="2">
                <span class="bg bg-sp">{{ trans('all.'.$specialization->name )}}</span>
            </td>
        </tr>
        @endforeach
    </table>
</div>

