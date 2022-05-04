<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class PasswordValid implements Rule
{
    public function passes($attribute, $value){
        return preg_match('/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $value);
    }

    public function message()
    {
        return trans ('validation.staff.password_regex');
    }
}