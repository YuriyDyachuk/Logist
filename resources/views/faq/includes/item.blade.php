@php
$level[$current_level] = $item->list;
$current_level++;
@endphp

<div class="col-xs-12 margin-bottom-lg @if($loop->first) margin-top-lg @endif text-left panel">
    <div class="title collapsed" data-toggle="collapse" data-target="#{{$item->slug}}_fulltext" style="display: block; cursor: pointer">
        <h5 class="title-grey label-card">
            {{ implode('.',$level) }}. {{ trans('instructions.' . $item->slug . '_title') }}
        </h5>
    </div>

    <div class="collapse" id="{{$item->slug}}_fulltext">
        <div class="card card-body">
            {!! trans('instructions.' . $item->slug . '_html') !!}

            @foreach($item->children() as $child)
                @include('faq.includes.item', ['item' => $child, 'current_level' => $current_level, 'level' => $level])
            @endforeach

        </div>
    </div>
</div>
<div class="clearfix"></div>