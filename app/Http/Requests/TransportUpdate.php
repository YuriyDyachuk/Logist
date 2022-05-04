<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TransportUpdate extends FormRequest
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
            'category'           => 'required',
            //            'type'               => 'required',
            'number'        => [
                'required',
                Rule::unique('transports', 'number')
                    ->where(function ($query) {
                        $query->whereNull('deleted_at');
                    })
                    ->ignore($this->segment(2)),
            ],
            'model'         => 'required',
            'year'          => 'required|max:4|date_format:"Y"|after:'.Carbon::now()->subYear(50)->toDateTimeString(),
            'tachograph'    => 'nullable|numeric',
            'tonnage'       => 'nullable|numeric',
            'volume'        => 'nullable|numeric',
            'width'         => 'nullable|numeric',
            'height'        => 'nullable|numeric',
            'length'        => 'nullable|numeric',
//            'gps_id'        => 'nullable|string',
            'gps_id'        => [
	            'nullable',
	            Rule::unique('transports', 'gps_id')
	                ->where(function ($query) {
		                $query->whereNull('deleted_at');
	                })
	                ->ignore($this->segment(2)),
            ],
            'tracker_imei'  => 'nullable|min:3|max:50',
            'insurance_id'  => 'nullable|string',
            'status'        => 'nullable|numeric',
            'login'              => [
                'nullable',
                'email',
                'min:6',
                'string',
                'required_unless:only_selected,trailer',
                Rule::unique('transports', 'login')->where(function ($query) {
                    $query->where('deleted_at', null);
                })->ignore($this->segment(2)),
                'regex:/^[A-Za-z0-9@.]+$/'
            ],
            'password'           => 'nullable|min:6|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            'images.*.*.*'       => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category.required' => trans('validation.required_name'),
            //            'type.required'     => trans('validation.required_name'),
            '*.number.required'   => trans('validation.number_transport_required'),
            '*.number.unique'     => trans('validation.number_transport_unique'),
            'model.required'    => trans('validation.required_name'),
            'year.required'     => trans('validation.required_name'),
            'year.max'          => strlen($this->get('year')),
            'year.password'     => trans('validation.required_name'),
            'login.unique'      => trans('validation.login_transport_unique'),
            'password.regex'    => trans('validation.staff.password_regex'),
            'after'             => trans('validation.car_year'),
            'regex'             => trans('validation.driver_login'),
        ];
    }

    public function attributes()
    {
        return [
            'auto.year' => trans('all.transport_year'),
        ];
    }
}
