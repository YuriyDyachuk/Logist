<?php

namespace App\Http\Requests;

use function foo\func;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class StoreAddUser extends FormRequest
{
    private $role;
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

        $this->role = $request->role;

        return [
            'name'          => 'required|max:255',
            'email'         => [
                'required',
                'email',
                'unique:users,email'
//                Rule::unique('users', 'email')->where(function ($query) {
//                    return $query->where('invited', 0);
//                }),
            ],
            'password'      => 'required|confirmed|min:8|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
//            'phone'         => 'required|unique:users,phone',
            'license'       => 'accepted',
            'role'          => 'required',
//            'delegate_name' => 'required_if:role,client-company|required_if:role,logistic-company',
            //'egrpou_or_inn' => 'required_if:role,client-company|required_if:role,logistic-company',
            'g-recaptcha-response'=>'required|recaptcha:'.config('captcha.google_recaptcha_flag_secret')
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
            'password.min'              => trans('validation.password_regex'),
            'password.regex'            => trans('validation.password_regex'),
            'password.required'         => trans('validation.password_regex'),
            'password.confirmed'         => trans('validation.password_confirmed'),
            'phone.regex'               => trans('validation.phone_regex'),
            'name.required'             => $this->role === 'logistic-person' ? trans('validation.company_name_required') : trans('validation.name_required'),
            'name.max'                  => trans('validation.name_max'),
            'email.required'            => trans('validation.email_required'),
            'phone.required'            => trans('validation.phone_required'),
            'email.unique'              => trans('validation.email_unique'),
            'phone.unique'              => trans('validation.phone_unique'),
            'license.accepted'          => trans('validation.license_accepted'),
            'delegate_name.required_if' => trans('validation.name_required'),
            'egrpou_or_inn.required_if' => trans('validation.egrpou_required'),
            'g-recaptcha-response.required' => trans('validation.recaptcha'),
            'recaptcha'                 => trans('validation.recaptcha'),
        ];
    }
}
