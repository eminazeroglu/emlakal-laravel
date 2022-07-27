<?php

namespace App\Http\Requests;

use App\Models\Language;
use App\Services\Models\UserService;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return helper()->can() > 1;
    }

    public function rules(): array
    {
        validator()->extend('check_password', function ($attr, $value) {
            $user = (new UserService())->getByToken();
            return Hash::check($value, $user->password);
        });
        validator()->extend('language_exists', function ($attr, $value) {
            $language = Language::active()->whereCode($value)->first();
            return (bool)$language;
        });
        return [
            'name'         => 'required',
            'surname'      => 'required',
            'photo'        => 'nullable|base64image',
            'old_password' => 'required|check_password',
            'language'     => 'required|language_exists',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'               => helper()->translate('validator.Required'),
            'surname.required'            => helper()->translate('validator.Required'),
            'photo.required'              => helper()->translate('validator.Required'),
            'old_password.required'       => helper()->translate('validator.Required'),
            'old_password.check_password' => helper()->translate('validator.HasNoLabel', ':label', 'login.Label.Password'),
            'language.required'           => helper()->translate('validator.Required'),
            'language.language_exists'    => helper()->translate('validator.Exists'),
            'photo.base64image'           => helper()->translate('validator.Image'),
        ];
    }
}
