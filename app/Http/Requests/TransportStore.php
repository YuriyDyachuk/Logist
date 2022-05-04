<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TransportStore extends FormRequest
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
        $request = [
            'category'          => 'required',
            'only_selected'     => 'nullable',
            'images.*.*.*'      => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'tracker_imei'      => 'nullable|min:3|max:50'
        ];

        if(($this->request->get('selected') === 'train' || $this->request->get('selected') === 'coupling') && $this->request->has('only_selected')){
            $selected = $this->request->get('only_selected');

            $request = array_merge($request, $this->{$selected.'Request'}());
        }
        elseif($this->request->get('selected') === 'truck'){
            $request = array_merge($request, $this->autoRequest());
        }
        else {
            $request = array_merge($request, $this->autoRequest(), $this->trailerRequest());
        }

        return  $request;
    }

    private function trailerRequest(){
        return [
            'trailer.number'     => [
                'required',
//                'required_unless:selected,truck',
                Rule::unique('transports', 'number')
                    ->where(function ($query) {
                        $query->whereNull('deleted_at');
                    })
                    ->ignore($this->segment(2)),
            ],
            'trailer.model'      => 'required',
            'trailer.year'       => 'required|max:4',
            'trailer.tachograph' => 'nullable|numeric',
            'trailer.tonnage'    => 'required|numeric',
            'trailer.width'      => 'required|numeric',
            'trailer.height'     => 'required|numeric',
            'trailer.length'     => 'required|numeric',
        ];
    }

    private function autoRequest(){
        return [
            'auto.number'        => [
                'nullable',
                'string',
                Rule::unique('transports', 'number')
                    ->where(function ($query) {
                        $query->whereNull('deleted_at');
                    })
                    ->ignore($this->segment(2)),
            ],
            'auto.model'         => 'required|string',
            'auto.year'          => 'required_if:selected,truck|nullable|max:4|date_format:"Y"|after:'.Carbon::now()->subYear(50)->toDateTimeString(),
            'auto.truck_year'    => 'required_if:selected,coupling|nullable|max:4|date_format:"Y"|after:'.Carbon::now()->subYear(50)->toDateTimeString(),
            'auto.tachograph'    => 'nullable|numeric',
            'auto.tonnage'       => 'required_if:selected,truck',
            'auto.width'         => 'required_if:selected,truck',
            'auto.height'        => 'required_if:selected,truck',
            'auto.length'        => 'required_if:selected,truck',
            'login'              => [
                'required',
                'email',
                'min:6',
                'string',
                'required_unless:only_selected,trailer',
                Rule::unique('transports', 'login')->where(function ($query) {
                    $query->where('deleted_at', null);
                })->ignore($this->segment(2)),
                'regex:/^[A-Za-z0-9@.]+$/'
            ],
            'password'           => 'required|min:6|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            'gps_id'        => [
	            'nullable',
	            Rule::unique('transports', 'gps_id')
	                ->where(function ($query) {
		                $query->whereNull('deleted_at');
	                })
	                ->ignore($this->segment(2)),
            ],
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
