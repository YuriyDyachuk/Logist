<div class="photos photos-slider">

    @php
        $images = [];
        $imgTrailerOrTruck = [];
        $docTrailerOrTruck = [];
        if($transport->trailer){
             $imgTrailerOrTruck = $transport->trailer->images()->get()->toArray();
             //$docTrailerOrTruck = $transport->trailer->getPassport()->images()->get()->toArray();
             $docTrailerOrTruck = $transport->trailer->getPassport()->toArray();
        }
        if($transport->truck){
             $imgTrailerOrTruck = $transport->truck->images()->get()->toArray();
             //$docTrailerOrTruck = $transport->truck->getPassport()->images()->get()->toArray();
             $docTrailerOrTruck = $transport->truck->getPassport()->toArray();
        }

        $images['transport'] = array_merge($transport->images()->get()->toArray(), $imgTrailerOrTruck);
        //$images['documents'] = array_merge($transport->getPassport()->images()->get()->toArray(), $docTrailerOrTruck);
        $images['documents'] = array_merge($transport->getPassport()->toArray(), $docTrailerOrTruck);
    @endphp

    {{--Transport --}}
    <div>
        <button type="button"
                class="btn btn-image"
                style="background-image: url({{ count($images['transport']) ?  \Image::getPath('transports', $images['transport'][0]['filename']) : '' }})"
                {{ count($images['transport']) ? 'show-photo' : 'disabled' }}
        >
            <div class="photo" style="display: none">
                @foreach($images['transport'] as $image)
                    <a href="{{ \Image::getPath('transports', $image['filename']) }}"></a>
                @endforeach
            </div>
        </button>
    </div>

    {{--Documents --}}
    <div>
        <button type="button"
                class="btn btn-image"
                style="background-image: url({{ count($images['documents']) ?  \Image::getPath('documents', $images['documents'][0]['filename']) : '' }})"
                {{ count($images['documents']) ? 'show-photo' : 'disabled' }}
        >
            <div class="photo" style="display: none">
                @foreach($images['documents'] as $image)
                    <a href="{{ \Image::getPath('documents', $image['filename']) }}"></a>
                @endforeach
            </div>
        </button>
    </div>

    {{--Driver  --}}
    @php
        $paths = [];
        if (isset($transport->_driver)){
            foreach($transport->_driver->documents as $document){
                //foreach($document->images as $image){
                    array_push($paths, \Image::getPath('documents', $document->filename));
               // }
            }
        }
    @endphp
    <div>
        <button type="button"
                class="btn btn-image"
                style="background-image: url({{ count($paths) ?  $paths[0] : '' }})"
                {{ count($paths) ? 'show-photo' : 'disabled' }}
        >
            <div class="photo" style="display: none">
                @foreach($paths as $url)
                    <a href="{{ $url }}"></a>
                @endforeach
            </div>
        </button>
    </div>
</div>
