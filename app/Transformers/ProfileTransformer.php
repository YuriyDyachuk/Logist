<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return $data;
    }
}