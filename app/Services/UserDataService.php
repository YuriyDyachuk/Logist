<?php


namespace App\Services;

use App\Models\UserData;


class UserDataService {

	public function set($userID, $name, $value, $json = false)
	{
		if($json){
			$value = json_encode($value);
		}

		return UserData::updateOrCreate([
			'user_id' => $userID,
			'name' => $name,
		], [
			'value' => $value,
		]);
	}

	public function remove($user_id, $name)
	{
		$data = UserData::where('user_id', $user_id)->where('name', $name)->first();

		if($data)
		{
			$data->delete();
			return true;
		}

		return false;
	}

	public function get($user_id, $name, $json = false)
	{
		$data = UserData::where('user_id', $user_id)->where('name', $name)->first();
		if($data)
		{
			return $json ? json_decode($data->value) : $data->value;
		}

		return false;
	}

	public function all($user_id)
	{
		$items = UserData::where('user_id', $user_id)->get();

		if($items->isNotEmpty()){
			return $items->mapWithKeys(function ($item) {
				return [$item['name'] => $item['value']];
			});
		}

		return false;
	}

}