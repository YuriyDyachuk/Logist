@if($user->isLogistic())
    @foreach($documents_types as $documents_type)
        {{--TODO--}}
        @if(in_array($documents_type->id, [1,2,5]))
            @include('settings.layouts.includes.document-block-type', ['document_type_id' => $documents_type->id, 'document_type_name' => $documents_type->name])
        @endif
    @endforeach
@else
    @foreach($documents as $k => $document)
        @include('settings.layouts.includes.document-block-common')
    @endforeach
@endif