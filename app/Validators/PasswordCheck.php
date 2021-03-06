<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class PasswordCheck implements Rule
{
    public function passes($attribute, $value){
        $user = auth()->user();
        return Hash::check($value, $user->password);
    }

    public function message()
    {
        return trans ('all.password_incorrect');
    }
}