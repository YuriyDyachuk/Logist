<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class CargoLoadingType extends Model
{
    protected $table = "cargo_loading_types";

    protected $fillable = [
        'slug',
        'name',
    ];

	public static function getName($id)
	{
		return self::findOrFail($id)->name;
	}

	public static function getSlug($id)
	{
		return self::findOrFail($id)->slug;
	}
}