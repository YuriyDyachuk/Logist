@forelse($list as $item)
    {{trans("all.card_name")}} : {{$item->lastFour}}
    @if(!$loop->last)
        <br/>
    @endif
@empty
    <{{trans('all.empty')}}>
@endforelse