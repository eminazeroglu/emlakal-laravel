<?php

namespace App\Http\Requests;

class TranslateRemoveKeyRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'language';
    }

    public function rules(): array
    {
        return [
            'key' => 'required|exists:translates,key'
        ];
    }

    public function messages(): array
    {
        return [
            'key.exists' => helper()->translate('validator.Exists'),
        ];
    }
}
