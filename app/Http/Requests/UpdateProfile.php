<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
        if (isset($this->document) && $this->document == 1) {
            return [
                'images.*.*.*'  => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
            ];
        } else {
            return [
                'name'          => 'required|max:255',
                'email'         => 'required|email',
                'images.*.*.*'  => 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2048',
                'role'          => 'required',
                'delegate_name' => 'required_if:role,client-company|required_if:role,logistic-company',
                'egrpou_or_inn' => 'required_if:role,client-company|required_if:role,logistic-company',
            ];
        }

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'              => strpos($this->get('role'), 'company') ? trans('validation.company_name_required') : trans('validation.name_required'),
            'name.max'                   => trans('validation.name_max'),
            'email.required'             => trans('validation.email_required'),
            'delegate_name.required_if'  => trans('validation.name_required'),
            'egrpou_or_inn.required_if'  => trans('validation.egrpou_required'),
        ];
    }
}
