<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStore extends FormRequest
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
            /* step 1 */
            /*'route_polyline'            => 'required|string',*/
            'direction_waypoints'       => 'json',
            'points.loading.*.address'  => 'required',
            'points.unloading.*.address'=> 'required',
            'points.loading.*.date_at'  => 'required|date_format:d/m/Y H:i',
            'points.unloading.*.date_at'=> 'required|date_format:d/m/Y H:i|after_or_equal:points.loading.*.date_at',

            /* step 2 */
            'cargo_length'    => 'required|numeric|min:0',
            'cargo_height'    => 'required|numeric|min:0',
            'cargo_width'     => 'required|numeric|min:0',
            'cargo_weight'    => 'required|numeric|min:0',
            'cargo_volume'    => 'required|numeric|min:0',
            'cargo_places'    => 'nullable|numeric|min:0',
            'cargo_upload'    => 'required',
            'cargo_temperature' => 'nullable|numeric|min:-20',
            'cargo_name'      => 'required',

            /* step 3 */
            'payment_type'    => 'required',
            'payment_terms'   => 'required',
            'recommend_price' => 'required|numeric|min:1',
	        'debtdays'        => 'nullable|numeric|min:0'
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
