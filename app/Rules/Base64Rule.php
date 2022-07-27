<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Rule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $value)) return true;
        else return false;
    }

    public function message(): string
    {
        return 'The validation error message.';
    }
}
