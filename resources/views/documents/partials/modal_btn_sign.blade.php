<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ trans('all.documents_to_sign') }}
</button>
<div class="dropdown-menu">
    {{--<a class="dropdown-item col-xs-12" href="" data-toggle="modal" data-target="#graphSignScan" data-document="">Скан подпись</a>--}}
    <a class="dropdown-item col-xs-12" href="" data-toggle="modal" data-target="#graphSign" data-document="{{$document->id}}">{{ trans('all.document_btn_graph_sign') }}</a>
    <a class="dropdown-item col-xs-12" href="" data-toggle="modal" data-target="#scanSign" data-document="{{$document->id}}">{{ trans('all.document_btn_scan_sign') }}</a>
</div>