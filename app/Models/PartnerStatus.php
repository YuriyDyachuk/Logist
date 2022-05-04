<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerStatus extends Model
{
    protected $table = 'partners_status';

    const PENDING   = 'pending';
    const ACCEPTED  = 'accepted';
    const DECLINED  = 'declined';
    const BLOCKED   = 'blocked';

    public static function getId($name)
    {
        return self::where('name', $name)->value('id');
    }

    public static function getName($id)
    {
        return self::where('id', $id)->value('name');
    }

    public static function statuses(){
        $statuses = self::all();

        return $statuses->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
    }
}
