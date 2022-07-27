<?php

namespace App\Http\Requests;

class ForgetPasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => helper()->translate('validator.Required'),
            'email.email'    => helper()->translate('validator.Email'),
            'email.exists'   => helper()->translate('validator.Exists'),
        ];
    }
}
