@extends('admin.layouts.app')
@section('title', trans('all.user_instructions'))
@section('content')

    <section class="content-header">
        <h1>{{trans('all.user_instructions')}}
            <small>{{trans('all.admin_panel')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="col-xs-12 panel">
            <form action="{{ route('instructions.update', $instruction->id)  }}" method="post">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $instruction->id }}">

                    <div class="row">
                    <div class="col-xs-3">
                        <label for="slug">{{ trans('all.slug') }} :</label>
                    </div>
                    <div class="col-xs-9 @if($errors->has('slug')) has-error @endif">
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ $instruction->slug ? $instruction->slug : '' }}">
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-3">
                        <label for="parent_id">{{ trans('all.parent') }} :</label>
                    </div>
                    <div class="col-xs-9 @if($errors->has('parent_id')) has-error @endif">
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="0" @if(0 == $instruction->parent_id) selected="selected" @endif>{{ trans('all.root') }}</option>
                            @foreach($instructions as $item)
                                <option value="{{ $item->id }}" @if($item->id == $instruction->parent_id) selected="selected" @endif>{{$item->slug}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-3 @if($errors->has('type')) has-error @endif">
                        <label for="type">{{ trans('all.type') }} :</label>
                    </div>
                    <div class="col-xs-9">
                        <select id="type" name="type" class="form-control">
                            <option value="1" @if($instruction->type == 1) selected="selected" @endif>{{ trans('all.user_instructions') }}</option>
                            <option value="2" @if($instruction->type == 2) selected="selected" @endif>{{ trans('all.FAQs') }}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3 @if($errors->has('list')) has-error @endif">
                        <label for="list">{{ trans('all.list_number') }} :</label>
                    </div>
                    <div class="col-xs-9">
                        <input type="text" name="list" id="list" class="form-control" value="{{ $instruction->list ? $instruction->list : '' }}">
                    </div>
                </div>

                @foreach(config('app.locales') as $key => $locale)

                    <div class="row">
                        <div class="col-xs-12">
                            <h4>{{ $locale }}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                            <label for="title">{{ trans('all.title') }} :</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" name="title[{{$key}}]" id="title" class="form-control" value="{{ $instruction->title[$key] ? $instruction->title[$key] : '' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                            <label for="text">{{ trans('all.text') }} :</label>
                        </div>
                        <div class="col-xs-9">
                            <textarea name="text[{{$key}}]" id="text" class="form-control textarea">{{ $instruction->text[$key] ? $instruction->text[$key] : '' }}</textarea>
                        </div>
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-xs-12">
                        <input type="submit" value="{{ trans('all.save') }}" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">

        $('.textarea').wysihtml5();

    </script>
@endsection