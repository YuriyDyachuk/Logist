<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class RollingStockType extends Model
{
    protected $table = "transport_rolling_stock_type";

    public $timestamps = false;

    /**
     * Get a list of groups for transport rolling stock types.
     *
     * @return mixed
     */
    public static function getGroups()
    {
        return static::where('parent_id', 0)->get();
    }

    /**
     * Get name
     *
     * @param $id
     * @return mixed
     */
    public static function getName($id)
    {
        return self::findOrFail($id)->name;
    }

    public static function getAllWithKey(){
        $all = self::all();

        return  $all->mapWithKeys(function ($item) {
            return [$item['id'] => $item];
        });
    }
}
