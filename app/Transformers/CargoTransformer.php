<?php

namespace App\Transformers;


use App\Models\Order\Cargo;
use League\Fractal\TransformerAbstract;

class CargoTransformer extends TransformerAbstract
{
    public function transform(Cargo $cargo)
    {
        return [
            'name'            => $cargo->name,
            'length'          => $cargo->length,
            'height'          => $cargo->height,
            'width'           => $cargo->width,
            'weight'          => $cargo->weight,
            'volume'          => $cargo->volume,
            'places'          => $cargo->places,
            'temperature'     => $cargo->temperature,
            'hazard_class_id' => $cargo->hazard_class,
            'upload_type_id'  => $cargo->loading_type,
            'pack_type_id'    => $cargo->pack_type,
        ];
    }
}