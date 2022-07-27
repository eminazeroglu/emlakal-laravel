<?php

namespace App\Http\Requests;

class TranslateRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'language';
    }

    public function rules(): array
    {
        return [
            '*.text' => 'required',
            '*.key'  => 'required|exists:translates,key'
        ];
    }

    public function messages(): array
    {
        return [
            '*.text.required' => helper()->translate('validator.Required'),
            '*.key.required'  => helper()->translate('validator.Required'),
            '*.key.exists'    => helper()->translate('validator.Exists'),
        ];
    }
}
