<?php

namespace App\Http\Requests;

use App\Rules\ImageBase64Rule;

class UserRequest extends ApiRequest
{
    public function __construct()
    {
        parent::__construct('user');
    }

    public function rules(): array
    {
        return [
            'email'         => ['required', 'email', 'unique:users,email' . ($this->user ? ',' . $this->user : '')],
            'password'      => [$this->id ? 'nullable' : 'required'],
            'permission_id' => ['nullable', 'exists:permission_groups,id'],
            'language'      => ['nullable', 'exists:languages,code'],
            'name'          => ['required'],
            'surname'       => ['required'],
            'photo_name'    => ['nullable', new ImageBase64Rule],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'       => helper()->translate('validator.Required'),
            'email.email'          => helper()->translate('validator.Email'),
            'email.unique'         => helper()->translate('validator.Unique'),
            'permission_id.exists' => helper()->translate('validator.Exists'),
            'language.exists'      => helper()->translate('validator.Exists'),
            'password.required'    => helper()->translate('validator.Required'),
            'name.required'        => helper()->translate('validator.Required'),
            'surname.required'     => helper()->translate('validator.Required'),
            'photo.base64image'    => helper()->translate('validator.Image'),
        ];
    }
}
