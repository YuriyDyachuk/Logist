@extends('layouts.app')

@section('content')
    <div class="content-box pay-page">

        <div class="content-box__header">
            <div class="content-box__title">
                <h1 class="h1 title-blue" id="titleType">
                    {{ trans('all.improve_system') }}
                </h1>
            </div>
        </div>

        <!-- Content -->
        <div class="tab-content">
            <div class="col-xs-12 text-left panel">
                <form action="{{route('improve.submit')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('post')}}

                    <div class="form-feedback">
                        <fieldset class="padding-top-lg">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <div class="margin-bottom-sm @if($errors->has('name')) has-error @endif">
                                <input class="transition form-control" type="text" name="name" value="{{ old('name') }}" placeholder="{{ trans('all.name') }}" required="">
                            </div>

                            <div class="margin-bottom-sm @if($errors->has('email')) has-error @endif">
                                <input class="transition form-control" type="text" name="email" placeholder="{{ trans('all.email_address') }}" value="{{ old('email') }}" required="">
                            </div>

                            <div class="margin-bottom-sm @if($errors->has('subject')) has-error @endif">
                                <input class="transition form-control" type="text" name="subject" placeholder="{{ trans('all.subject') }}" value="{{ old('subject') }}" required="">
                            </div>

                        </fieldset>
                        <fieldset class="text-message">
                            <div class="margin-bottom-sm @if($errors->has('subject')) has-error @endif">
                                <textarea name="message" required="" class="transition form-control" placeholder="{{ trans('all.message') }}">{{ old('message') }}</textarea>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="margin-bottom-lg">
                                <input type="file" name="file[]" id="file" class="form-control inputfile"
                                       data-multiple-caption="{count} - {{trans('all.files_selected')}}" multiple>
                                <label for="file" class="transition">
                                    <span>{{trans('all.upload_file')}}</span>
                                </label>
                            </div>
                        </fieldset>

                        <fieldset class="margin-bottom-lg">
                            <input type="submit" class="btn btn-success" value="{{ trans('all.submit') }}">
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
