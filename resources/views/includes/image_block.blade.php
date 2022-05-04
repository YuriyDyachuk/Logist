<div class="tab-pane_col-slider transition ">
    @forelse($image_loop as $key => $image)
        @if($image['filename'] != null)
        @if($loop->first)
            <div id="" data-img-modal class="tab-pane_col-slider-img cartimage">
                <img src="{{ $url . '/' . $image['filename'] }}">
            </div>
        @endif


        @if($loop->first)
            <div id="" class="tab-pane_col-slider-thumb lightbox{{$loop->count > 1 ? '' : ' hidden'}}">
                @endif
                <a href="{{ $url . '/' . $image['filename'] }}" class="carthumb transition">
                    <img src="{{ $url . '/' . $image['filename'] }}">
                </a>
                @if($loop->last)
            </div>
        @endif
        @endif
    @empty
        <div class="alert alert-warning"><strong>{{trans('all.photo_not_uploaded')}}</strong></div>
    @endforelse
</div>

@push('scripts')
    <script>
        $('.cartimage').click(function () {
            var lightbox = $(this).siblings('.lightbox').find('a').simpleLightbox();

            lightbox.open();
        });
    </script>
@endpush