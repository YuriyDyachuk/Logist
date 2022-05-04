<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class GpsParameterHistory extends Model
{
	protected $table = "";

	public $timestamps = false;

	/**
	 * @param $companyId
	 * @param $transportId
	 * @param $paramId
	 *
	 * @return bool
	 */
	public function setParamTable($companyId, $transportId, $paramId){
		$this->table = 'yyy_ioparam_'.$companyId.'_'.$transportId.'_'.$paramId.'s';
		$check = Schema::hasTable($this->table);
		return $check;
	}

	/**
	 * @return string
	 */
	public function getParamTable(){
		return $this->table;
	}
}
