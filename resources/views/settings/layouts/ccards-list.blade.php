@foreach($user->cards as $card)
    <div class="panel-group accordion-caret" id="accordion{{$loop->index}}">
        <div class="panel panel-default">
            <div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-target="#collapseCc{{$loop->index}}">
                <h3 class="panel-title">{{$card['n']}}</h3>
            </div>

            <div id="collapseCc{{$loop->index}}" class="panel-collapse collapse">
                <div class="panel-body">
                    @include('settings.layouts.ccards-create-form')
                </div>

                <div class="panel-footer text-right">
                    <input type="button" cid="{{$card['id']}}"
                           class="btn btn-success update_cc_ajax"
                           href="{{route('cc.edit.ajax')}}"
                           value="{{trans('all.edit')}}">

                    <input type="button" cid="{{$card['id']}}"
                           href="{{route('cc.remmove.ajax')}}"
                           class="btn btn-danger btn_remove_ccard"
                           value="{{trans('all.remove')}}">
                </div>
            </div>
        </div>
    </div>
@endforeach