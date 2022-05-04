@foreach($order->documents as $document)
    <div class="item" data-document="{{ $document['id'] }}">
        <div class="row flex align-center">
            <div class="col-xs-12 col-sm-6 flex align-center">
                <div class="document-type">
	                <?php $file = explode('.', $document['filename']);?>
                    @if(end($file) == 'pdf')
                        <i class="as as-pdf"></i>
                    @else
                        <i class="as as-img"></i>
                    @endif
                </div>

                <div class="details">
                    @php
                        $trans = 'document.document_type_'.template_filename($document['name']);

                        if(\Lang::has($trans))
                            $title = trans($trans);
                        else
                            $title = trans( 'document.document_type_order_request');

                    @endphp

                    <h4 class="h4">{{ $title }}</h4>
                    <small>{{ date('d-m-Y', strtotime($document['updated_at'])) }}</small>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 ">
                <div class="inline col-xs-12 padding-left-0 text-center">
                    @php
                        $isSigned = $document->isSigned();
                    @endphp

                    @if($isSigned == 1)
                        <div class="inline">{{ trans('all.document_signed') }}</div>
                    @elseif($isSigned == 0 && auth()->user()->isLogistic())
                        <div class="inline">{{ trans('all.document_sign_wait_client') }}</div>
                    @elseif($isSigned == 0 && auth()->user()->isClient())
                        <div class="inline">{{ trans('all.document_sign_wait_cargo') }}</div>
                    @else
                        <div class="inline">{{ trans('all.document_sign_wait') }}</div>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-4 col-sm-2 ">
                @if($isSigned == -1)
                    @include('documents.partials.modal_btn_sign')
                @endif
            </div>
            <div class="col-xs-4 col-sm-2">
                <div class="tools flex flex-end align-center">
                    <a id="linkDown{{ $document['id'] }}"
                        @if(!empty($document['filename']) && $document['filename'] != 'template')
                            href="{{ route('documents.download', $document['filename']) }}">

                        @elseif (!empty($document['filename']) && $document['filename'] == 'template')
                            href="{{route('documents.download_document', [ 'id' => $order->id, 'document_item' => $document->template_id])}}">
                        @else
                            href="javascript://" class="no-file">
                        @endif
                        <label for="linkDown{{ $document['id'] }}"><i class="fa fa-cloud-download" aria-hidden="true"></i></label></a>


                    @if(!empty($document['filename']) && $document['filename'] != 'template')
                        {{--<a id="" target="_blank" href="{{ route('documents.preview', $document['filename']) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>--}}
                        <a id="" target="_blank" href="{{ route('documents.preview.stored', ['doc_id' => $document['id']]) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    @endif

                    @if($order->hasStatus('active') || $order->hasStatus('planning'))

                        @php
                        /*
                        @if($document['filename'] != 'template')
                        <a href="javascript://">
                            <label for="document-{{ $document['id'] }}"><i class="fa fa-cloud-upload"
                                                                           aria-hidden="true"></i></label></a>
                        @endif
                        */
                        @endphp

                        <a href="{{ route('documents.destroy', ['id' => $document['id']]) }}" class="btn-destroy-doc"><i class="as as-del"></i></a>
                    @endif

                    <form enctype="multipart/form-data" id="addDocument-{{ $document['id'] }}" class="hidden">
                        <input type="hidden" name="documentId" value="{{ $document['id'] }}">
                        <input type="file" name="images[]" class="update-document" id="document-{{ $document['id'] }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach