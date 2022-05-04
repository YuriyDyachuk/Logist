<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class BaseModel extends Model
{
	protected $dateFormat = 'Y-m-d H:i:sO';
}
