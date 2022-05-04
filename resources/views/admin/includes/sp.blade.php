@forelse($sp_list as $key => $item)
    @php
        $n = $key +1;
    @endphp
    <div class="block">{{$n}}) {{$item['path']}}</div>
@empty
    <{{trans('all.empty')}}>
@endforelse