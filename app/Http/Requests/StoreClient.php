<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'name'       => 'required|string|max:60',
//            'companyName'       => 'required|string|max:20',
//            'position'       => 'required|string|max:20',
//            'condition'       => 'required|string|max:20',
//            'country'       => 'required|string|max:15',
//            'city'       => 'required|string|max:15',
//            'street'       => 'required|string|max:15',
//            'skype'       => 'required|string|max:15',
//            'index'       => 'required|max:20',
//            'order.number'       => 'required|max:20',
            'phone1'         => 'nullable|min:1|max:13',
            'email'           => 'required|email',
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
            //
        ];
    }
}
