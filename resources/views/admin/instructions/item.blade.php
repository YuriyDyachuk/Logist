@php
$level[$current_level] = $instruction->list;
$current_level++;
@endphp
<li class="list-group-item">
    <div>
        <p>ID : <strong>{{$instruction->id}}</strong></p>
        <p>{{ trans('all.slug') }} : <strong>{{$instruction->slug}}</strong></p>
        <p>{{ trans('all.list_number') }} :
            {{ implode('.',$level) }}.
        </p>
        <a href="{{route('instructions.update', $instruction->id)}}"
           class="btn btn-sm btn-success">{{trans('all.edit')}}</a>
        <form action="{{route('instructions.destroy', $instruction->id)}}" method="post" class="inline-block">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit"
                    class="btn btn-sm btn-danger">{{trans('all.delete')}}</button>
        </form>
    </div>
</li>
@foreach($instruction->children() as $child)
    @include('admin.instructions.item', ['instruction' => $child, 'current_level' => $current_level, 'level' => $level])
@endforeach