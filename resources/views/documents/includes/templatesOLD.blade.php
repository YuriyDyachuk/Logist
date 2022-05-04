<div role="tabpanel" class="tab-pane fade{{ \Request::get('tab') == 'templates' ? ' active in':''   }}" id="templates">
    <div class="templates_list" style="margin-top: 20px;">
        @foreach($templates as $template)
            <form action="{{ route('documents.form.update', $template->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('post') }}
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="/documents-list/template-edit/{{$template->id}}">
                    <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                        <div class="document_icon_wrap">
                            <div class="document_icon PDF"></div>
                        </div>
                        <h5 class="title-grey label-card">
                           {{ trans('all.document_type_'.$template->slug) }}
                        </h5>
                    </div>
                    </a>

                    <div class="collapse padding-bottom-lg" id="{{$template->slug}}_fulltext">
                        @foreach($template->fields as $field)
                            <div>
                                <div class=" padding-top-lg">
                                    <label for="{{ $field->slug }}">{{ trans('all.'.$field->slug) }}</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="">
                                @if(App\Enums\DocumentFormFieldsTypes::TEXTAREA == $field->type)
                                    <textarea class="form-control" name="field[{{ $field->id }}]" id="{{ $field->slug }}">{{ $field->values ? $field->values->value : '' }}</textarea>
                                @elseif(App\Enums\DocumentFormFieldsTypes::INPUT == $field->type)
                                    <input class="form-control" type="text" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                @elseif(App\Enums\DocumentFormFieldsTypes::NUMBER == $field->type)
                                    <input class="form-control" type="number" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                @endif
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        <input type="submit" class="btn btn-success" value="{{ trans('all.save') }}">
                    </div>
                </div>
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="/documents-list/completion-edit/{{$template->id}}">
                        <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                            <div class="document_icon_wrap">
                                <div class="document_icon PDF"></div>
                            </div>
                            <h5 class="title-grey label-card">
                                Акт работ
                            </h5>
                        </div>
                    </a>

                    <div class="collapse padding-bottom-lg" id="{{$template->slug}}_fulltext">
                        @foreach($template->fields as $field)
                            <div>
                                <div class=" padding-top-lg">
                                    <label for="{{ $field->slug }}">{{ trans('all.'.$field->slug) }}</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="">
                                    @if(App\Enums\DocumentFormFieldsTypes::TEXTAREA == $field->type)
                                        <textarea class="form-control" name="field[{{ $field->id }}]" id="{{ $field->slug }}">{{ $field->values ? $field->values->value : '' }}</textarea>
                                    @elseif(App\Enums\DocumentFormFieldsTypes::INPUT == $field->type)
                                        <input class="form-control" type="text" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @elseif(App\Enums\DocumentFormFieldsTypes::NUMBER == $field->type)
                                        <input class="form-control" type="number" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @endif
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        <input type="submit" class="btn btn-success" value="{{ trans('all.save') }}">
                    </div>
                </div>
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="/documents-list/payment-edit/{{$template->id}}">
                        <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                            <div class="document_icon_wrap">
                                <div class="document_icon PDF"></div>
                            </div>
                            <h5 class="title-grey label-card">
                                Счет на оплату
                            </h5>
                        </div>
                    </a>

                    <div class="collapse padding-bottom-lg" id="{{$template->slug}}_fulltext">
                        @foreach($template->fields as $field)
                            <div>
                                <div class=" padding-top-lg">
                                    <label for="{{ $field->slug }}">{{ trans('all.'.$field->slug) }}</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="">
                                    @if(App\Enums\DocumentFormFieldsTypes::TEXTAREA == $field->type)
                                        <textarea class="form-control" name="field[{{ $field->id }}]" id="{{ $field->slug }}">{{ $field->values ? $field->values->value : '' }}</textarea>
                                    @elseif(App\Enums\DocumentFormFieldsTypes::INPUT == $field->type)
                                        <input class="form-control" type="text" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @elseif(App\Enums\DocumentFormFieldsTypes::NUMBER == $field->type)
                                        <input class="form-control" type="number" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @endif
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        <input type="submit" class="btn btn-success" value="{{ trans('all.save') }}">
                    </div>
                </div>
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="/documents-list/transport-edit/{{$template->id}}">
                        <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                            <div class="document_icon_wrap">
                                <div class="document_icon PDF"></div>
                            </div>
                            <h5 class="title-grey label-card">
                                Транспортная накладная
                            </h5>
                        </div>
                    </a>

                    <div class="collapse padding-bottom-lg" id="{{$template->slug}}_fulltext">
                        @foreach($template->fields as $field)
                            <div>
                                <div class=" padding-top-lg">
                                    <label for="{{ $field->slug }}">{{ trans('all.'.$field->slug) }}</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="">
                                    @if(App\Enums\DocumentFormFieldsTypes::TEXTAREA == $field->type)
                                        <textarea class="form-control" name="field[{{ $field->id }}]" id="{{ $field->slug }}">{{ $field->values ? $field->values->value : '' }}</textarea>
                                    @elseif(App\Enums\DocumentFormFieldsTypes::INPUT == $field->type)
                                        <input class="form-control" type="text" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @elseif(App\Enums\DocumentFormFieldsTypes::NUMBER == $field->type)
                                        <input class="form-control" type="number" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @endif
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        <input type="submit" class="btn btn-success" value="{{ trans('all.save') }}">
                    </div>
                </div>
                <div class="col-xs-3 padding-bottom-lg text-left panel template_item">

                    <a href="/documents-list/transport-table-edit/{{$template->id}}">
                        <div class="title collapsed" data-toggle="collapse" data-target="#1{{$template->slug}}_fulltext" style="display: block; cursor: pointer">
                            <div class="document_icon_wrap">
                                <div class="document_icon PDF"></div>
                            </div>
                            <h5 class="title-grey label-card">
                                Транспортная накладная
                            </h5>
                        </div>
                    </a>

                    <div class="collapse padding-bottom-lg" id="{{$template->slug}}_fulltext">
                        @foreach($template->fields as $field)
                            <div>
                                <div class=" padding-top-lg">
                                    <label for="{{ $field->slug }}">{{ trans('all.'.$field->slug) }}</label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="">
                                    @if(App\Enums\DocumentFormFieldsTypes::TEXTAREA == $field->type)
                                        <textarea class="form-control" name="field[{{ $field->id }}]" id="{{ $field->slug }}">{{ $field->values ? $field->values->value : '' }}</textarea>
                                    @elseif(App\Enums\DocumentFormFieldsTypes::INPUT == $field->type)
                                        <input class="form-control" type="text" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @elseif(App\Enums\DocumentFormFieldsTypes::NUMBER == $field->type)
                                        <input class="form-control" type="number" name="field[{{ $field->id }}]" id="{{ $field->slug }}" value="{{ $field->values ? $field->values->value : '' }}">
                                    @endif
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @endforeach

                        <input type="submit" class="btn btn-success" value="{{ trans('all.save') }}">
                    </div>
                </div>
            </form>
        @endforeach
    </div>
</div>