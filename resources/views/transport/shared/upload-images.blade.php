<div class="form-group">
    <div class="row flex">
        <div class="image-block">
            <label class="control-label"
                   for="">{{trans("all.transport_$type")}}</label>

            <div class="upload-block text-center">
                <div class="photo"
                     style="background-image: url({{ asset('/main_layout/images/svg/car.svg') }}">
                    <input type="file" id="{{$type}}trans-0" name="{{ $type }}[images][transport][]"
                           class="form-control photo-upload">
                </div>
                <label for="{{$type}}trans-0"
                       class="label-upload">{{ trans('all.upload_file') }}</label>
            </div>
        </div>

        <div class="image-block">
            <label class="control-label"
                   for="">{{trans('all.transport_teh_passport_photo')}}</label>

            <div class="upload-block text-center">
                <div class="photo"
                     style="background-image: url({{ asset('/main_layout/images/svg/text-lines-file.svg') }}">
                    <input type="file" id="{{$type}}doc-0" name="{{ $type }}[images][documents][]"
                           class="form-control photo-upload">
                </div>

                <label for="{{$type}}doc-0"
                       class="label-upload">{{ trans('all.upload_file') }}</label>
            </div>
        </div>
    </div>
</div>