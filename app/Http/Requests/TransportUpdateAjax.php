<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TransportUpdateAjax extends FormRequest
{
    private $val;

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
    public function rules(Request $request)
    {
        $this->val = $request->field;

        if($request->field	== 'password')
        {
            return [
                'val'  => 'required|min:8|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            ];
        }

        if($request->field	== 'login')
        {
            return [
                'val'  => 'required|email|min:6|unique:transports,login,'.$this->id.',id|regex:/^[A-Za-z0-9@.]+$/',
            ];
        }

	    if($request->field	== 'active')
	    {
		    return [
			    'val'  => 'required',
		    ];
	    }

	    if($request->field	== 'trailer' || $request->field == 'driver' || $request->field == 'truck' || $request->field == 'status_id')
	    {
		    return [
			    'val'  => 'required',
		    ];
	    }

        return [];
    }

    public function messages()
    {
        if($this->field	== 'password'){
            return [
                'val.regex'   => trans('validation.staff.password_regex'),
            ];
        }

        if($this->field	== 'login'){
            return [
                'val.regex'   => trans('validation.driver_login'),
            ];
        }

	    if($this->field	== 'active' || $this->field	== 'trailer' || $this->field == 'driver' || $this->field == 'truck' || $this->field == 'status_id'){
		    return [
			    'val.required'   => '',
		    ];
	    }
    }
}
