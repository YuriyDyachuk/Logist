<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Feedback extends FormRequest
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
            'name'    => 'required|string',
            'email'   => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
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
            'name.required'    => trans('validation.short_required'),
            'email.required'   => trans('validation.short_required'),
            'email.email'      => trans('validation.data_error'),
            'subject.required' => trans('validation.short_required'),
            'message.required' => trans('validation.short_required'),
        ];
    }
}
