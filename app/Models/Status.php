<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];


    public static function getId($name)
    {
        return static::where('name', $name)->value('id');
    }

	public static function getStatusIdOrder($name)
	{
		return static::where('name', $name)->where('type', 'order')->value('id');
	}

    /**
     * @param $id
     * @return string $name
     */
    public static function getName($id)
    {
        $status = static::find($id);
        if ($status == null) {
            return 'inactive';
        }
        return $status->name;
    }

    /**
     * Get statuses for Transport
     *
     * @return mixed
     */
    public static function getTransports()
    {
        return static::where('type', 'transport')->get();
    }

    /**
     * Get statuses for Order
     *
     * @return mixed
     */
    public static function getOrders()
    {
        return static::where('type', 'order')->get();
    }

    public static function getOnFlightTransportStatusId(){
	    return static::where('name', 'on_flight')->value('id');
    }
}
