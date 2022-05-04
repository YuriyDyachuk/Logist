<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Model;

class StatCompany extends Model
{
    protected $table = 'stat_companies';

    protected $fillable = ['user_id', 'distance', 'distance_empty', 'fuel', 'duration', 'amount'];
}
