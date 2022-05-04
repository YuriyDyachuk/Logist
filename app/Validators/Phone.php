<?php

namespace App\Validators;

class Phone
{
    public function validate($attribute, $value, $parameters, $validator) {
        return preg_match('/^\+[1-9]{1}[0-9]{3,14}$/', $value);
    }
}
