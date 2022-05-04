<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnTransport extends FormRequest
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
            'number'                => 'required|string|unique:transports,number',
            'trailerNumber'         => 'nullable|unique:transports,number',
            'driver_name'           => 'required',
            'driver_phone'          => 'required',
            'driver_licence'        => 'required',
            'images.driver_licence' => 'required',
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
            'number.required'         => trans('validation.number_transport_required'),
            'number.unique'           => trans('validation.number_transport_unique'),
            'trailerNumber.unique'    => trans('validation.trailerNumber_transport_unique'),
            'driver_name.required'    => trans('validation.driver_name_required'),
            'driver_phone.required'   => trans('validation.phone_required'),
            'driver_licence.required' => trans('validation.driver_licence_required'),
            'images.driver_licence.*' => trans('validation.driver_licence_image_required'),
        ];
    }
}