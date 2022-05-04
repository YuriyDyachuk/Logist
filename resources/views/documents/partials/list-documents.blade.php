<div class="col-xs-12 margin-bottom-lg padding-bottom-lg text-left panel">
    @foreach($documents as $document)
        <div class="content-box__row">
            <div class="col-xs-4">
                <div class="document_icon_wrap">
                    <div class="document_icon {{ $document->documents_form->format }}">
                    </div>
                </div>
                <div class="document_info text-left">
                    <div class="h5">#{{$document->imagetable->id }} {{ trans('document.document_type_'.template_filename($document->documents_form->slug)) }}.{{$document->documents_form->format}}</div>
                    <div class="date">{{ date("d/m/Y", strtotime($document->created_at)) }}</div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-xs-2 text-center hidden">
                <h5 class="title-grey label-card">{{ trans('all.contragent') }}</h5>
                @php
                    $this->id2 = $document->imagetable->user_id;
                @endphp
                {{Auth::user()->name}}
            </div>
            <div class="col-xs-2 text-center">
                <h5 class="title-grey label-card">{{ trans('all.order_number') }}</h5>
                {{ $document->imagetable->id }}
            </div>
            <div class="col-xs-2">
                <h5 class="title-grey label-card">{{ trans('all.status') }}</h5>
                <div class="inline col-xs-12 padding-left-0 text-center">
                    @php
                        $isSigned = $document->isSigned();
                    @endphp

                    @if($isSigned == 1)
                        <div class="status_sign active inline"></div>
                        <div class="inline">{{ trans('all.document_signed') }}</div>
                    @elseif($isSigned == 0 && auth()->user()->isLogistic())
                        <div class="status_sign sign"></div>
                        <div class="inline">{{ trans('all.document_sign_wait_client') }}</div>
                    @elseif($isSigned == 0 && auth()->user()->isClient())
                        <div class="status_sign sign"></div>
                        <div class="inline">{{ trans('all.document_sign_wait_cargo') }}</div>
                    @else
                        <div class="status_sign wait"></div>
                        <div class="inline">{{ trans('all.document_sign_wait') }}</div>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-2">
                @if($isSigned == -1)
                    @include('documents.partials.modal_btn_sign')
                @endif
            </div>
            <div class="col-xs-2 actions">
                @if(file_exists(public_path('storage/documents/').$document['filename']))
                    <a href="{{ route('documents.download', $document['filename']) }}">
                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                    </a>

                    {{--<a id="" target="_blank" href="{{ route('documents.preview', $document['filename']) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>--}}
                    <a id="" target="_blank" href="{{ route('documents.preview.stored', ['doc_id' => $document['id']]) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

                @else
                    <small>Could not find file</small>
                @endif

                    <a href="{{ route('documents.destroy', ['id' => $document['id']]) }}" class="btn-destroy-doc"><i class="as as-del"></i></a>

            </div>
            <div class="clearfix"></div>
        </div>
    @endforeach

    {{ $documents->links() }}
</div>
<div class="clearfix"></div>

@include('documents.partials.modal_graph_sign')
@include('documents.partials.modal_scan_sign')

@push('scripts')

<script>

</script>

<script>
    $(document).ready(function () {

        $('.btn-destroy-doc').on('click', function (e) {
            e.preventDefault();

            appConfirm('', '{{ trans('all.documents_delete_confirm') }}', 'question', function () {
                destroyDocument($(e.currentTarget))
            });
        });

        function destroyDocument($this) {
            var url = $this.attr('href');

            console.log();
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {_token: CSRF_TOKEN}
            })
                .done(function (data) {
                    console.log(data);
                    window.location.href = "/documents-list";
                })
                .fail(function (data) {
                    console.log(data);
                    appAlert('', 'Something went wrong... :(', 'warning');
                });
        }
    });
</script>
@endpush