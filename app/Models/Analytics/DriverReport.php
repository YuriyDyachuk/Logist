<?php

namespace App\Models\Analytics;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Transport\Transport;
use App\Models\Analytics;
use App\Models\Order\Order;

use Illuminate\Database\Eloquent\Model;

class DriverReport extends Model
{
	protected $table = 'reports_drivers';

	protected $guarded = [];

	public function driver(){
		return $this->belongsTo(User::class, 'driver_id', 'id');
	}

	public function transport(){
		return $this->belongsTo(Transport::class, 'transport_id', 'id');
	}

	public function orders(){
		return $this->belongsToMany(Order::class, 'analytics', 'report_id', 'order_id');
	}

	public function getStartReportAttribute()
	{
		return Carbon::parse($this->start)->format('d.m.Y');
	}

	public function getEndReportAttribute($value)
	{
		return Carbon::parse($this->end)->format('d.m.Y');
	}
}
