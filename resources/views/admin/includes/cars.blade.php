@if($user->car)
    <div>
        <h4>{{trans('all.transport')}} № {{$user->car->car_number}}</h4>
        <div>
            <p>{{trans('all.driver\'s_license_number')}} : <strong>{{ $user->car->driver_license }}</strong></p>
            <p>{{trans('all.transport_car_type')}} : <strong>{{ $user->car->type }}</strong></p>
            <p>{{trans('all.transport_car_model')}} : <strong>{{ $user->car->model }}</strong></p>
            <p>{{trans('all.transport_car_number')}} : <strong>{{ $user->car->car_number }}</strong></p>
            <p>{{trans('all.transport_trailer_number')}} : <strong>{{ $user->car->trailer_number}}</strong></p>
            <p>{{trans('all.transport_car_year')}} : <strong>{{ $user->car->year }}</strong></p>
            <p>{{trans('all.transport_car_state')}} : <strong>{{ $user->car->state }}</strong></p>
            <p>{{trans('all.transport_car_tonnage')}} : <strong>{{ $user->car->tonnage }}</strong></p>
            <p>{{trans('all.transport_car_h_l_w')}} : <strong>{{ $user->car->h_l_w }}</strong></p>
            <p>{{trans('all.transport_car_bulk')}} : <strong>{{ $user->car->bulk }}</strong></p>
        </div>
        <div class="row">
            {{trans('all.transport_photo')}} : <br/>
            @include('includes.image_block', ['image_loop'=>$user->car->images, 'url' => $helper::carsUrl()])
        </div>

        <div class="row">
            {{trans('all.transport_teh_passport_photo')}} : <br/>
            @include('includes.image_block', ['image_loop'=>$user->carDocument, 'url' => $helper::documentUrl()])
        </div>

        <div class="row">
            {{trans('all.trailer_teh_passport_photo')}} : <br/>
            @include('includes.image_block', ['image_loop'=>$user->trailerDocument, 'url' => $helper::documentUrl()])
        </div>

    </div>
@else
    <{{trans('all.empty')}}>
@endif

