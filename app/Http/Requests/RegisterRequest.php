<?php

namespace App\Http\Requests;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'rpassword' => 'required_with:password|same:password',
            'name'      => 'required',
            'surname'   => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'          => helper()->translate('validator.Required'),
            'email.email'             => helper()->translate('validator.Email'),
            'email.unique'            => helper()->translate('validator.Unique'),
            'password.required'       => helper()->translate('validator.Required'),
            'rpassword.required_with' => helper()->translate('validator.Required'),
            'rpassword.same'          => helper()->translate('validator.PasswordSame'),
            'name.required'           => helper()->translate('validator.Required'),
            'surname.required'        => helper()->translate('validator.Required'),
        ];
    }
}
