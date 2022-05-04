<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsStore extends FormRequest
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
//        dd($this->request->all());

        return [

            'check'              => 'nullable|boolean',

            // for company && for individual
            "type"                  => 'required',
            "name"                  => 'required',
            "phone"                 => 'required',
            "email"                 => 'required',
            "address_country"       => 'required',
            "address_index"         => 'required',
            "address_region"        => 'required',
            "address_city"          => 'required',
            "address_street"        => 'required',
            "address_number"        => 'required',
            "payment_account"       => 'required',
            "inn"                   => 'required',

            // for company
            "delegate_name"         => 'required_if:type,company',
            "address_legal_country" => 'required_if:type,company',
            "address_legal_index"   => 'required_if:type,company',
            "address_legal_region"  => 'required_if:type,company',
            "address_legal_city"    => 'required_if:type,company',
            "address_legal_street"  => 'required_if:type,company',
            "address_legal_number"  => 'required_if:type,company',
            "address_post_country"  => 'nullable',
            "address_post_index"    => 'nullable',
            "address_post_region"   => 'nullable',
            "address_post_city"     => 'nullable',
            "address_post_street"   => 'nullable',
            "address_post_number"   => 'nullable',
            "egrpou"                => 'required_if:type,company',
            "site_url"              => 'nullable',
            "description"           => 'nullable',
        ];
//        return [];
    }

    public function messages()
    {
        return [
            'required_if' => trans('validation.required'),
        ];
    }
}
