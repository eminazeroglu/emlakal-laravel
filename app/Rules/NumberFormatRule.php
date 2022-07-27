<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberFormatRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $phone = preg_replace('/[^0-9]/', '', $value);
        return strlen($phone) === 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return helper()->translate('validator.PhoneFormat');
    }
}
