@forelse($options['documents_data'][$type_data] as $doc_item)
    <div>@if(isset($doc_item->doc_info['name'])) {{$doc_item->doc_info['name']}} : @endif</div>
    <div class="panel panel-primary">
        <div class="panel-body">
            {{trans('all.download')}} :
            <a href="{{HelperOption::doc_url($doc_item->filename)}}" target="_blank">
                {{$doc_item->filename}}
            </a>
        </div>
    </div>
@empty
    <{{trans('all.empty')}}>
@endforelse