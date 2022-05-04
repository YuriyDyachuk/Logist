@if(array_key_exists($documents_type->id, $documents) )
    @foreach($documents as $k => $document)
        @if($document[0]->document_type_id == $document_type_id)
            @include('settings.layouts.includes.document-block-common')
        @endif
    @endforeach

@else
    <div class="form-group">
        <label class="control-label col-sm-6">{{trans('document.' . $document_type_name)}}</label>
        <div class="col-sm-6 text-right">
            <input type="file" name="images[documents][{{ $document_type_id }}][]" id="docs{{ $document_type_id }}" class="inputfile"
                   data-multiple-caption="{count} - {{trans('all.files_selected')}}"
                   multiple>

            <label for="docs{{ $document_type_id }}" class="btn btn-sm-create-app-def transition">
                <span>{{trans('all.add_files')}}</span>
            </label>
        </div>
        <div class="clearfix"></div>

    </div>
@endif



