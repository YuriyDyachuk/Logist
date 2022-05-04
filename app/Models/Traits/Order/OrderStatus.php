<?php

namespace App\Models\Traits\Order;

use App\Enums\OrderStatus as Statuses;
use App\Models\Status;

trait OrderStatus {

	private function getId($status_name){
		return Status::getId($status_name);
	}

	private function check($status_name){
		return ($this->current_status_id == $this->getId($status_name)) ? true : false;
	}

	public function isPlanning(){
		return $this->check(Statuses::PLANNING);
	}

	public function isCompleted(){
		return $this->check(Statuses::COMPLETED);
	}

	public function isActive(){
		return $this->check(Statuses::ACTIVE);
	}

	public function isCanceled(){
		return $this->check(Statuses::CANCELED);
	}
}