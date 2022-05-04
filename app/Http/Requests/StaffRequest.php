<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            //
        ];
    }

	public function messages()
	{
		return [
			'required' => '',
			'before' => trans('validation.staff.before'),
			'driver_licence.required_if' => ' ',
			'password.regex' => trans('validation.staff.password_regex'),
			'password.min' => trans('validation.staff.password_min', ['min' => 8]),
			'passport.regex' => trans( 'validation.alpha_num'),
			'rate.required_if' => '',
			'percent.required_if' => '',
			'images.license.required_if' => trans('validation.staff.images_avatar_required'),
            'images.avatar.required' => trans('validation.staff.images_avatar_required'),
		];
	}
}
