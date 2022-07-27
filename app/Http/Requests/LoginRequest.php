<?php

namespace App\Http\Requests;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => helper()->translate('validator.Required'),
            'email.email'    => helper()->translate('validator.CurrentLabel', ':label', helper()->translate('login.Label.Email')),
            'email.exists'   => helper()->translate('validator.HasNoLabel', ':label', helper()->translate('login.Label.Email')),
            'password.required' => helper()->translate('validator.Required'),
        ];
    }
}
