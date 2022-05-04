<div class="editing-tools hidden transition">
    @can('edit-transport')
        <a href="{{ route('transport.edit', $transport->id) }}" class="edit"></a>
    @endcan
@if($status_name != 'on_flight')
    @can('create-transport')
        <span class="trash" data-transport-remove="{{$transport->id}}"></span>
    @endcan
@endif
</div>
