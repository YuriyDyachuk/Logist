<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'transport_category';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rollingStockType()
    {
        return $this->belongsToMany(RollingStockType::class, 'transport_category_rolling_stock_type', 'category_id', 'rolling_stock_id');
    }

    /**
     * Get Transport's category
     *
     * @return mixed
     */
    public static function getCategory()
    {
        return self::where('parent_id', 0)->get();
    }

    /**
     * Get Transport's category
     *
     * @param int $categoryId
     * @return bool
     */
    public static function isSpecial($categoryId)
    {

        return self::where('id', $categoryId)->value('name') == 'special_machinery';
    }

    /**
     * Get the transport type for the specified category
     *
     * @param int $categoryId
     * @return mixed
     */
    public static function getType($categoryId)
    {
        return self::where('parent_id', $categoryId)->get();
    }

    /**
     * Get name category
     *
     * @param $categoryId
     * @return string $name
     */
    public static function getName($categoryId)
    {
        return self::findOrFail($categoryId)->name;
    }

    /**
     * @return \Illuminate\Support\Collection|[]
     */
    public static function getTrailersId() {
        return self::whereIn('name', ['trailer', 'semitrailer'])->pluck('id');
    }

    /**
     * @return \Illuminate\Support\Collection|[]
     */
    public static function getTrucksId() {
        return self::whereIn('name', ['tractor', 'truck'])->pluck('id');
    }

    public static function getAllWithKey(){
        $all = self::all();

        return  $all->mapWithKeys(function ($item) {
            return [$item['id'] => $item];
        });
    }
}
