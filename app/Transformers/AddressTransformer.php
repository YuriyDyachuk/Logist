<?php

namespace App\Transformers;


use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'type'    => $address->pivot->type,
            'address' => $address->address,
            'date_at' => $address->pivot->date_at,
            'lat'     => $address->lat,
            'lng'     => $address->lng,
        ];
    }
}