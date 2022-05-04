<?php

namespace App\Http\Requests;

use App\Http\Requests\StaffRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class StaffUpdate extends StaffRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

		return [
			'full_name'       => 'required|string|min:2|regex:/^[\pL\s\-0-9]+$/u',
			'phone'           => 'min:7|max:13',
//            'position'        => 'required|numeric',
			'password'        => 'nullable|min:8|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
			'passport'        => 'required|string',
			'birthday'        => 'required|date_format:"d/m/Y"|before:'.Carbon::now()->subYear(18)->toDateTimeString(),
            'inn_number'      => 'required|numeric',
			'driver_licence'  => 'required_if:position,3',
			'email'           => 'required|email|unique:users,email,'.$this->id.',id,deleted_at,NULL',
			'payment_type'    => 'required|numeric',
			'rate'            => 'required_if:payment_type,1,3|numeric|min:0',
			'percent'         => 'required_if:payment_type,2,3|numeric|min:0|max:100',
			'work_start'      => 'nullable|date_format:"d/m/Y"',
//			'functional_role' => 'required|string',
            'images.avatar'   => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
			'images.license'  => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
			'is_admin'        => 'nullable|numeric',
		];
	}

}
