
<h2 class="h2 title-block">{{trans('all.specialization')}}</h2>

@foreach($user->specializations as $specializations)
    <div class="form-group px-15 d-inline-block">
        <input type="hidden" class="hidden_input" value="{{$specializations->id}}">
        <span class="bg bg-info bg-sp">{{ trans('all.'.$specializations->name )}}</span>
        {{--<div>--}}
        {{--<button class="btn btn-danger btn_remove_spec_item" rel="{{$specializations->id}}">--}}
        {{--<i class="glyphicon glyphicon-remove"></i></button>--}}
        {{--</div>--}}
    </div>
@endforeach

<div class="spsecialization_list"></div>

<div class="text-right">
    {{--<button class="btn btn-success save_specializations"--}}
            {{--href="{{route('sp.save.ajax')}}">{{trans('all.save')}}</button>--}}
    {{--<button class="btn btn-info add_specialization"--}}
            {{--href="{{route('sp.get.ajax')}}">{{trans('all.add')}}</button>--}}
</div>

{{--@if(isset($userData['new_sp']))--}}
{{--<div class="error-content">{{trans('all.data_not_accepted')}}</div>--}}
{{--@endif--}}

<div class="clearfix"></div>

<hr>
