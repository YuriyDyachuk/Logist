<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdate extends FormRequest
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
            /*'route_polyline'            => 'required|string',*/
            'direction_waypoints'       => 'json',
            'points.loading.*.address'  => 'required',
            'points.unloading.*.address'=> 'required',
            'points.loading.*.date_at'  => 'required|date_format:d/m/Y H:i',
            'points.unloading.*.date_at'=> 'required|date_format:d/m/Y H:i|after:points.loading.*.date_at',
            'recommend_price' => 'nullable|numeric|min:0',

            'partners_request'=> 'nullable',
            'partners'=> 'required_with:partners_request',
            'offer_partner'=> 'required_with:partners_request',
            'offer_partner_payment_type'=> 'required_with:partners_request',
            'offer_partner_payment_term'=> 'required_with:partners_request',
            /*'zxc'=> 'required',*/
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
            'required' => '',
        ];
    }
}
