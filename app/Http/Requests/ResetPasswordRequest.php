<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'hash'      => 'required',
            'password'  => 'required',
            'rpassword' => 'required_with:password|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'hash.required'           => helper()->translate('validator.Required'),
            'password.required'       => helper()->translate('validator.Required'),
            'rpassword.required_with' => helper()->translate('validator.Required'),
            'rpassword.same'          => helper()->translate('validator.PasswordSame'),
        ];
    }
}
