<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == 'templates' ? ' active in':''   }}" id="templates">
    <div class="templates_list" style="margin-top: 20px;">
        @foreach($templates as $template)
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="{{ route('documents.template.edit', ['id' => $template->id]) }}">
                    <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                        <div class="document_icon_wrap">
                            <div class="document_icon PDF"></div>
                        </div>
                        <h5 class="title-grey label-card">
                           {{ trans('document.document_type_'.template_filename($template->slug) ) }}
                        </h5>
                    </div>
                    </a>

                </div>
        @endforeach
    </div>
</div>