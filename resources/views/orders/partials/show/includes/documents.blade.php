<!-- Fourt tab: BEGIN -->
<div role="tabpanel" class="tab-pane fade transition animated fadeIn" id="documents">
    <div class="tab-pane__row">
        <h2 class="h2 title-block">{{ trans('all.documents') }}</h2>
        @if($order->hasStatus('active') || $order->hasStatus('planning'))
            <div class="content-box__add-document">
                <button type="button" class="btn button-style1 transition" data-toggle="modal"
                        data-target="#addDocument">
                    <i class="as as-adddocument"></i>
                    <span>{{ trans('all.upload_document') }}</span>
                </button>
            </div>
        @endif
    </div>

    <div class="documents-box" style="margin-bottom: 50px">
        @if($order->documents->count())
            @include('orders.partials.show.includes.list-documents')
        @else
            <h3 style="color: #a4a4a4">{{ __('all.documents_not_found') }}..</h3>
        @endif
    </div>
</div>

@php
    // TODO Remove in future
    $templates = $templates->filter(function ($value, $key) {
        return $value['id'] == 1 || $value['id'] == 4;
    });

@endphp

@section('modals')

    @include('documents.partials.modal_graph_sign')
    @include('documents.partials.modal_scan_sign')

    <!-- Modal -->
    <div class="modal" id="addDocument" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated zoomIn">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title title-blue">{{ trans('all.new_document') }}</h2>
                </div>

                <div class="modal-body">
                    <form id="formDocument" enctype="multipart/form-data">
                        <div class="form-group addon-file">
                            <label for="">{{ trans('all.document_name') }}</label>
                            <input id="" class="form-control" name="documentName" type="text" placeholder="{{ trans('all.select_file') }}">

                            <label for="newDoc" class="addon-file-label">{{ trans('all.file') }}</label>
                            <input type="file" name="image[]" id="newDoc">
                            <br>
                            <label class="upload_alternative" for="">{{ trans('all.upload_alternative') }}</label>
                            <!-- Список шаблонов -->
                            <select class="form-control m-bot15" name="form_id" id="form_id">
                                <option value="0" selected disabled >{{ trans('all.select_document') }}</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" >{{ trans('document.document_type_'.template_filename($template->slug)) }}</option>
                            @endforeach
                            </select>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn button-cancel" data-dismiss="modal">{{ trans('all.cancel') }}
                        <i>&times;</i></button>
                    <button type="button" id="addDocumentBtn" class="btn button-style1"
                            disabled><span>{{ trans('all.save') }}</span></button>
                </div>
            </div>
        </div>
    </div>
@endsection