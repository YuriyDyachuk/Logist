<?php
/**
 * Author: Vitalii Pervii
 * Author URI: https://www.amconsoft.com/
 * Date: 04.06.2018
 */

namespace App\Services;


use League\Fractal\Serializer\ArraySerializer;

class DataArraySerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return array($resourceKey ?: 'data' => $data);
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return array($resourceKey ?: 'data' => $data);
    }
}