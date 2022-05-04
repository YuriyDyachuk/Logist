<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Http\Requests\StaffRequest;

class StaffStore extends StaffRequest
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
            'position'        => 'required|numeric',
            'password'        => 'required|min:8|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            'passport'        => 'nullable|regex:/^[\pL\s\-0-9]+$/u',
            'birthday'        => 'nullable|date_format:"d/m/Y"|before:'.Carbon::now()->subYear(18)->toDateTimeString(),
            'inn_number'      => 'nullable|numeric',
//            'driver_licence'  => 'required_if:position,3',
            'driver_licence'  => 'nullable',
            'email'           => 'required_unless:position,3|nullable|email|unique:users,email,NULL,id,deleted_at,NULL',
            'payment_type'    => 'required|numeric',
            'rate'            => 'required_if:payment_type,1,3|numeric|min:0',
            'percent'         => 'required_if:payment_type,2,3|numeric|min:0|max:100',
            'work_start'      => 'nullable|date_format:"d/m/Y"',
//            'functional_role' => 'required|string',
            'images.avatar'   => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
//            'images.license'  => 'required_if:position,3|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'images.license'  => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'is_admin'        => 'nullable|numeric',
        ];
    }

	public function messages()
	{
		return [
			'email.required_unless' => trans('validation.required_name'),
			'images.license.required_if' => trans('validation.required_name'),
			'driver_licence.required_if'    =>  trans('validation.required_name'),
		];
	}
}
