<div class="form-group{{ $errors->has('images.documents'.$document[0]->name.'.*') || !$document[0]->verified ? ' has-error' : '' }}">
    <label class="control-label col-sm-6">{{trans('document.' . $document[0]->getName())}}</label>
    <div class="col-sm-6 text-right">
        <input type="file" name="images[documents][{{ $document[0]->document_type_id }}][]" id="docs{{$loop->index}}" class="inputfile"
               data-multiple-caption="{count} - {{trans('all.files_selected')}}"
               multiple>

        <label for="docs{{$loop->index}}" class="btn btn-sm-create-app-def transition">
            <span>{{trans('all.add_files')}}</span>
        </label>
    </div>

    @if ($errors->has('images.documents'.$document[0]->name.'.*'))
        <span class="col-xs-12 help-block small"><strong>{{ $errors->first('images.documents'.$document[0]->name.'.*') }}</strong></span>
    @endif

    @unless ($document[0]->verified)
        <div class="col-xs-12 help-block small">{{ trans('all.data_not_accepted') }}</div>
    @endunless

    <div class="clearfix"></div>

    @includeWhen($document[0]->filename, 'includes.image_block', ['image_loop'=> $document['files'], 'url' => $helper::documentUrl()])
</div>