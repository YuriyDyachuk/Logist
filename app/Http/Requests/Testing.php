<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Testing extends FormRequest
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
        $type  = 'phone';
        $rules = ['required', 'string'];

        if (preg_match('/@/', $this->get('from'))) {
            $type = 'email';
            array_push($rules, 'email');
        } else {
            array_push($rules, 'regex:/^[+]?([\d\s\(\)-]+){9,30}$/');
        }

        $this->request->add(['type' => $type]);

        return ['from' => $rules];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from.required'         => trans('validation.required'),
            'from.email'           => trans('validation.email'),
            'from.regex'           => trans('validation.phone'),
        ];
    }
}
